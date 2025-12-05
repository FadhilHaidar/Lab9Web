<?php
// index.php - Front controller + simple routing
session_start();
require __DIR__ . '/config/database.php';
require __DIR__ . '/config/helpers.php';


// Default page
$page = $_GET['page'] ?? 'user/list';
// Normalize (prevent directory traversal)
$page = preg_replace('#[^a-zA-Z0-9_\-/]#', '', $page);


// Resolve view file
$parts = explode('/', $page);
$viewPath = __DIR__ . '/views/' . implode('/', $parts) . '.php';


if (!file_exists($viewPath)) {
http_response_code(404);
echo "<h1>404 - Page not found</h1><p>Requested: " . htmlspecialchars($page) . "</p>";
exit;
}


// Use a layout: header + content + footer
require __DIR__ . '/views/layout/header.php';
require $viewPath;
require __DIR__ . '/views/layout/footer.php';
?>