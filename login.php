<?php
session_start();

// Hardcoded admin credentials (use password_hash() to generate)
$admin_username = 'admin';
$admin_password_hash = '$2y$10$pP7RntG/s.ZIonmBmp78heb7ZUecV9iiCP3MWHD7CbQaaYmDKrZBG'; // Hash for "warehouse123"

// Check if already logged in
if (isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Process login if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = "Krivo korisničko ime ili lozinka";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .form-control {
            height: 45px;
            border-radius: 8px;
            padding-left: 15px;
        }
        
        .btn-login {
            background-color: var(--primary-color);
            color: white;
            height: 45px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-login:hover {
            background-color: #3a0ca3;
            color: white;
        }
        
        .error-message {
            color: #ef233c;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-warehouse"></i>
                <h2>Warehouse Login</h2>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Korisničko ime</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Lozinka</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>