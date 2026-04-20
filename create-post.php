<?php
$bodyClass = "create-post-page";
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('includes/config.php');
include('includes/database.php');
include('includes/header.php');
?>

<!-- establish database connection -->

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = $_POST['category'];

    $art = ($category === 'art') ? 1 : 0;
    $writing = ($category === 'writing') ? 1 : 0;

    $author = 1;

    $imageName = ''; // default value

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

        $uploadDir = 'uploads/';
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;

        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    // if title and content information is entered, make post/input information
    if (!empty($title) && !empty($content)) {

        $query = "
        INSERT INTO posts (title, content, author, art, writing, image)
        VALUES ('$title', '$content', '$author', '$art', '$writing', '$imageName')
        ";

        $result = mysqli_query($conn, $query);

        $imageName = '';

        // if information is inputted properly, display success message
        if ($result) {
            echo "<p class='post-message'>Post created successfully!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($conn) . "</p>";
        }

    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!-- output HTML, basic CMS structure -->
<div class="cms-body">
    <div class="form-container">
    <h2>Create New Post</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>Upload Image</label><br>
        <input type="file" name="image"><br><br>
        <div class="radio-div">
            <label for="art">Art</label>
            <input type="radio" id="art" name="category" value="art" required>
            <label for="writing">Writing</label>
            <input type="radio" id="writing" name="category" value="writing" required>
        </div>
       
        <label>Title</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content</label><br>
        <textarea name="content" rows="8" required></textarea><br><br>

        <button type="submit">Publish</button>

    </form>
    </div>  
</div>

<?php include('includes/footer.php'); ?>