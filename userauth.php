<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Art Blog User Authentication</title>
        <link rel="stylesheet" href="css/userauth.css?id=888" Type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Texturina:ital,opsz,wght@0,12..72,100..900;1,12..72,100..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="auth-body-wrapper">
            <div class="login-logo-wrapper">
            <div class="login-logo">
                <img src="logo4.png"></img>
            </div>
            <h2>Login</h2>
            <?php
                session_start();
                include('includes/database.php');

                // check if form was submitted
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    echo "FORM SUBMITTED<br>";
                    // get user input
                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    // checking results with database
                    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) == 1) {
                        $user = mysqli_fetch_assoc($result);

                        $_SESSION['user_id'] = $user['id'];

                        header("Location: edit-post.php");
                        exit;
                    } else {
                        // error message
                        echo "Invalid login";
                    }
                }
                ?>

                <form method="POST" class="login-form">
                    <input type="text" name="username" placeholder="Username"><br>
                    <input type="password" name="password" placeholder="Password"><br>
                    <button type="submit">Login</button>
                </form>
        </div>
        </div>
    </body>
</html>