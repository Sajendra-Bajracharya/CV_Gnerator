<?php
session_start();
// Database configuration
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "cv_db";

// Initialize variables
$full_name = $username = $email = $password = $confirm_password = '';
$showError = '';
$connectionSuccess = false;
$conn = null; // Initialize as null

// Create database connection
try {
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $connectionSuccess = true;
    }
} catch (Exception $e) {
    $showError = "Database connection error: " . $e->getMessage();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        $showError = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $checkUser = $conn->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
        $checkUser->bind_param("ss", $username, $email);
        $checkUser->execute();
        $checkUser->store_result();
        
        if ($checkUser->num_rows > 0) {
            $showError = "Username or email already exists.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $username, $email, $hashed_password);
            
            if ($stmt->execute()) {
                // Registration successful - show message and checkpoint
                $showSuccess = "Account creation successful! You can now <a href='login.php'>login</a>.";
                // CHECKPOINT: Account creation and success message working up to here
            } else {
                $showError = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }
        $checkUser->close();
    }
}

if ($conn) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Signup.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">CV Generator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 1.5rem;">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="download.php">Download</a></li>
                    <li class="nav-item"><a class="nav-link" href="AboutUs.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="create_cv.php">Create</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="login-container">
        <div class="signup-card">
            <h1 class="signup-title">Create Account</h1>

            <?php 
            if ($connectionSuccess) {
                echo '<div class="alert alert-success d-none">Database connection successful</div>';
            }
            if (isset($showSuccess)) echo '<div class="alert alert-success">' . $showSuccess . '</div>'; 
            if ($showError) echo '<div class="alert alert-danger">' . $showError . '</div>'; 
            ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="full_name" required placeholder="Enter the Fullname" value="<?php echo htmlspecialchars($full_name ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required placeholder="Enter Username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="john01@gmail.com" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Enter Password">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required placeholder="Enter the Password">
                </div>
                <button type="submit" class="btn btn-primary btn-signup">Sign Up</button>
                <hr class="divider">
                <div class="login-prompt">
                    Already have an account? <a href="login.php" class="login-link">Login</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>