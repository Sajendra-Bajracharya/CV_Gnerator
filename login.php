<?php
session_start();
$username = '';
$password = '';
$usernameErr = '';
$passwordErr = '';
$showError = '';
$showSuccess = '';

// Database connection variables
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "cv_db";

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    $showError = "Database connection failed: " . $conn->connect_error;
}

// Check if users table is empty
$userCount = 0;
if (empty($showError)) {
    $result = $conn->query("SELECT COUNT(*) as cnt FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        $userCount = (int)$row['cnt'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($showError)) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($userCount === 0) {
        $showError = "Create account first.";
    } else {
        if (empty($username)) {
            $usernameErr = "Username is required.";
        }
        if (empty($password)) {
            $passwordErr = "Password is required.";
        }
        if (empty($usernameErr) && empty($passwordErr)) {
            $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows === 1) {
                $stmt->bind_result($hashed_password);
                $stmt->fetch();
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    $showSuccess = "Login successful!";
                    // If pending_cv is set, redirect to CV.php with POST data
                    if (isset($_SESSION['pending_cv'])) {
                        echo '<form id="pendingCVForm" method="post" action="CV.php" style="display:none;">';
                        foreach ($_SESSION['pending_cv'] as $key => $value) {
                            if (is_array($value)) {
                                foreach ($value as $v) {
                                    $v = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
                                    echo "<input type='hidden' name='{$key}[]' value='{$v}'>";
                                }
                            } else {
                                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                                echo "<input type='hidden' name='{$key}' value='{$value}'>";
                            }
                        }
                        echo '</form>';
                        echo '<script>document.getElementById("pendingCVForm").submit();</script>';
                        unset($_SESSION['pending_cv']);
                        exit();
                    }
                } else {
                    $passwordErr = "Password not correct";
                }
            } else {
                $usernameErr = "Incorrect username";
            }
            $stmt->close();
        }
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">CV Generator</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 1.5rem;">  <!-- Added gap between items -->
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="download.php">Download</a></li>
                <li class="nav-item"><a class="nav-link" href="AboutUs.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="create_cv.php">Create</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Login</h1>
            <?php 
            if ($showError) echo '<div class="alert alert-danger">' . $showError . '</div>'; 
            if ($showSuccess) echo '<div class="alert alert-success">' . $showSuccess . '</div>'; 
            ?>
            <form id="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>">
                    <?php if (!empty($usernameErr)) echo '<div class="text-danger">' . $usernameErr . '</div>'; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    <?php if (!empty($passwordErr)) echo '<div class="text-danger">' . $passwordErr . '</div>'; ?>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <div id="errorMsg" class="text-danger mb-3"></div>
                <button type="submit" class="login-btn">Login</button>

                <div class="account-prompt">Don't have an account?</div>
                <a href="Signup.php" class="signup-link">Sign Up</a>

            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
