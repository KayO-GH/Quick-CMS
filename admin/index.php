<?php
//start session
session_start();
include_once('../includes/connection.php');

if (isset($_SESSION['logged_in'])) {
    //display index
    ?>
    <html>

    <head>
        <title>CMS Tutorial</title>
        <link rel="stylesheet" href="../assets/style.css" />
    </head>

    <body>
        <div class="container">
            <a href="../index.php" id="logo">CMS</a>
            
            <br />

            <ol>
                <li><a href="../index.php">View Articles</a></li>
                <li><a href="add.php">Add Article</a></li>
                <li><a href="delete.php">Delete Article</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ol>
        </div>
    </body>

    </html>
<?php
} else {
    /* 
     * Check if form was just submitted
     * If it was, validate details and log in
     * If it wasn't display log in screen
     */
    if (isset($_POST['username'], $_POST['password'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        if (empty($username) or empty($password)) {
            $error = 'All fields are required';
        } else {
            $query = $pdo->prepare("SELECT * FROM users WHERE user_name = ? AND user_password = ?");
            $query->bindValue(1, $username);
            $query->bindValue(2, $password);
            $query->execute();

            $num = $query->rowCount();

            if ($num == 1) {
                // correct details
                $_SESSION['logged_in'] = true; // set session logged_in
                header('Location: index.php'); // reload page - now since logged in, page should display admin interface
                exit(); // exit script so the rest is not rendered
            } else {
                // false details
                $error = 'Incorrect details';
            }
        }
    }
    ?>
    <html>

    <head>
        <title>CMS Tutorial</title>
        <link rel="stylesheet" href="../assets/style.css" />
    </head>

    <body>
        <div class="container">
            <a href="../index.php" id="logo">CMS</a>
            <br /><br />
            <?php
            if (isset($error)) {
                ?>
                <small style="color:#a00">
                    <?php echo $error; ?>
                </small>
            <?php
            }
            ?>
            <form action="index.php" method="post" autocomplete="off">
                <!-- autocomplete="off" so we don't autocomplete passwords -->
                <input type="text" name="username" placeholder="Username" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="submit" value="Login">
            </form>
        </div>
    </body>

    </html>
<?php
}
?>