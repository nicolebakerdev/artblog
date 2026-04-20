<?php ini_set('display_errors', 1);
error_reporting(E_ALL);

// create database connection
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');

include('includes/header.php');
?>

<div class="edit-body">
    <?php
// handle selected post
$selectedPost = null;

// load post into form
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $query = "SELECT * FROM posts WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    $selectedPost = mysqli_fetch_assoc($result);
}
?>

<div class="cms-body">
    <div class="edit-form-container">

    <a href="create-post.php">Create New Post</a>
    
    <h2>Manage Posts</h2>

    <!-- dropdown for selecting post -->

    <form method="GET" action="">
        <label>Select a Post</label><br>

        <select name="id" required>
            <option value="">-- Choose a post --</option>

            <?php
            $postsQuery = "SELECT id, title FROM posts ORDER BY id DESC";
            $postsResult = mysqli_query($conn, $postsQuery);

            while ($row = mysqli_fetch_assoc($postsResult)) {
                $selected = (isset($_GET['id']) && $_GET['id'] == $row['id']) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['title']}</option>";
            }
            ?>
        </select>

        <button type="submit">Load Post</button>
    </form>


    <!-- edit/delete form -->

    <?php if ($selectedPost): ?>

        <!-- update post -->
        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $selectedPost['id']; ?>">

            <label>Title</label><br>
            <input type="text" name="title"
                   value="<?php echo htmlspecialchars($selectedPost['title']); ?>" required><br><br>

            <label>Content</label><br>
            <textarea name="content" rows="8" required><?php
                echo htmlspecialchars($selectedPost['content']);
            ?></textarea><br><br>

            <button type="submit" name="update">Update Post</button>
            <button type="submit" name="delete"
                    onclick="return confirm('Are you sure you want to delete this post?');">
                Delete Post
            </button>

        </form>

    <?php endif; ?>

    </div>
</div>

<?php
// update post logic
if (isset($_POST['update'])) {

    $id = (int) $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $query = "
        UPDATE posts 
        SET title='$title', content='$content'
        WHERE id=$id
    ";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p class='post-message'>Post updated successfully!</p>";
    } else {
        echo "<p>Error updating post: " . mysqli_error($conn) . "</p>";
    }
}

// delete post logic
if (isset($_POST['delete'])) {

    $id = (int) $_POST['id'];

    $query = "DELETE FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<p class='post-message'>Post deleted successfully!</p>";
    } else {
        echo "<p>Error deleting post: " . mysqli_error($conn) . "</p>";
    }
}

include('includes/footer.php');
?>