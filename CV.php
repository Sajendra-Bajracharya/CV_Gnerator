<?php
session_start();
if (!isset($_SESSION['username'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        $_SESSION['pending_cv'] = $_POST;
    }
    header('Location: login.php');
    exit();
}
// If coming from login and pending_cv is set, repopulate $_POST
if (isset($_SESSION['pending_cv'])) {
    $_POST = $_SESSION['pending_cv'];
    unset($_SESSION['pending_cv']);
}
// Store the last CV form data in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $_SESSION['last_cv_form'] = $_POST;
}
// CV.php: Display the CV using POSTed data from create_cv.php
function safe($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
function print_array_section($arr, $fields, $section_title) {
    if (!empty($arr[$fields[0]][0])) {
        echo "<h3 class='mt-4'>$section_title</h3>";
        for ($i = 0; $i < count($arr[$fields[0]]); $i++) {
            echo "<div class='mb-3'>";
            foreach ($fields as $field) {
                if (!empty($arr[$field][$i])) {
                    echo "<strong>" . ucfirst(preg_replace('/([a-z])([A-Z])/', '$1 $2', $field)) . ":</strong> " . safe($arr[$field][$i]) . "<br>";
                }
            }
            echo "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; margin: 0; padding: 0; }
        .cv-container { background: #fff; max-width: 900px; margin: 0 auto; padding: 0 40px 40px 40px; border-radius: 12px; box-shadow: 0 2px 16px rgba(44,62,80,0.08); }
        h1, h2, h3, h4 { color: #2c3e50; }
        .section-title { border-bottom: 2px solid #2c3e50; margin-top: 32px; margin-bottom: 16px; padding-bottom: 4px; font-size: 1.3rem; }
        .download-btn { background: #2c3e50; color: #fff; border: none; }
        .download-btn:hover { background: #34495e; }
        @media print {
            .no-print { display: none !important; }
            body, .cv-container { margin-top: 0 !important; padding-top: 0 !important; }
        }
    </style>
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
<div class="cv-container" id="cvContent">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><?php echo safe($_POST['firstName'] ?? '') . ' ' . safe($_POST['lastName'] ?? ''); ?></h1>
    </div>
    <div class="mb-2">
        <strong>Email:</strong> <?php echo safe($_POST['email'] ?? ''); ?> |
        <strong>Phone:</strong> <?php echo safe($_POST['phone'] ?? ''); ?>
        <?php if (!empty($_POST['address'])): ?>| <strong>Address:</strong> <?php echo safe($_POST['address']); ?><?php endif; ?>
        <?php if (!empty($_POST['linkedin'])): ?>| <strong>LinkedIn:</strong> <a href="<?php echo safe($_POST['linkedin']); ?>" target="_blank"><?php echo safe($_POST['linkedin']); ?></a><?php endif; ?>
    </div>
    <?php if (!empty($_POST['professionalSummary'])): ?>
        <div class="section-title">Professional Summary</div>
        <p><?php echo nl2br(safe($_POST['professionalSummary'])); ?></p>
    <?php endif; ?>
    <?php
    // Work Experience
    if (!empty($_POST['jobTitle'][0])) {
        echo "<div class='section-title'>Work Experience</div>";
        for ($i = 0; $i < count($_POST['jobTitle']); $i++) {
            if (empty($_POST['jobTitle'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($_POST['jobTitle'][$i]) . "</strong> at <strong>" . safe($_POST['company'][$i]) . "</strong>";
            if (!empty($_POST['location'][$i])) echo ", " . safe($_POST['location'][$i]);
            echo "<br><span>" . safe($_POST['startDate'][$i]);
            if (!empty($_POST['endDate'][$i])) echo " - " . safe($_POST['endDate'][$i]);
            else echo " - Present";
            echo "</span><br>";
            echo nl2br(safe($_POST['jobDescription'][$i]));
            echo "</div>";
        }
    }
    // Education
    if (!empty($_POST['degree'][0])) {
        echo "<div class='section-title'>Education</div>";
        for ($i = 0; $i < count($_POST['degree']); $i++) {
            if (empty($_POST['degree'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($_POST['degree'][$i]) . "</strong> at <strong>" . safe($_POST['institution'][$i]) . "</strong>";
            if (!empty($_POST['educationLocation'][$i])) echo ", " . safe($_POST['educationLocation'][$i]);
            echo "<br><span>" . safe($_POST['educationStartDate'][$i]);
            if (!empty($_POST['educationEndDate'][$i])) echo " - " . safe($_POST['educationEndDate'][$i]);
            echo "</span>";
            if (!empty($_POST['educationDescription'][$i])) echo "<br>" . nl2br(safe($_POST['educationDescription'][$i]));
            echo "</div>";
        }
    }
    // Skills
    if (!empty($_POST['skillsInput'])) {
        $skills = array_map('trim', explode(',', $_POST['skillsInput']));
        if (count($skills)) {
            echo "<div class='section-title'>Skills</div><ul>";
            foreach ($skills as $skill) {
                if ($skill) echo "<li>" . safe($skill) . "</li>";
            }
            echo "</ul>";
        }
    }
    // Projects
    if (!empty($_POST['projectName'][0])) {
        echo "<div class='section-title'>Projects</div>";
        for ($i = 0; $i < count($_POST['projectName']); $i++) {
            if (empty($_POST['projectName'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($_POST['projectName'][$i]) . "</strong>";
            if (!empty($_POST['projectRole'][$i])) echo " - " . safe($_POST['projectRole'][$i]);
            if (!empty($_POST['projectUrl'][$i])) echo " (<a href='" . safe($_POST['projectUrl'][$i]) . "' target='_blank'>Link</a>)";
            echo "<br>" . nl2br(safe($_POST['projectDescription'][$i])) . "</div>";
        }
    }
    // Certifications
    if (!empty($_POST['certificationName'][0])) {
        echo "<div class='section-title'>Certifications</div>";
        for ($i = 0; $i < count($_POST['certificationName']); $i++) {
            if (empty($_POST['certificationName'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($_POST['certificationName'][$i]) . "</strong> from <strong>" . safe($_POST['certificationOrg'][$i]) . "</strong>";
            if (!empty($_POST['certificationDate'][$i])) echo " (" . safe($_POST['certificationDate'][$i]) . ")";
            if (!empty($_POST['certificationUrl'][$i])) echo " (<a href='" . safe($_POST['certificationUrl'][$i]) . "' target='_blank'>Credential</a>)";
            echo "</div>";
        }
    }
    // Languages
    if (!empty($_POST['language'][0])) {
        echo "<div class='section-title'>Languages</div><ul>";
        for ($i = 0; $i < count($_POST['language']); $i++) {
            if (empty($_POST['language'][$i])) continue;
            echo "<li>" . safe($_POST['language'][$i]);
            if (!empty($_POST['proficiency'][$i])) echo " - " . safe($_POST['proficiency'][$i]);
            echo "</li>";
        }
        echo "</ul>";
    }
    // References
    if (!empty($_POST['referencesAvailable'])) {
        echo "<div class='section-title'>References</div><p>References available upon request.</p>";
        if (!empty($_POST['referenceName'][0])) {
            for ($i = 0; $i < count($_POST['referenceName']); $i++) {
                if (empty($_POST['referenceName'][$i])) continue;
                echo "<div class='mb-2'><strong>" . safe($_POST['referenceName'][$i]) . "</strong>";
                if (!empty($_POST['referenceTitle'][$i])) echo ", " . safe($_POST['referenceTitle'][$i]);
                if (!empty($_POST['referenceCompany'][$i])) echo " at " . safe($_POST['referenceCompany'][$i]);
                if (!empty($_POST['referencePhone'][$i])) echo "<br>Phone: " . safe($_POST['referencePhone'][$i]);
                if (!empty($_POST['referenceEmail'][$i])) echo "<br>Email: " . safe($_POST['referenceEmail'][$i]);
                echo "</div>";
            }
        }
    }
    ?>
    <div class="mt-4">
        <button class="btn download-btn no-print" onclick="downloadPDF()">Download CV as PDF</button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function downloadPDF() {
    window.scrollTo(0, 0);
    var element = document.getElementById('cvContent');
    var filename = 'CV_<?php echo safe($_POST['firstName'] ?? 'CV'); ?>.pdf';
    // Prepare form data for logging
    var formData = new URLSearchParams();
    formData.append('filename', filename);
    var form = document.createElement('form');
    form.innerHTML = document.getElementById('cvForm') ? document.getElementById('cvForm').innerHTML : '';
    // Add all POST fields
    <?php foreach ($_POST as $key => $value): ?>
        <?php if (is_array($value)): ?>
            <?php foreach ($value as $v): ?>
                formData.append('<?php echo $key; ?>[]', <?php echo json_encode($v); ?>);
            <?php endforeach; ?>
        <?php else: ?>
            formData.append('<?php echo $key; ?>', <?php echo json_encode($value); ?>);
        <?php endif; ?>
    <?php endforeach; ?>
    // Log the download first
    fetch('log_download.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData.toString()
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        // Proceed to download regardless of log result
        html2pdf().from(element).set({
            margin: 0,
            filename: filename,
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).save();
    });
}
</script>
</body>
</html>
