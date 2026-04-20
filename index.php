<?php


// create database connection
include(__DIR__ . '/includes/config.php');
include(__DIR__ . '/includes/database.php');
include(__DIR__ . '/includes/functions.php');
include(__DIR__ . '/includes/header.php');
?>

<div class="page-container">
        <div class="header-section">
        <div class="header-logo">
            <img src="logo4.png" alt="Art Blog Logo">
        </div>
        <!-- hardcoded website information -->
        <div class="header">
            <h1>Kylie's Art Blog</h1>
        </div>
        <div class="header-caption">
            <h3>Sample text for caption of website</h3>
        </div>
        <div class="cross-platform-links">
            <!-- links to client's art social medias -->
            <a href="https://www.instagram.com/kylies_artaccount/">Instagram @</a>
            <span>&nbsp • &nbsp</span>
            <a href="https://x.com/kylies_artpage">X @</a>
            <span>&nbsp • &nbsp</span>
            <a href="https://www.tiktok.com/@knb1807?_r=1&_t=ZP-95UAujqIYdL">TikTok @</a>
        </div>
    </div>

    <div class="content">
        <div class="main-about">
            <h2>About This Blog</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed mi urna. <br><br> In nisl enim, iaculis at est nec, fermentum eleifend metus. Sed quis rutrum magna. Integer finibus in justo in suscipit. Etiam euismod lacus nec condimentum dignissim. <br><br> Praesent ac faucibus velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum a arcu ultrices lectus mattis aliquet vel in magna. Proin malesuada ullamcorper felis, ac suscipit augue suscipit nec.</p>
        </div>
        <div class="latest-posts">
            <div class="latest-posts-link">
                <h2><a href="all.php">Latest 5 Posts → </a></h2>
            </div>
            <div class="latest-posts-main-wrapper">
                <div class="latest-posts-main">
                    <!-- fetch posts from database -->
                    <ul>
                        <?php
                            $query = "
                            SELECT posts.id, posts.title, posts.added, posts.content, users.username
                            FROM posts
                            LEFT JOIN users ON posts.author = users.id
                            ORDER BY posts.added DESC
                            LIMIT 5
                            ";

                            $result = mysqli_query($conn, $query);

                            // output HTML
                            while($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <li class="list-wrapper">
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
        </div>
    </div>
    </div>
    
<?php
include('includes/footer.php');
?>