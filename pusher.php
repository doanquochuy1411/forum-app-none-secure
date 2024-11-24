<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Pusher\Pusher;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get Pusher configuration from environment variables
$pusherConfig = [
    'app_id' => $_ENV['PUSHER_APP_ID'],
    'key' => $_ENV['PUSHER_APP_KEY'],
    'secret' => $_ENV['PUSHER_SECRET_KEY'],
    'cluster' => $_ENV['PUSHER_CLUSTER'],
    'useTLS' => true,
];

// Create Pusher instance
$pusher = new Pusher(
    $pusherConfig['key'],
    $pusherConfig['secret'],
    $pusherConfig['app_id'],
    [
        'cluster' => $pusherConfig['cluster'],
        'useTLS' => $pusherConfig['useTLS'],
    ]
);
?>