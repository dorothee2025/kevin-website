<?php
require_once __DIR__ . '/helpers.php';

$method = $_SERVER['REQUEST_METHOD'];
$conn = get_db();

if ($method === 'GET') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $stmt = $conn->prepare('SELECT n.*, u.username AS author_name, c.name AS category_name FROM news n LEFT JOIN users u ON n.author_id = u.user_id LEFT JOIN categories c ON n.category_id = c.category_id WHERE n.news_id = ? AND n.status <> "Archived" LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $news = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$news) {
            send_error('News not found', 404);
        }
        send_json(['news' => $news]);
    }
    $status = $_GET['status'] ?? 'Published';
    $limit = max(1, min(100, intval($_GET['limit'] ?? 20)));
    $offset = max(0, intval($_GET['offset'] ?? 0));
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

    $sql = 'SELECT n.*, u.username AS author_name, c.name AS category_name FROM news n LEFT JOIN users u ON n.author_id = u.user_id LEFT JOIN categories c ON n.category_id = c.category_id WHERE n.status = ?';
    if ($category_id) { $sql .= ' AND n.category_id = ?'; }
    $sql .= ' ORDER BY n.publish_date DESC LIMIT ? OFFSET ?';

    if ($category_id) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siii', $status, $category_id, $limit, $offset);
    } else {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sii', $status, $limit, $offset);
    }
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    send_json(['news' => $results]);
}

if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
    $user = require_role(['admin', 'creator']);
    $input = parse_input();

    if ($method === 'POST') {
        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $category_id = isset($input['category_id']) ? intval($input['category_id']) : null;
        $image_url = trim($input['image_url'] ?? '');
        $status = in_array($input['status'] ?? 'Published', ['Draft', 'Published', 'Archived'], true) ? $input['status'] : 'Published';

        if (!$title || !$description) {
            send_error('title and description are required', 422);
        }

        $author_id = intval($user['uid']);
        $stmt = $conn->prepare('INSERT INTO news (title, description, category_id, image_url, author_id, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssissi', $title, $description, $category_id, $image_url, $author_id, $status);
        if (!$stmt->execute()) {
            send_error('Failed to create news', 500);
        }
        $news_id = $stmt->insert_id;
        $stmt->close();
        send_json(['message' => 'News created', 'news_id' => $news_id], 201);
    }

    if ($method === 'PUT') {
        $id = intval($input['news_id'] ?? 0);
        if ($id <= 0) {
            send_error('news_id is required', 422);
        }

        $title = trim($input['title'] ?? '');
        $description = trim($input['description'] ?? '');
        $category_id = isset($input['category_id']) ? intval($input['category_id']) : null;
        $image_url = trim($input['image_url'] ?? '');
        $status = in_array($input['status'] ?? 'Published', ['Draft', 'Published', 'Archived'], true) ? $input['status'] : 'Published';

        $stmt = $conn->prepare('UPDATE news SET title = ?, description = ?, category_id = ?, image_url = ?, status = ? WHERE news_id = ?');
        $stmt->bind_param('ssissi', $title, $description, $category_id, $image_url, $status, $id);
        if (!$stmt->execute()) {
            send_error('Failed to update news', 500);
        }
        $stmt->close();
        send_json(['message' => 'News updated']);
    }

    if ($method === 'DELETE') {
        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            send_error('id is required', 422);
        }
        $stmt = $conn->prepare('UPDATE news SET status = "Archived" WHERE news_id = ?');
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            send_error('Failed to archive news', 500);
        }
        $stmt->close();
        send_json(['message' => 'News archived']);
    }
}

send_error('Unsupported method', 405);
