<?php
require_once "includes/auth_check.php";
include "includes/dbh.inc.php";
include "includes/fetch_velicina.php";
include "includes/fetch_polica.php";
include "includes/fetch_polica_chart.php";
include "includes/fetch_sve.php";
include "includes/za_index_fetch.php";
 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skladište - Dashboard</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>

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

        .welcome-message {
            font-size: 1.1rem;
            color: var(--dark-color);
            opacity: 0.8;
        }

        body.dark-mode .welcome-message {
            color: rgba(255, 255, 255, 0.7);
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

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--card-bg-light);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 4px solid var(--primary-color);
        }

        body.dark-mode .stat-card {
            background-color: #2b2d42;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
        }

        .stat-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .stat-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        body.dark-mode .stat-card h4 {
            color: rgba(255, 255, 255, 0.9);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--dark-color);
            opacity: 0.7;
        }

        body.dark-mode .stat-card .stat-label {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            font-weight: 600;
            padding: 12px 30px;
            transition: all 0.3s ease;
            color: white;
            border-radius: 8px;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 10px 25px;
            transition: all 0.3s ease;
            border-radius: 8px;
            font-size: 1rem;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.3);
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

        /* Modern Warehouse Visualization Styles */
        #warehouse {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(10, 80px);
            gap: 15px;
            margin: 20px 0;
            position: relative;
            min-height: 800px;
        }

        .shelf {
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            color: white;
            overflow: visible;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .shelf-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            transition: all 0.3s ease;
        }

        .shelf-label {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .shelf-status {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .shelf.free {
            background: linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%);
            border: 2px solid #3a86ff;
        }

        .shelf.occupied {
            background: linear-gradient(135deg, #f72585 0%, #b5179e 100%);
            border: 2px solid #7209b7;
        }

        .shelf:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            z-index: 10;
        }

        .shelf:hover .shelf-content {
            transform: scale(1.05);
        }

        /* Fixed Tooltip Styles */
        .shelf-tooltip {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--card-bg-light);
            color: var(--dark-color);
            border: 1px solid rgba(0,0,0,0.1);
            padding: 15px;
            z-index: 1000;
            width: 250px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .shelf:hover .shelf-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(10px);
        }

        .tooltip-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .tooltip-status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .tooltip-status.free {
            background-color: #4cc9f0;
        }

        .tooltip-status.occupied {
            background-color: #f72585;
        }

        .tooltip-header h4 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--dark-color);
        }

        .tooltip-body {
            font-size: 0.95rem;
        }

        .tooltip-row {
            display: flex;
            margin-bottom: 8px;
        }

        .tooltip-label {
            font-weight: 600;
            color: #555;
            min-width: 100px;
        }

        .tooltip-value {
            color: var(--dark-color);
        }

        body.dark-mode .shelf-tooltip {
            background-color: #2b2d42;
            color: #f8f9fa;
            border-color: rgba(255,255,255,0.1);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        body.dark-mode .tooltip-header h4 {
            color: #f8f9fa;
        }

        body.dark-mode .tooltip-header {
            border-bottom: 1px solid #3a3a4a;
        }

        body.dark-mode .tooltip-label {
            color: #b8b8d1;
        }

        body.dark-mode .tooltip-value {
            color: #f8f9fa;
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
            
            #warehouse {
                grid-template-rows: repeat(10, 70px);
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

            .stats-container {
                grid-template-columns: 1fr;
            }

            #donutchart, #velicinachart {
                height: 300px !important;
            }

            #warehouse {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(20, 60px);
            }
            
            .shelf-tooltip {
                width: 200px;
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 576px) {
            #warehouse {
                grid-template-rows: repeat(20, 50px);
            }
            
            .shelf-label {
                font-size: 1rem;
            }
            
            .shelf-status {
                font-size: 0.7rem;
            }
            
            .shelf-tooltip {
                width: 180px;
                font-size: 0.9rem;
            }
        }


        /* Notifications Styles */
.notifications-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notification {
    display: flex;
    align-items: flex-start;
    padding: 15px;
    border-radius: 10px;
    background-color: rgba(72, 149, 239, 0.1);
    border-left: 4px solid var(--info-color);
    transition: all 0.3s ease;
}

.notification.urgent {
    background-color: rgba(239, 35, 60, 0.1);
    border-left-color: var(--danger-color);
}

.notification:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.notification-icon {
    font-size: 1.5rem;
    margin-right: 15px;
    color: var(--info-color);
}

.notification.urgent .notification-icon {
    color: var(--danger-color);
}

.notification-content {
    flex: 1;
}

.notification-content h5 {
    margin: 0 0 5px 0;
    color: var(--dark-color);
}

.notification-content p {
    margin: 0;
    font-size: 0.95rem;
    color: var(--dark-color);
    opacity: 0.8;
}

.notification-meta {
    margin-top: 10px;
    display: flex;
    gap: 10px;
}

body.dark-mode .notification {
    background-color: rgba(72, 149, 239, 0.2);
}

body.dark-mode .notification.urgent {
    background-color: rgba(239, 35, 60, 0.2);
}

