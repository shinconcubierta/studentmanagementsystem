<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student TPS')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        /* Sidebar */
.sidebar {
    background: #456882; /* olive green */
    min-height: 100vh;
}

.sidebar .nav-link {
    color: #FEFAE0; /* light cream text */
    padding: 12px 20px;
}

.sidebar .nav-link:hover {
    color: #0A400C; /* dark green */
    background: rgba(255, 255, 255, 0.2);
}

.sidebar .nav-link.active {
    color: #FEFAE0; 
    background: #0A400C; /* dark green */
}

/* Main Content */
.main-content {
     background: linear-gradient(135deg, #4B352A, #234C6A); /* Teal → Blue Gradient */
    color: #fff !important; /* light cream background */
    min-height: 100vh;
     /* dark green text */
}

/* Header */
h1, h2, h3, h4, h5, h6 {
    color: #0A400C; /* dark green */
}

/* Buttons */
.btn-primary {
    background: #0A400C; 
    border-color: #0A400C;
}

.btn-primary:hover {
    background: #819067;
    border-color: #819067;
}

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                @include('layouts.navigation')
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="p-4">
                    @include('components.alert')
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3">@yield('header', 'Dashboard')</h1>
                        <div class="textt-muted">
                            <i class="fas fa-calendar"></i>
                            {{ now()->format('F j, Y') }}
                        </div>
                    </div>
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>