@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@push('styles')
<style>
    #live-clock { font-variant-numeric: tabular-nums; }
    .kpi-card {
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .kpi-card::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 0.35s ease;
        border-radius: inherit;
    }
    .kpi-card:hover { transform: translateY(-6px); }
    .kpi-card:hover::before { opacity: 1; }
    .kpi-card:hover .kpi-icon-wrap { transform: scale(1.12) rotate(-6deg); }
    .kpi-revenue::before  { box-shadow: inset 0 0 60px rgba(16,185,129,0.1); }
    .kpi-orders::before   { box-shadow: inset 0 0 60px rgba(59,130,246,0.1); }
    .kpi-pending::before  { box-shadow: inset 0 0 60px rgba(245,158,11,0.1); }
    .kpi-avg::before      { box-shadow: inset 0 0 60px rgba(139,92,246,0.1); }
    .kpi-icon-wrap { transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
    .rank-1 { background: linear-gradient(135deg,#f59e0b,#d97706); }
    .rank-2 { background: linear-gradient(135deg,#94a3b8,#64748b); }
    .rank-3 { background: linear-gradient(135deg,#cd7c3a,#a16207); }
    .rank-other { background: rgba(100,116,139,0.25); }
    .progress-track {
        height: 4px;
        background: rgba(148,163,184,0.1);
        border-radius: 9999px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 9999px;
        background: linear-gradient(90deg,#ec4899,#a855f7);
        transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .chart-wrap { position: relative; }
    .chart-badge {
        padding: 0.2rem 0.6rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.8); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    .pulse-dot { position: relative; display: inline-flex; }
    .pulse-dot::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 9999px;
        background: #34d399;
        animation: pulse-ring 1.8s ease-out infinite;
    }
    @keyframes section-in {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .s1 { animation: section-in 0.55s 0.05s ease-out both; }
    .s2 { animation: section-in 0.55s 0.12s ease-out both; }
    .s3 { animation: section-in 0.55s 0.20s ease-out both; }
    .s4 { animation: section-in 0.55s 0.28s ease-out both; }
</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="s1 mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <div class="mb-1 flex items-center gap-2">
            <span class="pulse-dot h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
            <span class="text-xs font-semibold uppercase tracking-widest text-emerald-400">Live</span>
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight text-white">Laporan Pendapatan</h1>
        <p class="mt-1.5 text-sm text-slate-400">
            Periode: <strong class="text-slate-200">{{ \Carbon\Carbon::createFromDate($thisYear, $thisMonth, 1)->translatedFormat('F Y') }}</strong>
            &nbsp;·&nbsp;<span id="live-clock" class="text-slate-400"></span>
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('pemilik.export') }}" id="btn-export"
           class="btn btn-primary group gap-2 px-5 py-2.5 text-sm shadow-lg shadow-pink-500/20">
            <svg class="h-4 w-4 transition-transform duration-200 group-hover:-translate-y-0.5 group-hover:translate-x-0.5"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export Laporan
        </a>
    </div>
</div>

{{-- KPI CARDS --}}
<div class="s2 stagger-children mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

    <div class="kpi-card kpi-revenue glass-card rounded-2xl p-5">
        <div class="mb-4 flex items-start justify-between">
            <div class="kpi-icon-wrap flex h-11 w-11 items-center justify-center rounded-xl gradient-success shadow-lg shadow-emerald-500/25">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="badge badge-success text-[10px]">Bulan Ini</span>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pendapatan</p>
        <p class="mt-1.5 text-2xl font-extrabold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <div class="mt-3 progress-track">
            <div class="progress-fill" style="width:{{ min(100, $totalRevenue > 0 ? 75 : 0) }}%"></div>
        </div>
    </div>

    <div class="kpi-card kpi-orders glass-card rounded-2xl p-5">
        <div class="mb-4 flex items-start justify-between">
            <div class="kpi-icon-wrap flex h-11 w-11 items-center justify-center rounded-xl gradient-info shadow-lg shadow-blue-500/25">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <span class="badge badge-info text-[10px]">Bulan Ini</span>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Pesanan</p>
        <p class="mt-1.5 text-2xl font-extrabold text-white">{{ number_format($totalOrders) }}</p>
        <div class="mt-3 progress-track">
            <div class="progress-fill" style="width:{{ min(100, $totalOrders > 0 ? 60 : 0) }}%; background: linear-gradient(90deg,#3b82f6,#2563eb)"></div>
        </div>
    </div>

    <div class="kpi-card kpi-pending glass-card rounded-2xl p-5">
        <div class="mb-4 flex items-start justify-between">
            <div class="kpi-icon-wrap flex h-11 w-11 items-center justify-center rounded-xl gradient-secondary shadow-lg shadow-amber-500/25">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="badge badge-warning text-[10px]">Pending</span>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Menunggu Pembayaran</p>
        <p class="mt-1.5 text-2xl font-extrabold text-white">Rp {{ number_format($pendingPayments, 0, ',', '.') }}</p>
        <div class="mt-3 progress-track">
            <div class="progress-fill" style="width:{{ min(100, $pendingPayments > 0 ? 45 : 0) }}%; background: linear-gradient(90deg,#f59e0b,#d97706)"></div>
        </div>
    </div>

    <div class="kpi-card kpi-avg glass-card rounded-2xl p-5">
        <div class="mb-4 flex items-start justify-between">
            <div class="kpi-icon-wrap flex h-11 w-11 items-center justify-center rounded-xl gradient-accent shadow-lg shadow-violet-500/25">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="badge badge-neutral text-[10px]">Avg</span>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Rata-rata / Transaksi</p>
        <p class="mt-1.5 text-2xl font-extrabold text-white">
            Rp {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : '0' }}
        </p>
        <div class="mt-3 progress-track">
            <div class="progress-fill" style="width:{{ $totalOrders > 0 ? 55 : 0 }}%; background: linear-gradient(90deg,#a855f7,#7c3aed)"></div>
        </div>
    </div>
</div>

{{-- CHARTS ROW 1 --}}
<div class="s3 mb-6 grid grid-cols-1 gap-6 lg:grid-cols-5">
    <div class="chart-wrap glass-card rounded-2xl p-6 lg:col-span-3">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Pendapatan Harian</h3>
                <p class="text-xs text-slate-500">30 hari terakhir</p>
            </div>
            <span class="chart-badge bg-pink-500/15 text-pink-400">Line Chart</span>
        </div>
        <canvas id="dailyChart" height="160"></canvas>
    </div>
    <div class="chart-wrap glass-card rounded-2xl p-6 lg:col-span-2">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Pendapatan Bulanan</h3>
                <p class="text-xs text-slate-500">12 bulan terakhir</p>
            </div>
            <span class="chart-badge bg-blue-500/15 text-blue-400">Bar Chart</span>
        </div>
        <canvas id="monthlyChart" height="160"></canvas>
    </div>
</div>

{{-- CHARTS ROW 2 --}}
<div class="s4 grid grid-cols-1 gap-6 lg:grid-cols-5">
    <div class="glass-card overflow-hidden rounded-2xl lg:col-span-3">
        <div class="flex items-center justify-between border-b border-white/5 px-6 py-4">
            <div>
                <h3 class="text-base font-bold text-white">🏆 5 Menu Terlaris</h3>
                <p class="text-xs text-slate-500">Bulan {{ \Carbon\Carbon::createFromDate($thisYear, $thisMonth, 1)->translatedFormat('F Y') }}</p>
            </div>
            <span class="badge badge-success text-[10px]">Top Menu</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-500">#</th>
                        <th class="px-5 py-3 text-left text-[10px] font-semibold uppercase tracking-wider text-slate-500">Menu</th>
                        <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-slate-500">Qty</th>
                        <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-slate-500">Revenue</th>
                        <th class="px-5 py-3 text-right text-[10px] font-semibold uppercase tracking-wider text-slate-500">Share</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php $maxRev = $topMenus->max('total_revenue') ?: 1; @endphp
                    @forelse ($topMenus as $i => $menu)
                        <tr class="group transition-colors duration-150 hover:bg-white/[0.03]">
                            <td class="px-5 py-3.5">
                                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-[10px] font-bold text-white
                                    {{ $i === 0 ? 'rank-1' : ($i === 1 ? 'rank-2' : ($i === 2 ? 'rank-3' : 'rank-other')) }}">
                                    {{ $i + 1 }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-medium text-slate-200 transition-colors group-hover:text-white">{{ $menu->nama_menu }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="font-semibold text-blue-400">{{ number_format($menu->total_qty) }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="font-semibold text-emerald-400">Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-right w-28">
                                <div class="flex items-center justify-end gap-2">
                                    <div class="w-14 progress-track">
                                        <div class="progress-fill" style="width:{{ round(($menu->total_revenue / $maxRev) * 100) }}%"></div>
                                    </div>
                                    <span class="w-7 text-right text-[10px] text-slate-500">{{ round(($menu->total_revenue / $maxRev) * 100) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-10 w-10 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <p class="text-sm font-medium text-slate-500">Belum ada data penjualan bulan ini</p>
                                    <p class="text-xs text-slate-600">Data akan muncul saat ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="chart-wrap glass-card rounded-2xl p-6 lg:col-span-2">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Distribusi Kategori</h3>
                <p class="text-xs text-slate-500">Pendapatan per kategori</p>
            </div>
            <span class="chart-badge bg-violet-500/15 text-violet-400">Doughnut</span>
        </div>
        @if (count($categoryLabels) > 0)
            <canvas id="categoryChart" height="200"></canvas>
        @else
            <canvas id="categoryChart" class="hidden"></canvas>
            <div class="flex flex-col items-center justify-center py-14 text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-800">
                    <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-400">Belum ada data kategori</p>
                <p class="mt-1 text-xs text-slate-600">Muncul saat ada transaksi bulan ini</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function clock() {
    const el = document.getElementById('live-clock');
    if (!el) return;
    const tick = () => { el.textContent = new Date().toLocaleTimeString('id-ID'); };
    tick(); setInterval(tick, 1000);
})();

Chart.defaults.color = '#94a3b8';
Chart.defaults.borderColor = 'rgba(148,163,184,0.07)';
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size = 11;
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(15,23,42,0.95)';
Chart.defaults.plugins.tooltip.borderColor = 'rgba(148,163,184,0.15)';
Chart.defaults.plugins.tooltip.borderWidth = 1;
Chart.defaults.plugins.tooltip.padding = 10;
Chart.defaults.plugins.tooltip.cornerRadius = 10;

function mkGrad(ctx, c1, c2) {
    const g = ctx.createLinearGradient(0, 0, 0, 280);
    g.addColorStop(0, c1); g.addColorStop(1, c2); return g;
}

(function() {
    const ctx = document.getElementById('dailyChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($dailyRevenue) !!},
                borderColor: '#ec4899',
                backgroundColor: mkGrad(ctx, 'rgba(236,72,153,0.25)', 'rgba(236,72,153,0.01)'),
                borderWidth: 2.5, fill: true, tension: 0.45,
                pointBackgroundColor: '#ec4899', pointBorderColor: '#0f172a',
                pointBorderWidth: 2, pointRadius: 3, pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => ' Rp ' + c.parsed.y.toLocaleString('id-ID') } } },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 7, maxRotation: 0 } },
                y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.06)' },
                     ticks: { callback: v => v >= 1e6 ? 'Rp '+(v/1e6).toFixed(1)+'jt' : 'Rp '+v.toLocaleString('id-ID') } }
            }
        }
    });
})();

