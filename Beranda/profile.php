<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siforbeta Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column" style="background-color: #eee9da;">
        <div class="row flex-grow-1">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-primary text-white p-4">
                <h3>siforbeta.</h3>
                <img src="polinema.png" alt="Polinema Logo" style="width: 125px;">
                <nav class="nav flex-column mt-4">
                    <a href="beranda.php" class="nav-link text-white mb-2">Dashboard</a>
                    <a href="profile.php" class="nav-link text-white mb-2">Profile</a>
                    <a href="#" class="nav-link text-white mb-2">Settings</a>
                    <a href="/Logout/logout.html" class="nav-link text-white mt-5">Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 p-5">
                <div class="welcome-container p-5 rounded shadow-lg">
                    <h1 class="fw-bold mb-4">Profile</h1>
                    <p class="text-muted">View and update your profile information below.</p>
                    <hr>
                    <div class="row mt-4">
                        <!-- Profile Picture -->
                        <div class="col-md-4 text-center mb-4">
                            <img src="user.png" alt="User Avatar" class="img-fluid" style="width: 200px; border-radius: 50%; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <p class="fw-bold mt-3">Christiano Fais Putra Fahraby</p>
                        </div>

                        <!-- Profile Details -->
                        <div class="col-md-8">
                            <div class="card shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Personal Information</h5>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="name" class="form-label"><strong>Full Name</strong></label>
                                            <div id="name" class="text-muted">Christiano Fais Putra Fahraby</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="birthplace" class="form-label"><strong>Place & Date of Birth</strong></label>
                                            <div id="birthplace" class="text-muted">Ngawi, 18 Agustus 2000</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="address" class="form-label"><strong>Address</strong></label>
                                            <div id="address" class="text-muted">Jalan Ring-Road Barat No 31,Kota Madiun</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="phone" class="form-label"><strong>Phone Number</strong></label>
                                            <div id="phone" class="text-muted">0812 3456 7890</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="email" class="form-label"><strong>Email</strong></label>
                                            <div id="email" class="text-muted">putra18@gmail.com</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="gender" class="form-label"><strong>Gender</strong></label>
                                            <div id="gender" class="text-muted">Male</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="religion" class="form-label"><strong>Religion</strong></label>
                                            <div id="religion" class="text-muted">Islam</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Academic Information</h5>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label for="nim" class="form-label"><strong>NIM</strong></label>
                                            <div id="nim" class="text-muted">2341720289</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="major" class="form-label"><strong>Major</strong></label>
                                            <div id="major" class="text-muted">Informatic Engineering</div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="program" class="form-label"><strong>Program</strong></label>
                                            <div id="program" class="text-muted">Diploma 4 (D3)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
