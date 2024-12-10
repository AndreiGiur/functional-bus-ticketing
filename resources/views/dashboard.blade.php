<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212; /* Dark background for the body */
            color: #e0e0e0; /* Light text for dark theme */
        }
        .sidebar {
            background-color: #1f1f1f; /* Dark background for sidebar */
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #e0e0e0;
            font-size: 1rem;
            padding: 10px 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #3a3a3a;
            color: #f8f9fa;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            background: #222; /* Dark background for main content */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .main-header {
            color: #f8f9fa; /* Light color for headers */
        }
        .border-bottom {
            border-color: #444 !important; /* Darker border for separation */
        }
        .modal-content {
            background-color: #333; /* Dark background for modals */
            color: #e0e0e0; /* Light text color for modals */
        }
        .modal-header {
            border-bottom: 1px solid #444; /* Dark border for modal header */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tickets.index') }}">
                                <i class="bi bi-card-list"></i> Lista de bilete
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tickets.buy') }}">
                                <i class="bi bi-cart"></i> Cumpără bilete
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-circle"></i> Profil
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 main-header">@yield('title', 'Dashboard')</h1>
                </div>

                <!-- Content -->
                <div class="main-content">
                    @yield('content')

                    <!-- Example of dynamic content -->
                    <div id="dashboard-overview">
                        <h3>Welcome, User!</h3>
                        <p>Here is an overview of your recent activity:</p>
                        <ul>
                            <li><strong>Bilete cumpărate:</strong> 5</li>
                            <li><strong>Profil completat:</strong> Da</li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals for additional functionalities -->

    <!-- Modal: Cumpără bilet -->
    <div class="modal fade" id="buyTicketModal" tabindex="-1" aria-labelledby="buyTicketModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyTicketModalLabel">Cumpără Bilet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="ticketType" class="form-label">Tip Bilet</label>
                            <select class="form-select" id="ticketType" required>
                                <option value="standard">Standard</option>
                                <option value="vip">VIP</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ticketQuantity" class="form-label">Cantitate</label>
                            <input type="number" class="form-control" id="ticketQuantity" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Metoda de plată</label>
                            <select class="form-select" id="paymentMethod" required>
                                <option value="card">Card</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cumpără</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Profil -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Editare Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Nume</label>
                            <input type="text" class="form-control" id="userName" value="John Doe" required>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" value="johndoe@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="userPassword" class="form-label">Parolă</label>
                            <input type="password" class="form-control" id="userPassword">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvează</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Attach modal triggers (example: using IDs)
        document.querySelector('a[href="{{ route("tickets.buy") }}"]').addEventListener('click', function (e) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById('buyTicketModal')).show();
        });
        document.querySelector('a[href="{{ route("profile.edit") }}"]').addEventListener('click', function (e) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById('profileModal')).show();
        });
    </script>
</body>
</html>
