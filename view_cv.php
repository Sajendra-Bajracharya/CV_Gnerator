<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['after_login_redirect'] = 'view_cv.php?id=' . urlencode($_GET['id'] ?? '');
    header('Location: login.php');
    exit();
}
$username = $_SESSION['username'];
$id = isset($_GET['id']) ? intval($_GET['id']) : -1;
$log_file = __DIR__ . "/downloads/{$username}_downloads.json";
if (!file_exists($log_file)) {
    die('No downloads found.');
}
$downloads = json_decode(file_get_contents($log_file), true) ?: [];
if (!isset($downloads[$id])) {
    die('Invalid download ID.');
}
$form = $downloads[$id]['form_data'] ?? [];
function safe($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; margin: 0; padding: 0; }
        .cv-container { background: #fff; max-width: 900px; margin: 40px auto; padding: 0 40px 40px 40px; border-radius: 12px; box-shadow: 0 2px 16px rgba(44,62,80,0.08); }
        h1, h2, h3, h4 { color: #2c3e50; }
        .section-title { border-bottom: 2px solid #2c3e50; margin-top: 32px; margin-bottom: 16px; padding-bottom: 4px; font-size: 1.3rem; }
    </style>
</head>
<body>
<div class="cv-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><?php echo safe($form['firstName'] ?? '') . ' ' . safe($form['lastName'] ?? ''); ?></h1>
    </div>
    <div class="mb-2">
        <strong>Email:</strong> <?php echo safe($form['email'] ?? ''); ?> |
        <strong>Phone:</strong> <?php echo safe($form['phone'] ?? ''); ?>
        <?php if (!empty($form['address'])): ?>| <strong>Address:</strong> <?php echo safe($form['address']); ?><?php endif; ?>
        <?php if (!empty($form['linkedin'])): ?>| <strong>LinkedIn:</strong> <a href="<?php echo safe($form['linkedin']); ?>" target="_blank"><?php echo safe($form['linkedin']); ?></a><?php endif; ?>
    </div>
    <?php if (!empty($form['professionalSummary'])): ?>
        <div class="section-title">Professional Summary</div>
        <p><?php echo nl2br(safe($form['professionalSummary'])); ?></p>
    <?php endif; ?>
    <?php
    // Work Experience
    if (!empty($form['jobTitle'][0])) {
        echo "<div class='section-title'>Work Experience</div>";
        for ($i = 0; $i < count($form['jobTitle']); $i++) {
            if (empty($form['jobTitle'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($form['jobTitle'][$i]) . "</strong> at <strong>" . safe($form['company'][$i]) . "</strong>";
            if (!empty($form['location'][$i])) echo ", " . safe($form['location'][$i]);
            echo "<br><span>" . safe($form['startDate'][$i]);
            if (!empty($form['endDate'][$i])) echo " - " . safe($form['endDate'][$i]);
            else echo " - Present";
            echo "</span><br>";
            echo nl2br(safe($form['jobDescription'][$i]));
            echo "</div>";
        }
    }
    // Education
    if (!empty($form['degree'][0])) {
        echo "<div class='section-title'>Education</div>";
        for ($i = 0; $i < count($form['degree']); $i++) {
            if (empty($form['degree'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($form['degree'][$i]) . "</strong> at <strong>" . safe($form['institution'][$i]) . "</strong>";
            if (!empty($form['educationLocation'][$i])) echo ", " . safe($form['educationLocation'][$i]);
            echo "<br><span>" . safe($form['educationStartDate'][$i]);
            if (!empty($form['educationEndDate'][$i])) echo " - " . safe($form['educationEndDate'][$i]);
            echo "</span>";
            if (!empty($form['educationDescription'][$i])) echo "<br>" . nl2br(safe($form['educationDescription'][$i]));
            echo "</div>";
        }
    }
    // Skills
    if (!empty($form['skillsInput'])) {
        $skills = array_map('trim', explode(',', $form['skillsInput']));
        if (count($skills)) {
            echo "<div class='section-title'>Skills</div><ul>";
            foreach ($skills as $skill) {
                if ($skill) echo "<li>" . safe($skill) . "</li>";
            }
            echo "</ul>";
        }
    }
    // Projects
    if (!empty($form['projectName'][0])) {
        echo "<div class='section-title'>Projects</div>";
        for ($i = 0; $i < count($form['projectName']); $i++) {
            if (empty($form['projectName'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($form['projectName'][$i]) . "</strong>";
            if (!empty($form['projectRole'][$i])) echo " - " . safe($form['projectRole'][$i]);
            if (!empty($form['projectUrl'][$i])) echo " (<a href='" . safe($form['projectUrl'][$i]) . "' target='_blank'>Link</a>)";
            echo "<br>" . nl2br(safe($form['projectDescription'][$i])) . "</div>";
        }
    }
    // Certifications
    if (!empty($form['certificationName'][0])) {
        echo "<div class='section-title'>Certifications</div>";
        for ($i = 0; $i < count($form['certificationName']); $i++) {
            if (empty($form['certificationName'][$i])) continue;
            echo "<div class='mb-3'><strong>" . safe($form['certificationName'][$i]) . "</strong> from <strong>" . safe($form['certificationOrg'][$i]) . "</strong>";
            if (!empty($form['certificationDate'][$i])) echo " (" . safe($form['certificationDate'][$i]) . ")";
            if (!empty($form['certificationUrl'][$i])) echo " (<a href='" . safe($form['certificationUrl'][$i]) . "' target='_blank'>Credential</a>)";
            echo "</div>";
        }
    }
    // Languages
    if (!empty($form['language'][0])) {
        echo "<div class='section-title'>Languages</div><ul>";
        for ($i = 0; $i < count($form['language']); $i++) {
            if (empty($form['language'][$i])) continue;
            echo "<li>" . safe($form['language'][$i]);
            if (!empty($form['proficiency'][$i])) echo " - " . safe($form['proficiency'][$i]);
            echo "</li>";
        }
        echo "</ul>";
    }
    // References
    if (!empty($form['referencesAvailable'])) {
        echo "<div class='section-title'>References</div><p>References available upon request.</p>";
        if (!empty($form['referenceName'][0])) {
            for ($i = 0; $i < count($form['referenceName']); $i++) {
                if (empty($form['referenceName'][$i])) continue;
                echo "<div class='mb-2'><strong>" . safe($form['referenceName'][$i]) . "</strong>";
                if (!empty($form['referenceTitle'][$i])) echo ", " . safe($form['referenceTitle'][$i]);
                if (!empty($form['referenceCompany'][$i])) echo " at " . safe($form['referenceCompany'][$i]);
                if (!empty($form['referencePhone'][$i])) echo "<br>Phone: " . safe($form['referencePhone'][$i]);
                if (!empty($form['referenceEmail'][$i])) echo "<br>Email: " . safe($form['referenceEmail'][$i]);
                echo "</div>";
            }
        }
    }
    ?>
</div>
</body>
</html> 