body.dark-mode .notification-content h5,
body.dark-mode .notification-content p {
    color: rgba(255, 255, 255, 0.9);
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
    </style>
    
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});

      google.charts.setOnLoadCallback(drawZauzetostChart);
      function drawZauzetostChart() {
        var data = google.visualization.arrayToDataTable([
          ['Polica', 'Broj Polica'],
          ['Slobodne', <?php echo $rowsSlobodne['Slobodne']; ?>],
          ['Zauzete', <?php echo $rowsZauzete['Zauzete']; ?>]
        ]);

        var options = {
          title: 'Zauzetost Polica',
          pieHole: 0.4,
          backgroundColor: 'transparent',
          titleTextStyle: {
            color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529'),
            fontSize: 16,
            bold: true
          },
          legend: {
            textStyle: {
              color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
            }
          },
          pieSliceTextStyle: {
            color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
          },
          colors: ['#4cc9f0', '#4361ee'],
          chartArea: {width: '90%', height: '80%'},
          tooltip: {
            textStyle: {
              color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
            }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }

      google.charts.setOnLoadCallback(drawVelicinaPolicaChart);
      function drawVelicinaPolicaChart() {
        var data = google.visualization.arrayToDataTable([
          ['Veličina Police', 'Broj Polica'],
          <?php foreach ($rowsVelicinaPolica as $row) { ?>
            ['<?php echo $row['ImeVelicinaPolice']; ?>', <?php echo $row['BrojPolica']; ?>],
          <?php } ?>
        ]);

        var options = {
          title: 'Broj Polica po Veličini',
          pieHole: 0.4,
          backgroundColor: 'transparent',
          titleTextStyle: {
            color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529'),
            fontSize: 16,
            bold: true
          },
          legend: {
            textStyle: {
              color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
            }
          },
          pieSliceTextStyle: {
            color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
          },
          colors: ['#4361ee', '#4cc9f0', '#4895ef', '#3a0ca3', '#f72585'],
          chartArea: {width: '90%', height: '80%'},
          tooltip: {
            textStyle: {
              color: (document.body.classList.contains('dark-mode') ? '#f8f9fa' : '#212529')
            }
          }
        };

        var chart = new google.visualization.PieChart(document.getElementById('velicinachart'));
        chart.draw(data, options);
      }
      
      // Redraw charts on window resize and theme change
      function redrawCharts() {
        drawZauzetostChart();
        drawVelicinaPolicaChart();
      }
      
      window.addEventListener('resize', redrawCharts);
    </script>
</head>
<body style="visibility: hidden;">
    <!-- Desktop Sidebar -->
    <div class="sidebar d-none d-lg-block">
        <h2><i class="fas fa-warehouse"></i> Skladište</h2>
        <a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="upis-podataka.php"><i class="fas fa-plus-circle"></i> Upis podataka</a>
        <a class="nav-link" href="pregled-podataka.php"><i class="fas fa-search"></i> Pregled podataka</a>
        <a class="nav-link " href="brisanje-podataka.php"><i class="fas fa-trash-alt"></i> Brisanje podataka</a>
        <a class="nav-link" href="poslane-poruke.php"><i class="fas fa-envelope"></i> Poslane poruke</a>
      
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
        <a class="nav-link active" href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a class="nav-link" href="upis-podataka.php"><i class="fas fa-plus-circle"></i> Upis podataka</a>
        <a class="nav-link" href="pregled-podataka.php"><i class="fas fa-search"></i> Pregled podataka</a>
        <a class="nav-link" href="brisanje-podataka.php"><i class="fas fa-trash-alt"></i> Brisanje podataka</a>
        <a class="nav-link" href="poslane-poruke.php"><i class="fas fa-envelope"></i> Poslane poruke</a>
     
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
    <div class="main-content">
    <div class="dashboard-header">
    <div>
        <h1>Dashboard</h1>
       
    </div>
    <a href="includes/logout.php" class="btn btn-outline-danger logout-btn">
        <i class="fas fa-sign-out-alt me-1"></i> Odjava
    </a>
</div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-box-open"></i>
                <div class="stat-value"><?php echo $rowsSlobodne['Slobodne'] + $rowsZauzete['Zauzete']; ?></div>
                <h4>Ukupno Polica</h4>
                <p class="stat-label">U skladištu</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <div class="stat-value"><?php echo $rowsSlobodne['Slobodne']; ?></div>
                <h4>Slobodne Police</h4>
                <p class="stat-label">Dostupno za upis</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-exclamation-circle"></i>
                <div class="stat-value"><?php echo $rowsZauzete['Zauzete']; ?></div>
                <h4>Zauzete Police</h4>
                <p class="stat-label">Trenutno zauzete</p>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-ruler-combined"></i>
                <div class="stat-value"><?php echo count($rowsVelicinaPolica); ?></div>
                <h4>Različite Veličine</h4>
                <p class="stat-label">Dostupne police</p>
            </div>
        </div>


        <!-- Upcoming Notifications Card -->
<div class="card">
    <h3><i class="fas fa-bell me-2"></i> Nadolazeće obavijesti</h3>
    
    <?php if (!empty($rowsSve)): ?>
        <div class="notifications-container">
            <?php foreach ($rowsSve as $row): 
                if (!empty($row['RokUpotrebe']) && $row['RokUpotrebe'] !== '0000-00-00 00:00:00' && strtotime($row['RokUpotrebe']) > time()):
                    $expiryDate = new DateTime($row['RokUpotrebe']);
                    $currentDate = new DateTime();
                    $daysUntilExpiry = $currentDate->diff($expiryDate)->days;
            ?>
            <div class="notification <?= $daysUntilExpiry <= 7 ? 'urgent' : '' ?>">
                <div class="notification-icon">
                    <i class="fas <?= $daysUntilExpiry <= 7 ? 'fa-exclamation-triangle' : 'fa-clock' ?>"></i>
                </div>
                <div class="notification-content">
                    <h5><?= htmlspecialchars($row["ImeRobe"]) ?> (<?= htmlspecialchars($row["IdRoba"]) ?>)</h5>
                    <p>
                        Istječe za <?= $daysUntilExpiry ?> dana<br>
                        Zakupac: <?= htmlspecialchars($row["Ime"]) ?> <?= htmlspecialchars($row["Prezime"]) ?><br>
                        Kontakt: <?= htmlspecialchars($row["Kontakt"]) ?>
                    </p>
                    <div class="notification-meta">
                        <span class="badge <?= $daysUntilExpiry <= 7 ? 'bg-danger' : 'bg-warning' ?>">
                            <?= htmlspecialchars($row["RokUpotrebe"]) ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endif; endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Nema nadolazećih obavijesti.</div>
    <?php endif; ?>
</div>
        
        <!-- Charts Card -->
        <div class="card">
            <h3>Pregled Polica</h3>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div id="donutchart" style="width: 100%; height: 400px;"></div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div id="velicinachart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="upis-podataka.php" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Dodaj Novu Policu
                </a>
            </div>
        </div>

        <!-- Warehouse Visualization Card -->
        <div class="card">
            <h3>Vizualizacija skladišta</h3>
            <div id="warehouse" class="warehouse-grid">
                <?php
                // Generate the warehouse grid directly in PHP
                $columnMap = ['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4];
                
                if (isset($rowsPolica) && is_array($rowsPolica)) {
                    foreach ($rowsPolica as $polica) {
                        $oznaka = $polica['Oznaka'];
                        $columnLetter = substr($oznaka, 0, 1);
                        $rowNumber = intval(substr($oznaka, 1));
                        
                        $statusClass = ($polica['ZakupacId'] == 1) ? 'free' : 'occupied';
                        $statusText = ($polica['ZakupacId'] == 1) ? 'Slobodna' : 'Zauzeta';
                        
                        echo '<div class="shelf '.$statusClass.'" style="';
                        
                        if (isset($columnMap[$columnLetter]) && $rowNumber > 0) {
                            echo 'grid-column: '.$columnMap[$columnLetter].'; grid-row: '.$rowNumber.';';
                        }
                        
                        echo '">';
                        echo '<div class="shelf-content">';
                        echo '<div class="shelf-label">'.htmlspecialchars($oznaka).'</div>';
                        echo '<div class="shelf-status">'.$statusText.'</div>';
                        echo '</div>';
                        
                        // Tooltip content
                        echo '<div class="shelf-tooltip">';
                        echo '<div class="tooltip-header">';
                        echo '<span class="tooltip-status '.$statusClass.'"></span>';
                        echo '<h4>Polica '.htmlspecialchars($oznaka).'</h4>';
                        echo '</div>';
                        echo '<div class="tooltip-body">';
                        echo '<div class="tooltip-row"><span class="tooltip-label">Status:</span> <span class="tooltip-value">'.$statusText.'</span></div>';
                        echo '<div class="tooltip-row"><span class="tooltip-label">Veličina:</span> <span class="tooltip-value">'.htmlspecialchars($polica['ImeVelicinaPolice']).'</span></div>';
                        
                        if ($polica['ZakupacId'] != NULL) {
                            echo '<div class="tooltip-row"><span class="tooltip-label">Zakupac:</span> <span class="tooltip-value">'.htmlspecialchars($polica['Ime'] ?? '').' '.htmlspecialchars($polica['Prezime'] ?? '').'</span></div>';
                            echo '<div class="tooltip-row"><span class="tooltip-label">Roba:</span> <span class="tooltip-value">'.htmlspecialchars($polica['ImeRobe'] ?? 'Nema robe').'</span></div>';
                            echo '<div class="tooltip-row"><span class="tooltip-label">Rok upotrebe:</span> <span class="tooltip-value">'.htmlspecialchars($polica['RokUpotrebe'] ?? 'N/A').'</span></div>';
                        }
                        
                        echo '</div>';
                        echo '</div>';
                        
                        echo '</div>';
                    }
                } else {
                    echo '<p>Nema podataka o policama za prikaz.</p>';
                }
                ?>
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
                if (typeof redrawCharts === 'function') redrawCharts();
            });
        }
    });
    </script>
</body>
</html>