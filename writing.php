<?php ini_set('display_errors', 1);
error_reporting(E_ALL);

// create database connection
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');

include('includes/header.php');
?>

<?php
$query = "SELECT * FROM posts WHERE category = 'art'";
?>

<div class="writing-grid-wrapper">
    <div class="latest-posts-writing">
        <!-- fetch posts from database -->
        <ul>
            <?php
                $query = "
                SELECT posts.id, posts.content, posts.title, posts.added, users.username, posts.writing
                FROM posts
                LEFT JOIN users ON posts.author = users.id
                WHERE writing = '1'
                ORDER BY posts.added DESC
                ";

                $result = mysqli_query($conn, $query);

                // output HTML
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                    <li class="art-list-wrapper">
                        <h2>
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['title']); ?>
                            </a> <br>                             
                            - <?php echo date("F j, Y", strtotime($row['added'])); ?> -
                        </h2>
                        <h3>
                            <?php echo htmlspecialchars($row['content']); ?>  

                            <?php if($row['username']) { ?>
                                by <?php echo htmlspecialchars($row['username']); ?>
                            <?php } ?>
                        </h3>
                    </li>
            <?php
            }
            ?>

        </ul>
    </div>
</div>