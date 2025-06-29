<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login_redirect'] = 'download.php';
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];
$download_file = __DIR__ . "/downloads/{$username}_downloads.json";
$downloads = [];
if (file_exists($download_file)) {
    $json = file_get_contents($download_file);
    $downloads = json_decode($json, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Downloads</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" />
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
                <li class="nav-item"><a class="nav-link active" href="download.php">Download</a></li>
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
<div class="container mt-5">
    <h2>My Downloaded CVs</h2>
    <?php if (empty($downloads)): ?>
        <div class="alert alert-info mt-4">Download is empty.</div>
        <a href="create_cv.php" class="btn btn-primary mt-3">Create a new CV</a>
    <?php else: ?>
        <ul class="list-group mt-4">
            <?php foreach ($downloads as $i => $dl): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo htmlspecialchars($dl['filename']); ?></span>
                    <span class="text-muted small"><?php echo date('Y-m-d H:i', $dl['timestamp']); ?></span>
                    <a href="view_cv.php?id=<?php echo $i; ?>" class="btn btn-primary btn-sm" target="_blank">View</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
