<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Servinext - Tienda de Streaming</title>

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
            .hero { background: linear-gradient(to right, #111, #222); color: white; padding: 5rem 2rem; text-align: center; }
            .service-card { background: #333; color: white; padding: 1.5rem; border-radius: 10px; text-align: center; }
            .service-card img { margin-bottom: 1rem; width: 80px; }
        </style>
    </head>
    <body>
        <div class="container">
            @if (Route::has('login'))
                <div class="d-flex justify-content-end p-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-decoration-none text-dark me-3">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-decoration-none text-dark me-3">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-decoration-none text-dark">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Hero Section -->
            <div class="hero">
                <h1 class="display-4">Bienvenido a Servinext</h1>
                <p class="lead">Compra cuentas de streaming a los mejores precios.</p>
            </div>

            <!-- Catálogo de Servicios -->
            <div class="row mt-5 g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="/images/netflix.png" alt="Netflix">
                        <h3>Netflix</h3>
                        <p>Cuentas premium a precios accesibles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="/images/spotify.png" alt="Spotify">
                        <h3>Spotify</h3>
                        <p>Planes individuales y familiares disponibles.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="/images/disney.png" alt="Disney+">
                        <h3>Disney+</h3>
                        <p>Disfruta de todo el contenido exclusivo de Disney.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="/images/dgo.png" alt="DGO">
                        <h3>DGO</h3>
                        <p>Televisión en vivo y contenido premium.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="/images/hbo.png" alt="HBO Max">
                        <h3>HBO Max</h3>
                        <p>Películas y series exclusivas de HBO.</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center text-muted mt-5">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>