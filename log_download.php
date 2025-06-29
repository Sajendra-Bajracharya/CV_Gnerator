<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}
if (empty($_POST['filename'])) {
    echo json_encode(['success' => false, 'error' => 'No filename provided']);
    exit();
}
$username = $_SESSION['username'];
$filename = basename($_POST['filename']);
$log_dir = __DIR__ . '/downloads';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}
$log_file = "$log_dir/{$username}_downloads.json";
$downloads = [];
if (file_exists($log_file)) {
    $downloads = json_decode(file_get_contents($log_file), true) ?: [];
}
$form_data = $_POST;
unset($form_data['filename']);
$downloads[] = [
    'filename' => $filename,
    'timestamp' => time(),
    'form_data' => $form_data
];
file_put_contents($log_file, json_encode($downloads));
echo json_encode(['success' => true]); 