(function() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode($monthlyRevenue) !!},
                backgroundColor: mkGrad(ctx, 'rgba(96,165,250,0.85)', 'rgba(37,99,235,0.5)'),
                borderColor: 'rgba(96,165,250,0.9)', borderWidth: 1,
                borderRadius: 8, borderSkipped: false,
                hoverBackgroundColor: 'rgba(96,165,250,1)',
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => ' Rp ' + c.parsed.y.toLocaleString('id-ID') } } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.06)' },
                     ticks: { callback: v => v >= 1e6 ? 'Rp '+(v/1e6).toFixed(1)+'jt' : 'Rp '+v.toLocaleString('id-ID') } }
            }
        }
    });
})();

@if (count($categoryLabels) > 0)
(function() {
    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($categoryLabels) !!},
            datasets: [{
                data: {!! json_encode($categoryValues) !!},
                backgroundColor: ['rgba(236,72,153,0.8)','rgba(96,165,250,0.8)','rgba(16,185,129,0.8)','rgba(245,158,11,0.8)','rgba(139,92,246,0.8)','rgba(234,179,8,0.8)'],
                borderColor: '#0f172a', borderWidth: 3, hoverBorderWidth: 0, hoverOffset: 8,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true, cutout: '68%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 14, boxWidth: 10, boxHeight: 10, borderRadius: 3, useBorderRadius: true } },
                tooltip: { callbacks: { label: c => ' Rp ' + c.parsed.toLocaleString('id-ID') } }
            }
        }
    });
})();
@endif

document.querySelectorAll('.progress-fill').forEach(bar => {
    const t = bar.style.width;
    bar.style.width = '0%';
    setTimeout(() => { bar.style.width = t; }, 400);
});
</script>
@endpush
