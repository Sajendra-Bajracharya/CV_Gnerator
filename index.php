<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CV Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css">
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
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 1.5rem;"> <!-- Added gap between items -->
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><span class="nav-link">Hey <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
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
    <div class="hero">
        <div class="content">
            <h1>Curriculum Vitae<br>Generator</h1>
            <p>Welcome to your easy CV Generator — where your professional story comes alive! Craft a standout resume
                effortlessly, impress employers, and open doors to your dream career. Start building your future today
                with confidence and style.</p>
            <div class="button1">
                <a href="create_cv.php" class="btn-lg" style="text-decoration: none;">Get started</a>
            </div>
        </div>
        <img src="../images/document.png" alt="doc" height="400px" width="400px" class="image">
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
    <script src="../javascript/script.js"></script>
</body>

</html>