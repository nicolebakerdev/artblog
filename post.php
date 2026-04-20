<!DOCTYPE HTML>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Art Blog Post</title>
        <link rel="stylesheet" href="css/styles.css?id=2" Type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="art.php">Art</a></li>
                <li><a href="writing.php">Writing</a></li>
                <li><a href="all.php">All Posts</a></li>
                <li><a href="userauth.php">Admin</a></li>
            </ul>
        </nav>
<div class="post-wrapper">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('includes/config.php');
include('includes/database.php');

// make sure ID exists
if (!isset($_GET['id'])) {
    echo "No post specified.";
    exit;
}

$id = intval($_GET['id']); 

$query = "
SELECT posts.*, users.username 
FROM posts
LEFT JOIN users ON posts.author = users.id
WHERE posts.id = $id
";

$result = mysqli_query($conn, $query);

// check if the query worked
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// check if post exists
if (mysqli_num_rows($result) == 0) {
    echo "Post not found.";
    exit;
}

$post = mysqli_fetch_assoc($result);
?>

<h1><?php echo htmlspecialchars($post['title']); ?></h1>

<div class="post-meta">
    <?php if (!empty($post['username'])): ?>
        By <?php echo htmlspecialchars($post['username']); ?> • 
    <?php endif; ?>

    <?php echo date("F j, Y", strtotime($post['added'])); ?>
</div>

<div class="post-content-row">

    <!-- add image -->
    <?php if (!empty($post['image'])) { ?>
        <div class="post-image">
            <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>">
        </div>
    <?php } ?>

        <!-- add text -->
    <div class="post-text">
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>

</div>
    </body>
</html>