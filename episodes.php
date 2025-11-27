<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

requireLogin();

$userId = getCurrentUserId();
$pdo = getDBConnection();

// Handle search and filter
$search = sanitizeInput($_GET['search'] ?? '');
$status = sanitizeInput($_GET['status'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$itemsPerPage = 10;

// Build query
$whereConditions = ['user_id = ?'];
$params = [$userId];

if (!empty($search)) {
    $whereConditions[] = 'title LIKE ?';
    $params[] = '%' . $search . '%';
}

if (!empty($status) && in_array($status, ['draft', 'published'])) {
    $whereConditions[] = 'status = ?';
    $params[] = $status;
}

$whereClause = 'WHERE ' . implode(' AND ', $whereConditions);

// Get total count for pagination
$countQuery = "SELECT COUNT(*) FROM episodes $whereClause";
$stmt = $pdo->prepare($countQuery);
$stmt->execute($params);
$totalItems = $stmt->fetchColumn();

$pagination = paginate($totalItems, $itemsPerPage, $page);

// Get episodes
$query = "SELECT id, title, description, duration, release_date, status, created_at 
          FROM episodes $whereClause 
          ORDER BY created_at DESC 
          LIMIT {$itemsPerPage} OFFSET {$pagination['offset']}";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$episodes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Episodes - Podcast CMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Episodes</h1>
                <a href="episode-add.php" class="btn btn-primary">Add New Episode</a>
            </div>
            
            <!-- Search and Filter -->
            <div class="filters">
                <form method="GET" class="filter-form">
                    <div class="filter-group">
                        <input type="text" name="search" placeholder="Search episodes..." 
                               value="<?php echo htmlspecialchars($search); ?>">
                        
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="draft" <?php echo $status === 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="published" <?php echo $status === 'published' ? 'selected' : ''; ?>>Published</option>
                        </select>
                        
                        <button type="submit" class="btn btn-secondary">Filter</button>
                        <a href="episodes.php" class="btn btn-outline">Clear</a>
                    </div>
                </form>
            </div>
            
            <!-- Episodes List -->
            <?php if (empty($episodes)): ?>
                <div class="empty-state">
                    <h3>No episodes found</h3>
                    <p>
                        <?php if (!empty($search) || !empty($status)): ?>
                            Try adjusting your search criteria or <a href="episodes.php">view all episodes</a>.
                        <?php else: ?>
                            <a href="episode-add.php">Create your first episode</a> to get started.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="episodes-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Duration</th>
                                <th>Release Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($episodes as $episode): ?>
                                <tr>
                                    <td>
                                        <div class="episode-title">
                                            <strong><?php echo htmlspecialchars($episode['title']); ?></strong>
                                            <?php if ($episode['description']): ?>
                                                <div class="episode-description">
                                                    <?php echo htmlspecialchars(substr($episode['description'], 0, 100)); ?>
                                                    <?php if (strlen($episode['description']) > 100): ?>...<?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status status-<?php echo $episode['status']; ?>">
                                            <?php echo ucfirst($episode['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($episode['duration'] ?: 'N/A'); ?></td>
                                    <td>
                                        <?php if ($episode['release_date']): ?>
                                            <?php echo date('M j, Y', strtotime($episode['release_date'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">Not set</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="episode-edit.php?id=<?php echo $episode['id']; ?>" class="btn btn-small">Edit</a>
                                        <a href="episode-delete.php?id=<?php echo $episode['id']; ?>" 
                                           class="btn btn-small btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this episode?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="pagination">
                        <?php if ($pagination['current_page'] > 1): ?>
                            <a href="?page=<?php echo $pagination['current_page'] - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status); ?>" class="btn btn-small">Previous</a>
                        <?php endif; ?>
                        
                        <span class="page-info">
                            Page <?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?>
                        </span>
                        
                        <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                            <a href="?page=<?php echo $pagination['current_page'] + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status); ?>" class="btn btn-small">Next</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include 'templates/footer.php'; ?>
</body>
</html>

