<?php
// Common functions for the Podcast CMS

// Get base URL for the project (without port)
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Remove port if present (especially port 8080) to use default port
    $host = preg_replace('/:\d+$/', '', $host);
    
    // Get the script directory
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $scriptDir = dirname($scriptName);
    
    // If script is in root, return just the host
    if ($scriptDir === '/' || $scriptDir === '\\') {
        return $protocol . '://' . $host;
    }
    
    // Build base URL with project directory
    return $protocol . '://' . $host . $scriptDir;
}

// Redirect helper function that ensures correct URL without port
function redirect($path) {
    $baseUrl = getBaseUrl();
    $path = ltrim($path, '/');
    
    // Build the redirect URL
    $redirectUrl = rtrim($baseUrl, '/') . '/' . $path;
    
    header('Location: ' . $redirectUrl);
    exit;
}

// Start session if not already started
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Check if user is logged in
function isLoggedIn() {
    startSession();
    return isset($_SESSION['user_id']);
}

// Get current user ID
function getCurrentUserId() {
    startSession();
    return $_SESSION['user_id'] ?? null;
}

// Redirect to login if not authenticated
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}

// Sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Generate CSRF token
function generateCSRFToken() {
    startSession();
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    startSession();
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Format duration from seconds to MM:SS
function formatDuration($seconds) {
    if (!is_numeric($seconds)) return $seconds;
    $minutes = floor($seconds / 60);
    $seconds = $seconds % 60;
    return sprintf('%02d:%02d', $minutes, $seconds);
}

// Validate file upload
function validateAudioFile($file) {
    $allowedTypes = ['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'];
    $maxSize = 50 * 1024 * 1024; // 50MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "File upload error.";
    }
    
    if ($file['size'] > $maxSize) {
        return "File size too large. Maximum 50MB allowed.";
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($mimeType, $allowedTypes)) {
        return "Invalid file type. Only audio files are allowed.";
    }
    
    return true;
}

// Upload audio file
function uploadAudioFile($file, $uploadDir = 'assets/uploads/') {
    $validation = validateAudioFile($file);
    if ($validation !== true) {
        return ['success' => false, 'message' => $validation];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $uploadPath = $uploadDir . $filename;
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return ['success' => true, 'filename' => $filename, 'path' => $uploadPath];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file.'];
    }
}

// Delete file
function deleteFile($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return true;
}

// Flash message system
function setFlashMessage($type, $message) {
    startSession();
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function getFlashMessages() {
    startSession();
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

// Pagination helper
function paginate($totalItems, $itemsPerPage, $currentPage) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $itemsPerPage;
    
    return [
        'total_pages' => $totalPages,
        'current_page' => $currentPage,
        'offset' => $offset,
        'items_per_page' => $itemsPerPage
    ];
}
?>

