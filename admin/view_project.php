<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$project_id = intval($_GET['id']); 


$query = "SELECT * FROM projects WHERE id = $project_id AND user_id = ".$_SESSION['user_id'];
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    echo "Project not found or you do not have permission to view it.";
    exit();
}

$fileQuery = "SELECT * FROM files WHERE project_id = $project_id";
$fileResult = mysqli_query($conn, $fileQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details - <?php echo htmlspecialchars($project['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1><?php echo htmlspecialchars($project['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($project['due_date']); ?></p>

    <h3>Files</h3>
    <ul>
        <?php while($file = mysqli_fetch_assoc($fileResult)) : ?>
            <li>
                <a href="uploads/<?php echo htmlspecialchars($file['filename']); ?>" target="_blank">
                    <?php echo htmlspecialchars($file['filename']); ?>
                </a>
            </li>
        <?php endwhile; ?>
        <?php if(mysqli_num_rows($fileResult) === 0): ?>
            <li>No files uploaded for this project.</li>
        <?php endif; ?>
    </ul>

    <a href="index.php" class="btn btn-secondary mt-3">Back to Projects</a>
</div>
</body>
</html>
