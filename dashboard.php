<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$userId = getCurrentUserId();
$pdo = getDBConnection();

// Get user info
$stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// Get episode statistics
$stmt = $pdo->prepare("SELECT 
    COUNT(*) as total_episodes,
    SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published_episodes,
    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft_episodes
    FROM episodes WHERE user_id = ?");
$stmt->execute([$userId]);
$stats = $stmt->fetch();

// Get recent episodes
$stmt = $pdo->prepare("SELECT id, title, status, release_date, created_at 
    FROM episodes WHERE user_id = ? 
    ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$userId]);
$recentEpisodes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Podcast CMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Welcome back, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>
                <a href="episode-add.php" class="btn btn-primary">Add New Episode</a>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Episodes</h3>
                    <div class="stat-number"><?php echo $stats['total_episodes']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Published</h3>
                    <div class="stat-number"><?php echo $stats['published_episodes']; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Drafts</h3>
                    <div class="stat-number"><?php echo $stats['draft_episodes']; ?></div>
                </div>
            </div>
            
            <div class="recent-episodes">
                <h2>Recent Episodes</h2>
                <?php if (empty($recentEpisodes)): ?>
                    <div class="empty-state">
                        <p>No episodes yet. <a href="episode-add.php">Create your first episode</a></p>
                    </div>
                <?php else: ?>
                    <div class="episode-list">
                        <?php foreach ($recentEpisodes as $episode): ?>
                            <div class="episode-item">
                                <div class="episode-info">
                                    <h3><a href="episode-edit.php?id=<?php echo $episode['id']; ?>"><?php echo htmlspecialchars($episode['title']); ?></a></h3>
                                    <div class="episode-meta">
                                        <span class="status status-<?php echo $episode['status']; ?>"><?php echo ucfirst($episode['status']); ?></span>
                                        <?php if ($episode['release_date']): ?>
                                            <span class="date">Release: <?php echo date('M j, Y', strtotime($episode['release_date'])); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="episode-actions">
                                    <a href="episode-edit.php?id=<?php echo $episode['id']; ?>" class="btn btn-small">Edit</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="view-all">
                        <a href="episodes.php" class="btn btn-secondary">View All Episodes</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <?php include 'templates/footer.php'; ?>
</body>
</html>

