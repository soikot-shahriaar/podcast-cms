<?php
if (!function_exists('isLoggedIn')) {
    require_once 'includes/functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Podcast CMS</title>
</head>
<body>
<header class="header">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="dashboard.php" class="brand-link">
                    <i class="fas fa-podcast"></i>
                    <span>Podcast CMS</span>
                </a>
            </div>
            
            <?php if (isLoggedIn()): ?>
                <div class="nav-menu">
                    <a href="dashboard.php" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="episodes.php" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span>Episodes</span>
                    </a>
                    <a href="episode-add.php" class="nav-link">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Episode</span>
                    </a>
                </div>
                
                <div class="nav-user">
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <span class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                    <a href="logout.php" class="btn btn-small btn-outline">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>

<!-- Flash Messages -->
<?php
$flashMessages = getFlashMessages();
foreach ($flashMessages as $message):
?>
    <div class="alert alert-<?php echo $message['type']; ?>" style="margin: 20px auto; max-width: 1200px;">
        <i class="fas fa-info-circle"></i>
        <?php echo htmlspecialchars($message['message']); ?>
    </div>
<?php endforeach; ?>

