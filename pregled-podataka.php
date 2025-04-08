<?php
include "includes/dbh.inc.php";
require_once "includes/auth_check.php";
include "includes/fetch_ime_robe.php";
include "includes/fetch_pojedinosti_roba.php";
include "includes/fetch_velicina.php";
include "includes/fetch_vrsta_robe.php";
include "includes/fetch_zakupac.php";
include "includes/fetch_sve.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skladište - Pregled Podataka</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f8961e;
            --danger-color: #ef233c;
            --info-color: #4895ef;
            --card-bg-light: #ffffff;
            --card-bg-dark: #2b2d42;
        }

        body {
            font-family: 'Poppins', sans-serif;
            transition: all 0.4s ease;
            padding-top: 0;
            background-color: var(--light-color);
            color: var(--dark-color);
        }

        body.dark-mode {
            background-color: #121212;
            color: #f8f9fa;
            --light-color: #1e1e1e;
            --dark-color: #f8f9fa;
        }

        /* Sidebar - Desktop */
        .sidebar {
            background-color: var(--card-bg-light);
            color: var(--dark-color);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            padding: 30px 20px;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            z-index: 100;
            overflow-y: auto;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body.dark-mode .sidebar {
            background-color: #1a1a1a;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        }

        .sidebar h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--primary-color);
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(67, 97, 238, 0.2);
            font-weight: 600;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: var(--dark-color);
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        body.dark-mode .sidebar a {
            color: rgba(255, 255, 255, 0.9);
        }

        .sidebar a i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar a:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        /* Mobile Navbar */
        .mobile-navbar {
            display: none;
            background-color: var(--card-bg-light);
            padding: 15px 25px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            align-items: center;
            transition: all 0.3s ease;
        }

        body.dark-mode .mobile-navbar {
            background-color: #1a1a1a;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .mobile-navbar h2 {
            font-size: 1.5rem;
            margin: 0;
            color: var(--primary-color);
            flex-grow: 1;
            text-align: center;
            font-weight: 600;
        }

        /* Hamburger Menu */
        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 24px;
            cursor: pointer;
            z-index: 1002;
        }

        .hamburger-line {
            width: 100%;
            height: 3px;
            background-color: var(--dark-color);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        body.dark-mode .hamburger-line {
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Hamburger to X transformation */
        .hamburger.open .hamburger-line:nth-child(1) {
            transform: translateY(10.5px) rotate(45deg);
        }

        .hamburger.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .hamburger.open .hamburger-line:nth-child(3) {
            transform: translateY(-10.5px) rotate(-45deg);
        }

        /* Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100vh;
            background-color: var(--card-bg-light);
            z-index: 1001;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        body.dark-mode .mobile-sidebar {
            background-color: #1a1a1a;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
        }

        .mobile-sidebar.show {
            left: 0;
        }

        .mobile-sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            position: relative;
        }

        body.dark-mode .mobile-sidebar-header {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .mobile-sidebar h2 {
            font-size: 1.8rem;
            margin: 0;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Close Button */
        .close-sidebar {
            position: absolute;
            right: 20px;
            top: 25px;
            width: 40px;
            height: 40px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            z-index: 1003;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
            color: var(--dark-color);
        }

        body.dark-mode .close-sidebar {
            color: rgba(255, 255, 255, 0.9);
        }

        .close-sidebar i {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .close-sidebar:hover {
            color: var(--danger-color);
            transform: rotate(90deg) scale(1.1);
        }

        .mobile-sidebar a {
            display: flex;
            align-items: center;
            color: var(--dark-color);
            text-decoration: none;
            padding: 15px 25px;
            margin: 8px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            font-weight: 500;
        }

        body.dark-mode .mobile-sidebar a {
            color: rgba(255, 255, 255, 0.9);
        }

        .mobile-sidebar a i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .mobile-sidebar a:hover {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .mobile-sidebar a.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            background-color: var(--card-bg-light);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            padding: 30px;
            overflow: hidden;
            position: relative;
        }

        body.dark-mode .card {
            background-color: #2b2d42;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        .card h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        body.dark-mode th,
        body.dark-mode td {
            border-bottom: 1px solid #495057;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        body.dark-mode tr:hover {
            background-color: rgba(67, 97, 238, 0.2);
        }

        /* Theme Switch */
        .theme-switch-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            display: flex;
            align-items: center;
            background-color: var(--card-bg-light);
            padding: 10px 15px;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        body.dark-mode .theme-switch-container {
            background-color: #2b2d42;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .theme-switch-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .theme-switch-label {
            margin-right: 10px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--dark-color);
        }

        body.dark-mode .theme-switch-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .theme-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .theme-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider-round {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider-round:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider-round {
            background-color: var(--primary-color);
        }

        input:checked + .slider-round:before {
            transform: translateX(26px);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                display: none;
            }
            
            .mobile-navbar {
                display: flex;
            }
            
            .main-content {
                margin-left: 0;
                padding-top: 80px;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .dashboard-header h1 {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .card {
                padding: 20px;
            }

            th, td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .card h3 {
                font-size: 1.5rem;
            }
            
            th, td {
                padding: 6px 8px;
                font-size: 0.8rem;
            }
        }
        /* Logout Button */
.logout-btn {
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(239, 35, 60, 0.2);
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

/* Mobile adjustment */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .logout-btn {
        align-self: flex-end;
    }
}
/* Mobile Logout Button */
.mobile-navbar {
    display: none;
    background-color: var(--card-bg-light);
    padding: 15px 25px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    align-items: center;
    transition: all 0.3s ease;
    justify-content: space-between; /* Add this */
}

.mobile-logout-btn {
    color: var(--danger-color);
    font-size: 1.2rem;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.mobile-logout-btn:hover {
    background-color: rgba(239, 35, 60, 0.1);
    transform: scale(1.1);
}
/* Slimmer cards */
.card {
    max-width: 800px; /* Adjust this value as needed */
    margin: 0 auto 30px; /* Center the cards */
    padding: 20px; /* Reduce padding */
}

/* Narrower form grid */
.form-grid {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Changed from 250px */
    gap: 15px; /* Reduced gap */
}

/* Slimmer inputs */
.form-control {
    padding: 10px 12px; /* Reduced padding */
    font-size: 0.9rem; /* Slightly smaller font */
}

/* Narrower submit button */
.btn-submit {
    padding: 10px 20px; /* Slimmer button */
    font-size: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        max-width: 95%; /* More edge space on mobile */
        padding: 15px;
    }
    
    .form-grid {
        grid-template-columns: 1fr; /* Single column on mobile */
    }
}



.mobile-navbar {
    display: none; /* Hidden by default */
}

@media (max-width: 992px) {
    .mobile-navbar {
        display: flex !important; /* Force show on mobile */
    }
    
    .sidebar {
        display: none !important; /* Ensure desktop sidebar is hidden */
    }
}
    </style>
</head>
<body style="visibility: hidden;">
    <!-- Desktop Sidebar -->
    <div class="sidebar d-none d-lg-block">
        <h2><i class="fas fa-warehouse"></i> Skladište</h2>
        <a class="nav-link " href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="upis-podataka.php"><i class="fas fa-plus-circle"></i> Upis podataka</a>
        <a class="nav-link active" href="pregled-podataka.php"><i class="fas fa-search"></i> Pregled podataka</a>
        <a class="nav-link " href="brisanje-podataka.php"><i class="fas fa-trash-alt"></i> Brisanje podataka</a>
        <a class="nav-link " href="poslane-poruke.php"><i class="fas fa-envelope"></i> Poslane poruke</a>
        
        <a class="nav-link" href="azuriranje-podataka.php"><i class="fas fa-edit"></i> Ažuriranje podataka</a>
    </div>
    
    <!-- Mobile Navbar -->
    <nav class="mobile-navbar d-lg-none">
    <div class="hamburger">
        <div class="hamburger-line"></div>
        <div class="hamburger-line"></div>
        <div class="hamburger-line"></div>
    </div>
    <h2><i class="fas fa-warehouse"></i> Skladište</h2>
  
</nav>
    
    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar d-lg-none">
        <div class="mobile-sidebar-header">
            <h2><i class="fas fa-warehouse"></i> Skladište</h2>
            <button class="close-sidebar" aria-label="Close menu"><i class="fas fa-times"></i></button>
        </div>
        <a class="nav-link" href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="upis-podataka.php"><i class="fas fa-plus-circle"></i> Upis podataka</a>
        <a class="nav-link active" href="pregled-podataka.php"><i class="fas fa-search"></i> Pregled podataka</a>
        <a class="nav-link" href="brisanje-podataka.php"><i class="fas fa-trash-alt"></i> Brisanje podataka</a>
        <a class="nav-link " href="poslane-poruke.php"><i class="fas fa-envelope"></i> Poslane poruke</a>
       
        <a class="nav-link" href="azuriranje-podataka.php"><i class="fas fa-edit"></i> Ažuriranje podataka</a>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Theme Switch -->
    <div class="theme-switch-container">
        <span class="theme-switch-label"><i class="fas fa-moon"></i></span>
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox">
            <div class="slider-round"></div>
        </label>
        <span class="theme-switch-label"><i class="fas fa-sun"></i></span>
    </div>

    <!-- Main Content -->
    <div class="dashboard-header">
    <div>
        <h1>Dashboard</h1>
    
    </div>
    <a href="logout.php" class="btn btn-outline-danger logout-btn">
        <i class="fas fa-sign-out-alt me-1"></i> Odjava
    </a>
</div>

        <!-- Roba Table -->
        <div class="card">
            <h3><i class="fas fa-pallet me-2"></i>Roba</h3>
            <div class="table-responsive">
                <?php if (!empty($rowsRobaPojedinosti)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Rok Upotrebe</th>
                                <th>Ime Robe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowsRobaPojedinosti as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["IdRoba"]) ?></td>
                                <td><?= htmlspecialchars($row["RokUpotrebe"]) ?></td>
                                <td><?= htmlspecialchars($row["ImeRobe"]) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Nema podataka o robi.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Ime Robe Table -->
        <div class="card">
            <h3><i class="fas fa-box-open me-2"></i>Ime Robe</h3>
            <div class="table-responsive">
                <?php if (!empty($rowsImeRobe)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ime Robe</th>
                                <th>Vrsta Robe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowsImeRobe as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["IdImeRobe"]) ?></td>
                                <td><?= htmlspecialchars($row["ImeRobe"]) ?></td>
                                <td><?= isset($row["VrstaRobeName"]) ? htmlspecialchars($row["VrstaRobeName"]) : "N/A" ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Nema podataka o imenima robe.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Vrsta Robe Table -->
        <div class="card">
            <h3><i class="fas fa-tags me-2"></i>Vrsta Robe</h3>
            <div class="table-responsive">
                <?php if (!empty($rowsVrstaRobe)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ime Vrste Robe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowsVrstaRobe as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["IdVrstaRobe"]) ?></td>
                                <td><?= htmlspecialchars($row["ImeVrsteRobe"]) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Nema podataka o vrstama robe.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Veličina Police Table -->
        <div class="card">
            <h3><i class="fas fa-ruler-combined me-2"></i>Veličina Police</h3>
            <div class="table-responsive">
                <?php if (!empty($rowsImeVelicine)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Veličina</th>
                                <th>Cijena</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowsImeVelicine as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["IdVelicinaPolice"]) ?></td>
                                <td><?= htmlspecialchars($row["ImeVelicinaPolice"]) ?></td>
                                <td><?= htmlspecialchars($row["Cijena"]) ?> €</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Nema podataka o veličinama polica.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Zakupac Table -->
        <div class="card">
            <h3><i class="fas fa-users me-2"></i>Zakupci</h3>
            <div class="table-responsive">
                <?php if (!empty($rowsImePrezimeZakupca)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ime</th>
                                <th>Prezime</th>
                                <th>Kontakt</th>
                                <th>Adresa</th>
                                <th>Broj Polica</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rowsImePrezimeZakupca as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["IdZakupac"]) ?></td>
                                <td><?= htmlspecialchars($row["Ime"]) ?></td>
                                <td><?= htmlspecialchars($row["Prezime"]) ?></td>
                                <td><?= htmlspecialchars($row["Kontakt"]) ?></td>
                                <td><?= htmlspecialchars($row["Adresa"]) ?></td>
                                <td><?= htmlspecialchars($row["BrojIznajmljenihPolica"]) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Nema podataka o zakupcima.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // First make body visible
        document.body.style.visibility = "visible";
        
        // Mobile sidebar functionality
        const mobileSidebar = document.querySelector('.mobile-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        const hamburger = document.querySelector('.hamburger');
        const closeSidebarButton = document.querySelector('.close-sidebar');

        function toggleSidebar() {
            mobileSidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            hamburger.classList.toggle('open');
            document.body.style.overflow = mobileSidebar.classList.contains('show') ? 'hidden' : '';
        }

        if (hamburger) hamburger.addEventListener('click', toggleSidebar);
        if (closeSidebarButton) closeSidebarButton.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);

        // Theme switcher
        const themeSwitch = document.getElementById('checkbox');
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.body.classList.add('dark-mode');
            if (themeSwitch) themeSwitch.checked = true;
        }
        
        if (themeSwitch) {
            themeSwitch.addEventListener('change', function() {
                document.body.classList.toggle('dark-mode', this.checked);
                localStorage.setItem('theme', this.checked ? 'dark' : 'light');
            });
        }

        // Set current page as active in navigation
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.sidebar a, .mobile-sidebar a');
        
        navLinks.forEach(link => {
            const linkPage = link.getAttribute('href');
            if (currentPage === linkPage || 
               (currentPage === '' && linkPage === 'index.php')) {
                link.classList.add('active');
            }
        });
    });
    </script>
</body>
</html>