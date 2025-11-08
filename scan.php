<?php
// Simulated progress endpoint for wallet risk check demo with fixed total duration (2 minutes).
header('Content-Type: application/json');
header('Cache-Control: no-store');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const TOTAL_SECONDS = 120; // 2 minutes

$now = microtime(true);

if (isset($_GET['reset'])) {
    $_SESSION['progress'] = 0;
    $_SESSION['started_at'] = $now;
}

// Ensure start time exists
if (!isset($_SESSION['started_at'])) {
    // Initialize if missing (e.g., direct call without reset)
    $_SESSION['started_at'] = $now;
}

$startedAt = floatval($_SESSION['started_at']);
$elapsed = max(0.0, $now - $startedAt);

// Compute progress from elapsed time to guarantee total duration of 120s
$progress = (int) floor(min(100, ($elapsed / TOTAL_SECONDS) * 100));
$_SESSION['progress'] = $progress;

// Recommended client polling delay (1s)
$delay = 1000;

// Status messages by progress thresholds
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
