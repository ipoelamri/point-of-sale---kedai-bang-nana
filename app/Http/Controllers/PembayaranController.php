<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans Configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat Snap Token dan arahkan ke checkout Midtrans
     */
    public function createSnapToken(Order $order)
    {
        try {
            // Persiapan data untuk Midtrans
            $transactionDetails = [
                'order_id' => $order->no_order,
                'gross_amount' => $order->total_bayar,
            ];

            $customerDetails = [
                'first_name' => $order->nama_pelanggan,
                'email' => 'customer@example.com',  // Bisa ditambah ke order jika perlu
                'phone' => '08123456789',  // Bisa ditambah ke order jika perlu
            ];

            // Item details
            $items = [];
            foreach ($order->orderItems as $item) {
                $items[] = [
                    'id' => $item->menu->id_menu,
                    'price' => $item->harga_satuan,
                    'quantity' => $item->jumlah,
                    'name' => $item->menu->nama_menu,
                ];
            }

            $transactionData = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $items,
            ];

            // Generate Snap Token
            $snapToken = Snap::getSnapToken($transactionData);

            // Simpan snap token ke pembayaran
            $pembayaran = Pembayaran::firstOrCreate(
                ['order_id' => $order->id_order],
                [
                    'snap_token' => $snapToken,
                    'status_bayar' => 'pending',
                    'metode_bayar' => 'credit_card',  // Default
                ]
            );

            return view('order.snap-payment', compact('order', 'snapToken', 'pembayaran'));
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat pembayaran. ' . $e->getMessage());
        }
    }

    /**
     * Webhook Callback dari Midtrans
     */
    public function webhookCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            Log::warning('Invalid signature from Midtrans webhook');
            return response()->json(['status' => 'error'], 403);
        }

        $orderId = explode('-', $request->order_id)[0] ?? null;  // Ambil bagian pertama dari no_order
        $order = Order::where('no_order', $request->order_id)->first();

        if (!$order) {
            Log::warning('Order not found: ' . $request->order_id);
            return response()->json(['status' => 'error'], 404);
        }

        $pembayaran = Pembayaran::where('order_id', $order->id_order)->first();

        if (!$pembayaran) {
            Log::warning('Pembayaran not found for order: ' . $order->id_order);
            return response()->json(['status' => 'error'], 404);
        }

        // Update status berdasarkan response Midtrans
        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            $pembayaran->update([
                'status_bayar' => 'lunas',
                'metode_bayar' => $request->payment_type,
                'midtrans_log' => json_encode($request->all()),
                'waktu_bayar' => now(),
            ]);
            $order->update(['status_order' => 'lunas']);
        } elseif ($request->transaction_status == 'pending') {
            $pembayaran->update([
                'status_bayar' => 'pending',
                'metode_bayar' => $request->payment_type,
                'midtrans_log' => json_encode($request->all()),
            ]);
        } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'cancel' || $request->transaction_status == 'expire') {
            $pembayaran->update([
                'status_bayar' => 'gagal',
                'metode_bayar' => $request->payment_type,
                'midtrans_log' => json_encode($request->all()),
            ]);
            $order->update(['status_order' => 'pending']);
        }

        Log::info('Webhook processed for order: ' . $request->order_id . ', status: ' . $request->transaction_status);

        return response()->json(['status' => 'ok']);
    }

    /**
     * Redirect setelah pembayaran di Midtrans (Finish/Error)
     */
    public function finishPayment(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::where('no_order', $orderId)->first();

        if (!$order) {
            return redirect('/menu')->with('error', 'Order tidak ditemukan');
        }

        $pembayaran = Pembayaran::where('order_id', $order->id_order)->first();

        if ($pembayaran && $pembayaran->status_bayar == 'lunas') {
            session()->forget('cart');
            return view('order.success', compact('order', 'pembayaran'));
        } else {
            return view('order.pending', compact('order', 'pembayaran'));
        }
    }

    /**
     * Proses Pembayaran Tunai
     * Membuat record pembayaran dengan metode tunai dan menunggu konfirmasi kasir
     */
    public function processCash(Order $order)
    {
        // Cek apakah sudah ada pembayaran untuk order ini
        $pembayaran = Pembayaran::where('order_id', $order->id_order)->first();

        if ($pembayaran && $pembayaran->status_bayar === 'lunas') {
            return redirect()->route('menu.public')->with('success', 'Pesanan ini sudah dibayar.');
        }

        // Buat atau update record pembayaran
        $pembayaran = Pembayaran::updateOrCreate(
            ['order_id' => $order->id_order],
            [
                'metode_bayar' => 'tunai',
                'status_bayar' => 'menunggu_kasir',
                'snap_token' => null,
            ]
        );

        // Hapus cart dari session
        session()->forget('cart');

        return view('order.cash-confirmation', compact('order', 'pembayaran'));
    }

    /**
     * Kasir mengkonfirmasi pembayaran tunai (dari dashboard kasir)
     */
    public function confirmCash(Request $request, Order $order)
    {
        $pembayaran = Pembayaran::where('order_id', $order->id_order)->first();

        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $pembayaran->update([
            'status_bayar' => 'lunas',
            'waktu_bayar' => now(),
        ]);

        $order->update(['status_order' => 'lunas']);

        return back()->with('success', 'Pembayaran tunai untuk pesanan ' . $order->no_order . ' telah dikonfirmasi.');
    }
}

