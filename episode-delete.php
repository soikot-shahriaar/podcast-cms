<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$userId = getCurrentUserId();
$episodeId = intval($_GET['id'] ?? 0);

if (!$episodeId) {
    setFlashMessage('error', 'Invalid episode ID.');
    redirect('episodes.php');
}

$pdo = getDBConnection();

// Get episode data to check ownership and get file info
$stmt = $pdo->prepare("SELECT audio_file FROM episodes WHERE id = ? AND user_id = ?");
$stmt->execute([$episodeId, $userId]);
$episode = $stmt->fetch();

if (!$episode) {
    setFlashMessage('error', 'Episode not found.');
    redirect('episodes.php');
}

try {
    // Delete the episode from database
    $stmt = $pdo->prepare("DELETE FROM episodes WHERE id = ? AND user_id = ?");
    
    if ($stmt->execute([$episodeId, $userId])) {
        // Delete associated audio file if exists
        if ($episode['audio_file']) {
            deleteFile('assets/uploads/' . $episode['audio_file']);
        }
        
        setFlashMessage('success', 'Episode deleted successfully.');
    } else {
        setFlashMessage('error', 'Failed to delete episode.');
    }
} catch (PDOException $e) {
    setFlashMessage('error', 'Database error occurred.');
}

redirect('episodes.php');
?>

