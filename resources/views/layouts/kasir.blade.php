<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir / POS - Point of Sale</title>
    
    <!-- Local CSS Libraries & Main Stylesheet -->
    @include('inc.css')
    
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .kasir-brand-icon {
            background: rgba(7, 47, 31, 0.08);
            color: #072F1F;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Standalone POS Header (No Admin Sidebar/Navbar) -->
    <header class="navbar navbar-expand-lg bg-white border-bottom px-4 py-3 sticky-top shadow-sm">
        <div class="container-fluid p-0">
            <a class="navbar-brand d-flex align-items-center gap-2 text-dark fw-bold fs-4" href="{{ route('kasir.index') }}">
                <div class="kasir-brand-icon rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="bi bi-cart3 fs-4 text-success"></i>
                </div>
                <span>Kasir POS</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                @if(Auth::check() && !Auth::user()->isKasir())
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Admin
                    </a>
                @endif

                <div class="d-flex align-items-center gap-2 bg-light px-3 py-2 rounded-pill border">
                    <i class="bi bi-person-circle text-success fs-5"></i>
                    <div class="small">
                        <div class="fw-bold text-dark lh-1">Kasir</div>
                        <div class="text-muted small" style="font-size: 0.75rem;">cashier@gmail.com</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>

    <!-- Local JavaScript Libraries -->
    @include('inc.js')
</body>
</html>
