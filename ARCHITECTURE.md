# 🏗️ Arsitektur Fitur Pelanggan Terbaik

## System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                      USER INTERFACE LAYER                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────────┐         ┌──────────────────────┐      │
│  │  HALAMAN UTAMA       │         │  HALAMAN DETAIL      │      │
│  │  (index.blade.php)   │◄────────│  (show.blade.php)    │      │
│  │                      │         │                      │      │
│  │  • Stats Cards       │         │  • Customer Stats    │      │
│  │  • Filter Form       │         │  • Order History     │      │
│  │  • Ranking Table     │         │  • Period Filter     │      │
│  │  • Pagination        │         │  • Links to Orders   │      │
│  │  • Export CSV        │         │  • Pagination        │      │
│  └──────────────────────┘         └──────────────────────┘      │
│           │                                  │                   │
└───────────┼──────────────────────────────────┼───────────────────┘
            │                                  │
            ▼                                  ▼
┌─────────────────────────────────────────────────────────────────┐
│                      ROUTING LAYER                               │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  GET /best-customer                 → index (List)              │
│  GET /best-customer/{customerName}  → show (Detail)             │
│  GET /best-customer/export/csv      → export (Download)         │
│                                                                   │
│  Middleware: auth (All routes)                                   │
│  Accessible: admin, kasir, pemilik                              │
└─────────────────────────────────────────────────────────────────┘
            │                                  │
            ▼                                  ▼
┌─────────────────────────────────────────────────────────────────┐
│                    CONTROLLER LAYER                              │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│        BestCustomerController                                   │
│        ┌─────────────────────────────────────────┐              │
│        │                                         │              │
│        │  index()                                │              │
│        │  • Filter periode                       │              │
│        │  • Sort options                         │              │
│        │  • Query aggregation                    │              │
│        │  • Pagination (15/page)                 │              │
│        │  • Return view with stats               │              │
│        │                                         │              │
│        │  show()                                 │              │
│        │  • Get customer name from URL           │              │
│        │  • Query customer orders                │              │
│        │  • Calculate customer stats             │              │
│        │  • Pagination for orders                │              │
│        │  • Return detail view                   │              │
│        │                                         │              │
│        │  export()                               │              │
│        │  • Query top customers                  │              │
│        │  • Format CSV                           │              │
│        │  • Stream response                      │              │
│        │  • Auto download                        │              │
│        │                                         │              │
│        └─────────────────────────────────────────┘              │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
            │                                  │
            ▼                                  ▼
┌─────────────────────────────────────────────────────────────────┐
│                      MODEL LAYER                                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│         Order::query()                                           │
│         ├─ where('status_order', 'selesai')                     │
│         ├─ where('created_at', '>=', $startDate)                │
│         ├─ where('nama_pelanggan', '!=', '')                    │
│         ├─ select([                                             │
│         │   'nama_pelanggan',                                   │
│         │   DB::raw('COUNT(id_order) as total_orders')          │
│         │   DB::raw('SUM(total_bayar) as total_spending')       │
│         │   DB::raw('AVG(total_bayar) as avg_spending')         │
│         │   DB::raw('MAX(created_at) as last_order_date')       │
│         │   DB::raw('MIN(created_at) as first_order_date')      │
│         │ ])                                                    │
│         ├─ groupBy('nama_pelanggan')                            │
│         ├─ orderBy(...) // based on sort option                │
│         └─ paginate(15)                                         │
│                                                                   │
│         Relationships:                                           │
│         • Order.hasMany(OrderItem)                              │
│         • Order.hasOne(Pembayaran)                              │
│         • Order.belongsTo(User)                                 │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
            │
            ▼
┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE LAYER                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│   ORDERS TABLE                                                   │
│   ┌────────────────────────────────────────┐                    │
│   │ id_order                               │◄─ Primary Key      │
│   │ no_order                               │                    │
│   │ nama_pelanggan  ◄─────────────────────┐│                    │
│   │ total_bayar     ◄─────────────────────┼│ Aggregated         │
│   │ status_order = 'selesai'  ◄───────────┼│ for stats          │
│   │ created_at      ◄─────────────────────┼│                    │
│   │ tipe_pesanan                           │                    │
│   │ no_meja                                │                    │
│   │ user_id_kasir                          │                    │
│   │ timestamps                             │                    │
│   └────────────────────────────────────────┘                    │
│                                                                   │
│   PEMBAYARANS TABLE      ORDERITEMS TABLE   USERS TABLE         │
│   ┌──────────────┐       ┌──────────────┐   ┌──────────────┐   │
│   │ order_id │───────├─────│ order_id     │   │ id_user      │   │
│   │ status   │       │     │ menu_id      │   │ username     │   │
│   │ metode   │       │     │ qty          │   │ role         │   │
│   │ ...      │       │     │ harga        │   │ ...          │   │
│   └──────────┘       │     └──────────────┘   └──────────────┘   │
│                      │                                            │
│                      └─ Referenced                              │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Data Flow Diagram

```
┌─────────────┐
│  USER LOGIN │
└──────┬──────┘
       │
       ▼
┌──────────────────────────────────────┐
│  NAVIGATION: Click "Pelanggan Terbaik"│
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Laravel Routing                      │
│  Match: GET /best-customer            │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  BestCustomerController::index()      │
│                                       │
│  1. Get filter parameters:            │
│     - period (7/30/60/90/365)        │
│     - sort_by (spending/orders/date)  │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Build Query:                         │
│                                       │
│  Order::where('status_order','selesai')│
│       ->where('created_at', >= date) │
│       ->select aggregates             │
│       ->groupBy('nama_pelanggan')    │
│       ->orderBy(sort_option)          │
│       ->paginate(15)                  │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Database Query Execution             │
│                                       │
│  SELECT                               │
│    nama_pelanggan,                   │
│    COUNT(...) total_orders,           │
│    SUM(...) total_spending,           │
│    AVG(...) avg_spending,             │
│    MAX(...) last_order_date,          │
│    MIN(...) first_order_date          │
│  FROM orders                          │
│  WHERE status_order='selesai' AND ... │
│  GROUP BY nama_pelanggan              │
│  ORDER BY ...                         │
│  LIMIT 15 OFFSET ...                  │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Prepare View Data:                   │
│                                       │
│  - bestCustomers (paginated)          │
│  - summaryStats (totals)              │
│  - period (selected)                  │
│  - sortBy (selected)                  │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Render Blade Template:               │
│  resources/views/best-customer/      │
│  index.blade.php                      │
│                                       │
│  • Echo stats cards                   │
│  • Echo filter form                   │
│  • Loop through customers             │
│  • Add ranking badges                 │
│  • Echo pagination links              │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Return HTML Response (200)           │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  Browser Renders Page                 │
│  with Tailwind CSS Styling            │
└──────────────────────────────────────┘


USER ACTIONS:
═════════════

[Filter Submitted]
       │
       ▼
Same flow as above but with new parameters

[Export CSV Button]
       │
       ▼
GET /best-customer/export/csv
       │
       ▼
Query top customers, generate CSV, stream download

[Click "Lihat Detail"]
       │
       ▼
GET /best-customer/{customerName}
       │
       ▼
BestCustomerController::show()
       │
       ▼
Query customer's orders with details
       │
       ▼
Render show.blade.php with order history
```

---

## File Structure Overview

```
POS-KEDAI-BANG-NANA/
│
├── app/Http/Controllers/
│   └── BestCustomerController.php ✨ NEW
│       ├── index()
│       ├── show()
│       └── export()
│
├── resources/views/
│   ├── best-customer/ ✨ NEW FOLDER
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   │
│   └── layouts/
│       └── app.blade.php (MODIFIED)
│           └── Added menu link
│
├── routes/
│   └── web.php (MODIFIED)
│       ├── Import BestCustomerController
│       └── Added 3 routes
│
├── database/migrations/
│   └── (No new migrations - uses existing tables)
│
└── Documentation/ ✨ NEW
    ├── BEST_CUSTOMER_FEATURE.md
    ├── IMPLEMENTATION_SUMMARY.md
    ├── QUICK_START_BEST_CUSTOMER.md
    ├── IMPLEMENTATION_CHECKLIST.md
    └── ARCHITECTURE.md
```

