<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cumpără Bilet</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Ticket System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('tickets.index') }}">Lista de bilete</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Cumpără un bilet</h4>
            </div>
            <div class="card-body">
                <!-- Begin form for ticket purchase -->
                <form method="POST" action="{{ route('tickets.buy1Day') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="ticketType" class="form-label">Alege tipul biletului</label>
                        <select class="form-select" id="ticketType" name="ticketType" required>
                            <option value="Bilet de 90 de minute">Bilet de 90 de minute</option>
                            <option value="1-day">Bilet pentru 1 zi</option>
                            <option value="subscription">Abonament lunar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ticketQuantity" class="form-label">Cantitate</label>
                        <input type="number" class="form-control" id="ticketQuantity" name="ticketQuantity" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Metoda de plată</label>
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option value="card">Card</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Cumpără</button>
                </form>

                <!-- Alternative: Subscribe (Subscription ticket form) -->
                <form method="POST" action="{{ route('tickets.subscribe') }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Metodă de plată</label>
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option value="card">Card</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cumpără Abonament Lunar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy;  Proiect AN 2 Programare Functionala. Student - Giurgiuveanu Andrei-Ionut.</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
