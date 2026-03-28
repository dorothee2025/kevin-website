<?php
// api/config.php

// Database connection settings (override with environment variables in production)
define('DB_HOST', getenv('DB_HOST') ?: 'mysql');
define('DB_USER', getenv('DB_USER') ?: 'kevin_user');
define('DB_PASS', getenv('DB_PASS') ?: 'kevin_password');
define('DB_NAME', getenv('DB_NAME') ?: 'kevin_website');

define('JWT_SECRET', getenv('JWT_SECRET') ?: 'change_this_super_secret_random_value_!@#');

define('JWT_ISS', getenv('JWT_ISS') ?: 'csdream_website_api');

define('JWT_EXP', intval(getenv('JWT_EXP') ?: 604800)); // 7 days

function get_db(): mysqli {
    static $conn;
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            http_response_code(500);
            echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
            exit;
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
