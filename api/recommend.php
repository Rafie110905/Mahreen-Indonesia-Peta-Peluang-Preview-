<?php
/**
 * Endpoint sederhana: menerima id minat (dari kuis "Mulai dari mana?")
 * lalu mengembalikan program yang cocok dalam format JSON.
 * Dipanggil dari assets/script.js via fetch().
 */

header('Content-Type: application/json; charset=utf-8');

$programs = require __DIR__ . '/../data/programs.php';
$icons    = require __DIR__ . '/../data/icons.php';

$interest = isset($_GET['interest']) ? trim($_GET['interest']) : '';

$match = null;
foreach ($programs as $program) {
    if ($program['id'] === $interest) {
        $match = $program;
        break;
    }
}

if (!$match) {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Belum ada program yang cocok untuk pilihan ini.',
    ]);
    exit;
}

$match['icon'] = $icons[$match['id']] ?? '';

echo json_encode([
    'success' => true,
    'program' => $match,
]);
