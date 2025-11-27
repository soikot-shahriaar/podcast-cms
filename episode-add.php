<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$userId = getCurrentUserId();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $duration = sanitizeInput($_POST['duration'] ?? '');
    $releaseDate = sanitizeInput($_POST['release_date'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? 'draft');
    
    // Validation
    if (empty($title)) {
        $error = 'Episode title is required.';
    } elseif (!in_array($status, ['draft', 'published'])) {
        $error = 'Invalid status selected.';
    } else {
        $audioFile = '';
        
        // Handle file upload if provided
        if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadAudioFile($_FILES['audio_file']);
            if ($uploadResult['success']) {
                $audioFile = $uploadResult['filename'];
            } else {
                $error = $uploadResult['message'];
            }
        }
        
        if (empty($error)) {
            try {
                $pdo = getDBConnection();
                $stmt = $pdo->prepare("INSERT INTO episodes (user_id, title, description, audio_file, duration, release_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                if ($stmt->execute([$userId, $title, $description, $audioFile, $duration, $releaseDate ?: null, $status])) {
                    setFlashMessage('success', 'Episode created successfully!');
                    redirect('episodes.php');
                } else {
                    $error = 'Failed to create episode. Please try again.';
                }
            } catch (PDOException $e) {
                $error = 'Database error. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Episode - Podcast CMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Add New Episode</h1>
                <a href="episodes.php" class="btn btn-secondary">Back to Episodes</a>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="form-container">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Episode Title *</label>
                        <input type="text" id="title" name="title" required 
                               value="<?php echo htmlspecialchars($title ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="5" 
                                  placeholder="Enter episode description..."><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <input type="text" id="duration" name="duration" 
                                   placeholder="e.g., 25:30 or 1:05:20"
                                   value="<?php echo htmlspecialchars($duration ?? ''); ?>">
                            <small>Format: MM:SS or HH:MM:SS</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="release_date">Release Date</label>
                            <input type="date" id="release_date" name="release_date" 
                                   value="<?php echo htmlspecialchars($releaseDate ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="audio_file">Audio File</label>
                        <input type="file" id="audio_file" name="audio_file" 
                               accept="audio/*">
                        <small>Supported formats: MP3, WAV, OGG (Max size: 50MB)</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="draft" <?php echo ($status ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo ($status ?? '') === 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create Episode</button>
                        <a href="episodes.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    
    <?php include 'templates/footer.php'; ?>
</body>
</html>

