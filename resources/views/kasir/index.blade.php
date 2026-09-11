@extends('layouts.kasir')

@section('content')
<div class="kasir-wrapper">
    <div class="row g-4">
        <!-- ==========================================
            AREA 1: DAFTAR MENU & KATALOG PRODUK
            ========================================== -->
        <div class="col-lg-7 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">

                    <!-- Search & Filter Controls -->
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-between align-items-md-center mb-4">
                        <!-- Search Box -->
                        <div class="input-group search-input-group flex-grow-1" style="max-width: 360px;">
                            <span class="input-group-text bg-light border-0 ps-3">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="searchMenuInput" class="form-control bg-light border-0 py-2" placeholder="Cari menu makanan atau minuman...">
                        </div>

                        <!-- Info Item Count -->
                        <div class="text-muted small">
                            Tersedia <span class="fw-bold text-dark" id="productCount">{{ count($products) }}</span> item menu
                        </div>
                    </div>

                    <!-- Category Pills Filter -->
                    <div class="category-filter-wrapper mb-4 overflow-x-auto pb-1 d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-category-pill active" data-category="all">
                            <i class="bi bi-grid-fill me-1"></i> Semua Menu
                        </button>
                        @foreach($categories as $cat)
                            <button type="button" class="btn btn-sm btn-category-pill" data-category="{{ $cat->name }}">
                                @if(stripos($cat->name, 'coffee') !== false)
                                    <i class="bi bi-cup-hot-fill me-1"></i>
                                @elseif(stripos($cat->name, 'snack') !== false || stripos($cat->name, 'makan') !== false)
                                    <i class="bi bi-egg-fried me-1"></i>
                                @else
                                    <i class="bi bi-tag-fill me-1"></i>
                                @endif
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Product Grid Cards -->
                    <div class="row g-3" id="productGrid">
                        @forelse($products as $product)
                            @php
                                $catName = is_object($product->category) ? ($product->category->name ?? 'Menu') : 'Menu';
                                $imgSrc = !empty($product->photo) ? (str_starts_with($product->photo, 'http') ? $product->photo : asset('storage/' . ltrim(str_replace('storage/', '', $product->photo), '/'))) : null;
                                $iconClass = $product->icon ?? 'bi-cup-hot';
                                $accentColor = $product->color ?? '#072F1F';
                            @endphp
                            <div class="col-6 col-md-4 col-xl-3 product-item"
                                 data-id="{{ $product->id }}"
                                 data-name="{{ $product->name }}"
                                 data-price="{{ $product->price }}"
                                 data-category="{{ $catName }}"
                                 data-stock="{{ $product->stock }}">
                                <div class="card h-100 border product-card rounded-3 overflow-hidden text-decoration-none {{ $product->stock <= 0 ? 'bg-light out-of-stock-card opacity-75' : '' }}" style="{{ $product->stock <= 0 ? 'cursor: not-allowed; filter: grayscale(80%);' : '' }}">
                                    <!-- Image / Icon Header -->
                                    <div class="product-img-box d-flex align-items-center justify-content-center position-relative" style="background-color: #f8faf9; height: 130px;">
                                        @if($imgSrc)
                                            <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="product-icon-circle rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background: rgba(7, 47, 31, 0.08); color: {{ $accentColor }};">
                                                <i class="bi {{ $iconClass }} fs-2"></i>
                                            </div>
                                        @endif
                                        <span class="badge bg-white text-dark shadow-sm position-absolute top-0 start-0 m-2 rounded-pill px-2 py-1 small">
                                            {{ $catName }}
                                        </span>
                                        @if($product->stock <= 0)
                                            <span class="badge bg-danger text-white position-absolute bottom-0 end-0 m-2 rounded-pill px-2 py-1 fw-bold shadow-sm">
                                                Stok Habis
                                            </span>
                                        @else
                                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 end-0 m-2 rounded-pill px-2 py-1 small">
                                                Stok: {{ $product->stock }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Product Info & Action -->
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                                        <div>
                                            <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </h6>
                                            <div class="text-success fw-bold fs-6 mb-2">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        @if($product->stock <= 0)
                                            <button type="button" class="btn btn-sm btn-secondary w-100 rounded-pill py-1 mt-2 fw-semibold" onclick="Swal.fire('Mohon maaf!', 'Stok produk ini sedang habis.', 'warning');">
                                                <i class="bi bi-slash-circle me-1"></i> Habis
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-success w-100 rounded-pill py-1 mt-2 btn-add-to-cart fw-semibold">
                                                <i class="bi bi-plus-lg me-1"></i> Tambah
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                <h5>Belum ada produk</h5>
                                <p class="text-muted">Belum ada data produk yang terdaftar. Silakan tambah produk baru terlebih dahulu melalui menu Products.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Search Empty State -->
                    <div id="noSearchResults" class="text-center py-5 d-none text-muted">
                        <i class="bi bi-search fs-1 d-block mb-2 text-secondary"></i>
                        <h5>Menu tidak ditemukan</h5>
                        <p class="small text-muted">Coba kata kunci pencarian atau kategori lain.</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- ==========================================
            AREA 2 & 3: KERANJANG & PROSES PEMBAYARAN
            ========================================== -->
        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white order-summary-card d-flex flex-column">

                <!-- Order Header -->
                <div class="card-header bg-transparent border-bottom p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            <i class="bi bi-cart3 text-success me-2 fs-5"></i> Ringkasan Pesanan
                        </h5>
                        <div class="small text-muted mt-1">
                            Order: <span class="fw-semibold text-dark" id="orderIdText">#TRX-{{ date('Ymd') }}-001</span>
                        </div>
                    </div>
                    <!-- Order Type Options -->
                    <div class="btn-group btn-group-sm" role="group" aria-label="Order Type">
                        <input type="radio" class="btn-check" name="orderType" id="dineIn" value="Dine In" checked>
                        <label class="btn btn-outline-secondary btn-sm rounded-start-pill px-2" for="dineIn">Dine In</label>

                        <input type="radio" class="btn-check" name="orderType" id="takeAway" value="Take Away">
                        <label class="btn btn-outline-secondary btn-sm rounded-end-pill px-2" for="takeAway">Take Away</label>
                    </div>
                </div>

                <!-- Cart Items List (Scrollable) -->
                <div class="card-body p-3 flex-grow-1 overflow-y-auto" id="cartItemsContainer" style="max-height: 380px; min-height: 240px;">
                    <!-- Empty State View -->
                    <div id="emptyCartView" class="text-center py-5 text-muted d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="empty-cart-icon mb-3 rounded-circle d-flex align-items-center justify-content-center bg-light text-muted" style="width: 70px; height: 70px;">
                            <i class="bi bi-bag-x fs-2"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Keranjang Masih Kosong</h6>
                        <p class="small text-muted px-4 mb-0">Klik pada menu makanan atau minuman di sebelah kiri untuk memasukkan ke dalam pesanan.</p>
                    </div>

                    <!-- Cart Item Rows rendered by JS -->
                    <ul class="list-unstyled mb-0 d-none" id="cartList"></ul>
                </div>

                <!-- Order Calculation Summary & Payment Section -->
                <div class="card-footer bg-light border-top p-3">
                    <!-- Customer Info Section -->
                    <div class="mb-3 border-bottom pb-3">
                        <div class="row g-2">
                            <div class="col-7">
                                <label class="form-label small text-muted fw-bold mb-1">Nama Pelanggan</label>
                                <input type="text" class="form-control form-control-sm" id="customerNameInput" placeholder="Masukkan nama...">
                            </div>
                            <div class="col-5">
                                <label class="form-label small text-muted fw-bold mb-1" id="tableQueueLabel">Nomor Meja</label>
                                <input type="text" class="form-control form-control-sm" id="tableQueueInput" placeholder="01 / A1">
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="calculation-summary mb-3">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Subtotal</span>
                            <span class="fw-semibold text-dark" id="subtotalText">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Pajak PPN (10%)</span>
                            <span class="fw-semibold text-dark" id="taxText">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="fw-bold text-dark fs-6">Total Pembayaran</span>
                            <span class="fw-bolder fs-5 text-success" id="grandTotalText">Rp 0</span>
                        </div>
                    </div>

                    <!-- Payment Method Toggle -->
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold mb-2">Metode Pembayaran</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="paymentMethod" id="payCash" value="Tunai" checked>
                                <label class="btn btn-outline-success btn-sm w-100 py-2 d-flex flex-column align-items-center" for="payCash">
                                    <i class="bi bi-cash-stack fs-5 mb-1"></i>
                                    <span class="small fw-semibold">Tunai</span>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="paymentMethod" id="payQris" value="QRIS">
                                <label class="btn btn-outline-success btn-sm w-100 py-2 d-flex flex-column align-items-center" for="payQris">
                                    <i class="bi bi-qr-code fs-5 mb-1"></i>
                                    <span class="small fw-semibold">QRIS</span>
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="paymentMethod" id="payDebit" value="Debit / EDC">
                                <label class="btn btn-outline-success btn-sm w-100 py-2 d-flex flex-column align-items-center" for="payDebit">
                                    <i class="bi bi-credit-card-2-front fs-5 mb-1"></i>
                                    <span class="small fw-semibold">Debit</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Cash Calculation (Shown for Tunai) -->
                    <div id="cashInputSection" class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small text-muted fw-bold mb-0">Uang Diterima (Rp)</label>
                            <span class="small text-muted" id="changeIndicator">Kembalian: <strong id="changeText" class="text-dark">Rp 0</strong></span>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-white border">Rp</span>
                            <input type="number" id="cashAmountInput" class="form-control" placeholder="0" min="0">
                        </div>
                        <!-- Quick Cash Suggestion Chips -->
                        <div class="d-flex gap-1 flex-wrap">
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 small quick-cash-btn" data-value="exact">Uang Pas</button>
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 small quick-cash-btn" data-value="20000">20.000</button>
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 small quick-cash-btn" data-value="50000">50.000</button>
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 small quick-cash-btn" data-value="100000">100.000</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button type="button" id="btnProcessPayment" class="btn btn-success py-2 fw-bold d-flex align-items-center justify-content-center shadow-sm rounded-3" disabled>
                            <i class="bi bi-check2-circle fs-5 me-2"></i> Proses Pembayaran
                        </button>
                        <button type="button" id="btnClearCart" class="btn btn-outline-danger btn-sm py-1 border-0 text-muted" style="display: none;">
                            <i class="bi bi-trash3 me-1"></i> Kosongkan Keranjang
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- ==========================================
    MODAL STRUK / KONFIRMASI PEMBAYARAN
    ========================================== -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-labelledby="paymentSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-success text-white p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px;">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="paymentSuccessModalLabel">Pembayaran Berhasil!</h5>
                        <p class="small mb-0 text-white-50">Transaksi telah tersimpan dan selesai.</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Struk Receipt Box (Format POS Standard 80mm) -->
                <div class="receipt-box bg-white font-monospace text-dark" style="padding: 15px; font-size: 14px;">
                    <div class="text-center mb-2">
                        <strong style="font-size: 16px;">POS CAFE INDONESIA</strong><br>
                        Jl. Pendidikan No. 10, Jakarta<br>
                    </div>
                    
                    <div class="border-dashed"></div>
                    
                    <div class="mb-2">
                        <div id="receiptTime"></div>
                        <div id="receiptTrxId"></div>
                        <div id="receiptOrderType"></div>
                    </div>
                    
                    <div class="border-dashed"></div>

                    <div id="receiptItemsList" class="mb-2">
                        <!-- Populated by JS -->
                    </div>

                    <div class="border-dashed"></div>

                    <div>
                        <div class="receipt-item">
                            <span>Subtotal</span>
                            <span id="receiptSubtotal">Rp 0</span>
                        </div>
                        <div class="receipt-item">
                            <span>PPN (10%)</span>
                            <span id="receiptTax">Rp 0</span>
                        </div>
                        <div class="receipt-item fw-bold mt-1">
                            <span>Total Akhir</span>
                            <span id="receiptTotal">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="border-dashed"></div>
                    
                    <div>
                        <div class="receipt-item">
                            <span>Metode Bayar</span>
                            <span id="receiptMethod">Tunai</span>
                        </div>
                        <div class="receipt-item" id="receiptCashRow">
                            <span>Bayar Tunai</span>
                            <span id="receiptCash">Rp 0</span>
                        </div>
                        <div class="receipt-item" id="receiptChangeRow">
                            <span>Kembalian</span>
                            <span id="receiptChange">Rp 0</span>
                        </div>
                    </div>

                    <div class="border-dashed"></div>

                    <div class="text-center mt-3">
                        TERIMA KASIH ATAS KUNJUNGAN ANDA<br>
                        Silakan berkunjung kembali
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light border-0 p-3 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-3" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Cetak Struk
                </button>
                <button type="button" class="btn btn-success px-4 rounded-3" data-bs-dismiss="modal" id="btnNewTransaction">
                    <i class="bi bi-arrow-repeat me-1"></i> Transaksi Baru
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
    CUSTOM CSS FOR KASIR UI
    ========================================== -->
<style>
    .btn-category-pill {
        border: 1px solid #E9EFEF;
        background-color: #FFFFFF;
        color: #072F1F;
        font-weight: 500;
        border-radius: 50rem;
        padding: 0.35rem 1rem;
        white-space: nowrap;
        transition: all 0.2s ease-in-out;
    }
    .btn-category-pill:hover,
    .btn-category-pill.active {
        background-color: #072F1F;
        color: #FFFFFF;
        border-color: #072F1F;
    }
    .product-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-color: #E9EFEF !important;
        cursor: pointer;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(7, 47, 31, 0.08) !important;
        border-color: #22C55E !important;
    }
    .cart-item-row {
        transition: background-color 0.15s ease;
        border-bottom: 1px dashed #E9EFEF;
        padding-bottom: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .cart-item-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    .qty-btn {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 6px;
    }
    .quick-cash-btn {
        font-size: 0.75rem;
        border-radius: 50rem;
    }
    .quick-cash-btn:hover {
        background-color: #DCFCE7;
        color: #15803D;
        border-color: #86EFAC !important;
    }
    
    /* PRINT STYLES UNTUK STRUK (Thermal 80mm) */
    @media print {
        /* Set ukuran kertas thermal 80mm dinamis tanpa batas tinggi kaku */
        @page {
            size: 80mm auto !important;
            margin: 0mm !important;
        }

        /* Paksa HTML dan Body agar tidak membuat halaman baru */
        html, body {
            width: 80mm !important;
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
        }

        /* Hilangkan semua elemen luar & pencegahan Page Break */
        header.navbar, .kasir-wrapper, .modal-header, .modal-footer, .btn, .no-print {
            display: none !important;
        }

        /* Reset Modal Wrapper agar tidak merusak layout cetak */
        #paymentSuccessModal, .modal-dialog, .modal-content, .modal-body {
            position: static !important;
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
        }

        /* Kontainer utama struk */
        .receipt-box {
            width: 80mm !important;
            padding: 3mm !important;
            margin: 0 auto !important;
            display: block !important;
            border: none !important;
            background: white !important;
            page-break-after: avoid !important; /* Mencegah cetak lembar ke-2 */
            page-break-inside: avoid !important;
        }

        /* Layout Item Rata Kiri Kanan */
        .receipt-item {
            display: flex !important;
            justify-content: space-between !important;
            width: 100% !important;
            margin-bottom: 3px !important;
        }
        
        .receipt-box * {
            color: #000 !important;
            font-family: 'Courier New', Courier, monospace !important;
        }
        
        /* Pastikan tidak ada margin bawah berlebih pada elemen terakhir */
        *:last-child {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .border-dashed {
            border-top: 1px dashed #000 !important;
            border-bottom: none !important;
            border-left: none !important;
            border-right: none !important;
            margin: 8px 0 !important;
            opacity: 1 !important;
        }
    }
    
    .border-dashed {
        border-top: 1px dashed #ccc;
        margin: 12px 0;
    }
</style>

<!-- ==========================================
    CLIENT-SIDE INTERACTIVE JAVASCRIPT
    ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // State Keranjang
    let cart = [];
    const taxRate = 0.10; // PPN 10%
    let activeCategory = 'all';
    let searchQuery = '';

    // DOM Elements
    const searchInput = document.getElementById('searchMenuInput');
    const categoryButtons = document.querySelectorAll('.btn-category-pill');
    const productItems = document.querySelectorAll('.product-item');
    const noSearchResults = document.getElementById('noSearchResults');
    const productCountText = document.getElementById('productCount');

    const cartList = document.getElementById('cartList');
    const emptyCartView = document.getElementById('emptyCartView');
    const subtotalText = document.getElementById('subtotalText');
    const taxText = document.getElementById('taxText');
    const grandTotalText = document.getElementById('grandTotalText');
    const btnProcessPayment = document.getElementById('btnProcessPayment');
    const btnClearCart = document.getElementById('btnClearCart');

    const cashAmountInput = document.getElementById('cashAmountInput');
    const changeText = document.getElementById('changeText');
    const cashInputSection = document.getElementById('cashInputSection');
    const quickCashButtons = document.querySelectorAll('.quick-cash-btn');
    const paymentMethodRadios = document.querySelectorAll('input[name="paymentMethod"]');
    const orderTypeRadios = document.querySelectorAll('input[name="orderType"]');
    const tableQueueLabel = document.getElementById('tableQueueLabel');
    const customerNameInput = document.getElementById('customerNameInput');
    const tableQueueInput = document.getElementById('tableQueueInput');
    const paymentSuccessModal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));

    // --- Order Type Toggle Logic ---
    orderTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Take Away') {
                tableQueueLabel.textContent = 'Nomor Antrian';
                tableQueueInput.placeholder = 'A01 / 01';
            } else {
                tableQueueLabel.textContent = 'Nomor Meja';
                tableQueueInput.placeholder = '01 / A1';
            }
        });
    });

    const btnNewTransaction = document.getElementById('btnNewTransaction');

    // Format Rupiah Helper
    function formatRp(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    // Filter Menu Logic
    function filterProducts() {
        let visibleCount = 0;
        productItems.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            const category = item.getAttribute('data-category');

            const matchCategory = (activeCategory === 'all' || category === activeCategory);
            const matchSearch = name.includes(searchQuery.toLowerCase());

            if (matchCategory && matchSearch) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (visibleCount === 0) {
            noSearchResults.classList.remove('d-none');
        } else {
            noSearchResults.classList.add('d-none');
        }
        productCountText.textContent = visibleCount;
    }

    // Search Input Listener
    searchInput.addEventListener('input', function (e) {
        searchQuery = e.target.value.trim();
        filterProducts();
    });

    // Category Pill Listener
    categoryButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            categoryButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.getAttribute('data-category');
            filterProducts();
        });
    });

    // Add To Cart Listener
    document.querySelectorAll('.product-item').forEach(card => {
        card.addEventListener('click', function (e) {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price')) || 0;
            const stock = parseInt(this.getAttribute('data-stock')) || 99;

            addToCart(id, name, price, stock);
        });
    });

    function addToCart(id, name, price, stock) {
        if (stock <= 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Mohon maaf!', 'Stok produk ini sedang habis.', 'warning');
            } else {
                alert('Mohon maaf! Stok produk ini sedang habis.');
            }
            return;
        }

        const existing = cart.find(item => item.id == id);
        if (existing) {
            if (existing.qty < stock) {
                existing.qty++;
            } else {
                alert(`Stok produk "${name}" terbatas (Maks: ${stock})`);
                return;
            }
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                qty: 1,
                stock: stock
            });
        }
        renderCart();
    }

    // Render Cart Items & Calculate Totals
    function renderCart() {
        if (cart.length === 0) {
            emptyCartView.classList.remove('d-none');
            cartList.classList.add('d-none');
            cartList.innerHTML = '';
            btnProcessPayment.disabled = true;
            btnClearCart.style.display = 'none';

            subtotalText.textContent = formatRp(0);
            taxText.textContent = formatRp(0);
            grandTotalText.textContent = formatRp(0);
            calculateChange(0);
            return;
        }

        emptyCartView.classList.add('d-none');
        cartList.classList.remove('d-none');
        btnProcessPayment.disabled = false;
        btnClearCart.style.display = 'inline-block';

        let html = '';
        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;

            html += `
                <li class="cart-item-row">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="fw-semibold text-dark text-truncate me-2" style="max-width: 170px;">
                            ${item.name}
                        </div>
                        <div class="fw-bold text-success text-nowrap">
                            ${formatRp(itemSubtotal)}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">${formatRp(item.price)}/item</span>
                        <div class="d-flex align-items-center gap-1">
                            <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(${index}, -1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" class="form-control form-control-sm text-center mx-1 fw-bold p-0 cart-qty-input" 
                                style="width: 45px; height: 26px;" 
                                value="${item.qty}" 
                                min="1" 
                                max="${item.stock}" 
                                oninput="setQty(${index}, this.value)"
                                onblur="if(this.value === '') { setQty(${index}, 1); }">
                            <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQty(${index}, 1)">
                                <i class="bi bi-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="removeCartItem(${index})" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </li>
            `;
        });

        cartList.innerHTML = html;

        const tax = subtotal * taxRate;
        const grandTotal = subtotal + tax;

        subtotalText.textContent = formatRp(subtotal);
        taxText.textContent = formatRp(tax);
        grandTotalText.textContent = formatRp(grandTotal);

        calculateChange(grandTotal);
    }

    // Global qty / remove functions
    window.updateQty = function (index, delta) {
        if (!cart[index]) return;
        const newQty = cart[index].qty + delta;
        if (newQty <= 0) {
            cart.splice(index, 1);
        } else if (newQty > cart[index].stock) {
            alert(`Stok maksimal untuk item ini adalah ${cart[index].stock}`);
        } else {
            cart[index].qty = newQty;
        }
        renderCart();
    };

    window.setQty = function (index, value) {
        if (!cart[index]) return;
        if (value === '') return; // Wait for blur to reset to 1 if empty
        let newQty = parseInt(value);
        
        if (isNaN(newQty) || newQty < 1) {
            newQty = 1;
        } else if (newQty > cart[index].stock) {
            alert(`Stok maksimal untuk item ini adalah ${cart[index].stock}`);
            newQty = cart[index].stock;
        }
        
        cart[index].qty = newQty;
        renderCart();
    };

    window.removeCartItem = function (index) {
        if (!cart[index]) return;
        cart.splice(index, 1);
        renderCart();
    };

    // Calculate Change
    function calculateChange(grandTotal) {
        const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        if (selectedMethod !== 'Tunai') {
            changeText.textContent = formatRp(0);
            return;
        }

        const cashGiven = parseFloat(cashAmountInput.value) || 0;
        const change = cashGiven - grandTotal;

        if (change >= 0) {
            changeText.textContent = formatRp(change);
            changeText.className = 'text-success fw-bold';
        } else {
            changeText.textContent = 'Kurang ' + formatRp(Math.abs(change));
            changeText.className = 'text-danger fw-bold';
        }
    }

    // Cash Input Event
    cashAmountInput.addEventListener('input', function () {
        const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
        const grandTotal = subtotal + (subtotal * taxRate);
        calculateChange(grandTotal);
    });

    // Quick Cash Buttons
    quickCashButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
            const grandTotal = subtotal + (subtotal * taxRate);
            const val = this.getAttribute('data-value');

            if (val === 'exact') {
                cashAmountInput.value = grandTotal;
            } else {
                cashAmountInput.value = parseFloat(val);
            }
            calculateChange(grandTotal);
        });
    });

    // Payment Method Radio Change
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'Tunai') {
                cashInputSection.style.display = 'block';
            } else {
                cashInputSection.style.display = 'none';
            }
            const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
            const grandTotal = subtotal + (subtotal * taxRate);
            calculateChange(grandTotal);
        });
    });

    // Clear Cart Button
    btnClearCart.addEventListener('click', function () {
        if (confirm('Kosongkan semua pesanan di keranjang?')) {
            cart = [];
            cashAmountInput.value = '';
            customerNameInput.value = '';
            tableQueueInput.value = '';
            renderCart();
        }
    });

    // Process Payment Button -> Submit via AJAX then Show Modal
    btnProcessPayment.addEventListener('click', function () {
        if (cart.length === 0) return;

        const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
        const tax = subtotal * taxRate;
        const grandTotal = subtotal + tax;

        const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        const selectedOrderType = document.querySelector('input[name="orderType"]:checked').value;
        const cashGiven = parseFloat(cashAmountInput.value) || 0;

        if (selectedMethod === 'Tunai' && cashGiven < grandTotal) {
            alert('Uang yang diterima kurang dari total pembayaran!');
            cashAmountInput.focus();
            return;
        }

        // Disable button while processing
        const originalBtnText = btnProcessPayment.innerHTML;
        btnProcessPayment.disabled = true;
        btnProcessPayment.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses...';

        // Prepare data for backend
        const payload = {
            _token: '{{ csrf_token() }}',
            order_type: selectedOrderType,
            customer_name: customerNameInput.value.trim(),
            table_number: tableQueueInput.value.trim(),
            payment_method: selectedMethod,
            cash_given: cashGiven,
            cart: cart.map(item => ({
                id: item.id,
                qty: item.qty,
                price: item.price
            }))
        };

        fetch('{{ route("kasir.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update Order ID from server
                document.getElementById('orderIdText').textContent = data.order.order_number;

                // Populate Receipt Modal
                const now = new Date();
                const timeStr = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'short', day: 'numeric' }) + ' ' + now.toLocaleTimeString('id-ID');
                const trxId = data.order.order_number;

                document.getElementById('receiptTime').textContent = timeStr;
                document.getElementById('receiptTrxId').textContent = 'Trx : ' + trxId;
                
                let infoText = 'Tipe: ' + selectedOrderType;
                const custName = customerNameInput.value.trim();
                const tblQueue = tableQueueInput.value.trim();
                if(custName) infoText += ' | Pelanggan: ' + custName;
                if(tblQueue) infoText += ' | ' + (selectedOrderType === 'Take Away' ? 'Antrian: ' : 'Meja: ') + tblQueue;
                
                document.getElementById('receiptOrderType').textContent = infoText;

                let receiptItemsHtml = '';
                cart.forEach(item => {
                    receiptItemsHtml += `
                        <div style="margin-bottom: 6px;">
                            <div style="text-align: left;">${item.name}</div>
                            <div class="receipt-item">
                                <span>${item.qty} x ${formatRp(item.price)}</span>
                                <span class="fw-bold">${formatRp(item.price * item.qty)}</span>
                            </div>
                        </div>
                    `;
                });
                document.getElementById('receiptItemsList').innerHTML = receiptItemsHtml;

                document.getElementById('receiptSubtotal').textContent = formatRp(subtotal);
                document.getElementById('receiptTax').textContent = formatRp(tax);
                document.getElementById('receiptTotal').textContent = formatRp(grandTotal);
                document.getElementById('receiptMethod').textContent = selectedMethod;

                const cashRow = document.getElementById('receiptCashRow');
                const changeRow = document.getElementById('receiptChangeRow');

                if (selectedMethod === 'Tunai') {
                    cashRow.style.display = 'flex';
                    changeRow.style.display = 'flex';
                    document.getElementById('receiptCash').textContent = formatRp(cashGiven);
                    document.getElementById('receiptChange').textContent = formatRp(cashGiven - grandTotal);
                } else {
                    cashRow.style.display = 'none';
                    changeRow.style.display = 'none';
                }

                paymentSuccessModal.show();
            } else {
                alert('Gagal memproses transaksi: ' + data.message);
                btnProcessPayment.disabled = false;
                btnProcessPayment.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem saat memproses transaksi.');
            btnProcessPayment.disabled = false;
            btnProcessPayment.innerHTML = originalBtnText;
        });
    });

    // Reset After Transaction
    btnNewTransaction.addEventListener('click', function () {
        // Reload the page to reset state and refresh product stocks from server
        window.location.reload();
    });

});
</script>
@endsection