---

## Security & Permission Flow

```
USER REQUEST
    │
    ▼
Middleware: auth
    │
    Is User Login?
    ├─ NO  → Redirect to /login
    └─ YES → Continue
         │
         ▼
    Route Passes
    │
    ▼
BestCustomerController
    │
    ▼
Database Query
    │
    Filter by:
    ├─ status_order = 'selesai'    (only completed orders)
    ├─ nama_pelanggan != ''         (exclude empty)
    ├─ created_at >= $startDate     (period filter)
    └─ Authorization check         (all roles: admin/kasir/pemilik)
    │
    ▼
Return Data via View
    │
    ▼
Blade Template Escaping
    │
    ├─ {{ }} - Auto escape XSS
    ├─ {{ }} with URL encoding for customer names
    └─ CSRF token on forms
    │
    ▼
Render Safe HTML
```

---

## Performance Considerations

```
OPTIMIZATION STRATEGIES:
════════════════════════

1. DATABASE LEVEL
   ├─ Aggregation in SELECT (COUNT, SUM, AVG, MAX, MIN)
   ├─ GROUP BY on nama_pelanggan
   ├─ WHERE filters before GROUP BY
   ├─ Indexes on:
   │  ├─ orders.status_order ('selesai')
   │  ├─ orders.created_at (for date range)
   │  └─ orders.nama_pelanggan (for grouping)
   └─ No JOIN required (single table query)

2. APPLICATION LEVEL
   ├─ Pagination (15 items per page)
   ├─ Select only needed columns
   ├─ No N+1 queries
   ├─ Eager loading where needed
   └─ Pagination vs LIMIT

3. CACHING OPPORTUNITY (Future)
   ├─ Cache::remember('best_customers_30', 60, function)
   ├─ Cache invalidation on new orders
   └─ Invalidate on order status changes

4. FRONTEND OPTIMIZATION
   ├─ Tailwind CSS built-in classes
   ├─ No heavy JavaScript
   ├─ Alpine.js for light interactivity
   └─ Icons via SVG (inline)

QUERY TIME ESTIMATE:
════════════════════
Small DB (1K orders)    : ~10-50ms
Medium DB (10K orders)  : ~50-200ms
Large DB (100K orders)  : ~200-500ms (with proper indexes)
```

---

## Extension Points (Future)

```
POSSIBLE ENHANCEMENTS:
══════════════════════

1. CHART DISPLAY
   ├─ Add Chart.js/D3.js
   ├─ Pie chart: Top 5 customers
   ├─ Bar chart: Revenue trend
   └─ Line chart: Customer growth

2. ADVANCED FILTERING
   ├─ Filter by tipe_pesanan
   ├─ Filter by payment method
   ├─ Date range picker
   └─ Custom date ranges

3. CUSTOMER SEGMENTATION
   ├─ VIP (high spending)
   ├─ Regular (moderate)
   ├─ Dormant (not active)
   └─ At-risk (spending decreased)

4. LOYALTY FEATURES
   ├─ Reward points system
   ├─ Loyalty badges
   ├─ Milestone alerts
   └─ Promotional codes

5. EMAIL INTEGRATION
   ├─ Notify top customers
   ├─ Send special offers
   ├─ Birthday promotions
   └─ Win-back campaigns

6. MOBILE APP
   ├─ REST API endpoints
   ├─ Same analytics data
   ├─ Push notifications
   └─ Loyalty points tracking
```

---

**Last Updated**: March 1, 2026
**Version**: 1.0
**Status**: Complete ✅
