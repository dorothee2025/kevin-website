<?php
// api/helpers.php

require_once __DIR__ . '/config.php';

function send_json($data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function send_error(string $message, int $status = 400): void {
    send_json(['error' => $message], $status);
}

function handle_cors(): void {
    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(204);
        exit;
    }
}

handle_cors();

function base64url_encode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode(string $data): string {
    $pad = 4 - strlen($data) % 4;
    if ($pad < 4) {
        $data .= str_repeat('=', $pad);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}

function create_jwt(array $user): string {
    $header = base64url_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload = [
        'iss' => JWT_ISS,
        'iat' => time(),
        'exp' => time() + JWT_EXP,
        'uid' => intval($user['user_id']),
        'role' => $user['role'],
    ];
    $payload_enc = base64url_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload_enc", JWT_SECRET, true);
    return "$header.$payload_enc." . base64url_encode($signature);
}

function verify_jwt(string $token): ?array {
    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return null;
    }
    list($header, $payload, $signature) = $parts;
    $rawSignature = base64url_decode($signature);
    $validSignature = hash_hmac('sha256', "$header.$payload", JWT_SECRET, true);
    if (!hash_equals($validSignature, $rawSignature)) {
        return null;
    }
    $data = json_decode(base64url_decode($payload), true);
    if (!is_array($data) || !isset($data['exp']) || time() > intval($data['exp'])) {
        return null;
    }
    return $data;
}

function get_bearer_token(): ?string {
    $headers = [];
    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    }
    if (isset($headers['Authorization'])) {
        $matches = [];
        if (preg_match('/Bearer\s+(.*)$/i', $headers['Authorization'], $matches)) {
            return trim($matches[1]);
        }
    }
    if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
        $matches = [];
        if (preg_match('/Bearer\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            return trim($matches[1]);
        }
    }
    return null;
}

function require_auth(): array {
    $token = get_bearer_token();
    if (!$token) {
        send_error('Authorization token required', 401);
    }
    $payload = verify_jwt($token);
    if (!$payload) {
        send_error('Invalid or expired token', 401);
    }
    return $payload;
}

function require_role(array $roles): array {
    $user = require_auth();
    if (!in_array($user['role'] ?? '', $roles, true)) {
        send_error('Insufficient permissions', 403);
    }
    return $user;
}

function parse_input(): array {
    $body = file_get_contents('php://input');
    $result = json_decode($body, true);
    return is_array($result) ? $result : [];
}

function get_user_by_id(int $user_id): ?array {
    $conn = get_db();
    $stmt = $conn->prepare('SELECT user_id, username, email, role, profile_image, is_active, created_at, updated_at FROM users WHERE user_id = ? LIMIT 1');
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
    return $user ?: null;
}
