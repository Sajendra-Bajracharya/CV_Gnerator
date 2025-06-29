<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - CV Generator</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="aboutus.css">
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
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 1.5rem;">  <!-- Added gap between items -->
                <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="download.php">Download</a></li>
                <li class="nav-item"><a class="nav-link active" href="AboutUs.php">About</a></li>
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

    <main>
        <div class="about-container">
            <h1 class="about-title">About Us</h1>
            <hr class="divider">
            <div class="about-content">
                <!-- Your about us content goes here -->
                <p>Welcome to CV Generator, your premier destination for creating professional resumes and CVs with ease.
                </p>
                <p>Our mission is to help job seekers showcase their skills and experience in the most compelling way
                    possible.</p>
            </div>

            <h3>Why Our CV Generator is Necessary?</h3>
            <h5 class="sub-heading">Time Saving</h5>
            <p class="sub-heading">Create professional CVs in minutes instead of hours. Our templates and automated
                formatting save you valuable time in your job search.</p>

            <h5 class="sub-heading">ATS Friendly</h5>
            <p class="sub-heading">Our CVs are optimized for Applicant Tracking Systems used by 99% of Fortune 500
                companies, increasing your chances of getting noticed.</p>

            <h5 class="sub-heading">Career Advancement</h5>
            <p class="sub-heading">Professionals with well-designed CVs are 40% more likely to get interview calls compared
                to those with poorly formatted resumes.</p>
        </div>
        <div class="about-container">
            <h3>Ready to Create Your Professional CV?</h3>
            <hr class="divider">
            <p>Join thousands of professionals who've accelerated their careers with our CV generator.</p>
            <a href="create_cv.php" class="btn btn-dark">Get Started</a>
            
        </div>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../javascript/script.js"></script>
</body>

</html>