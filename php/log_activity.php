<?php
function log_activity($message) {
    $logfile = '../logs/activity.log'; // Ensure the logs directory exists and is writable
    file_put_contents($logfile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}
?>
