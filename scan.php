<?php
// Simulated progress endpoint for wallet risk check demo.
header('Content-Type: application/json');
header('Cache-Control: no-store');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['reset'])) {
    $_SESSION['progress'] = 0;
}

$current = isset($_GET['current']) ? intval($_GET['current']) : 0;
$progress = isset($_SESSION['progress']) ? intval($_SESSION['progress']) : 0;
$progress = max($progress, $current);

$inc = rand(3, 10);
$delay = rand(350, 900);

if ($progress >= 100) {
    $progress = 100;
} else {
    $progress = min(100, $progress + $inc);
}

$_SESSION['progress'] = $progress;

$msg = 'Scanning addresses…';
if ($progress < 15) $msg = 'Connecting to wallet…';
else if ($progress < 30) $msg = 'Reading address list…';
else if ($progress < 45) $msg = 'Fetching transaction history…';
else if ($progress < 60) $msg = 'Analyzing counterparties…';
else if ($progress < 75) $msg = 'Checking risk signals…';
else if ($progress < 90) $msg = 'Aggregating results…';
else if ($progress < 100) $msg = 'Final checks…';
else $msg = 'Done.';

$verdict = null;
if ($progress >= 100) {
    $hash = md5(session_id());
    $n = hexdec(substr($hash, 0, 2));
    $bucket = $n % 5;
    $verdict = ['Very Low','Low','Moderate','Elevated','High'][$bucket];
}

echo json_encode([
    'progress' => $progress,
    'message' => $msg,
    'delayMs' => $delay,
    'verdict' => $verdict
]);
