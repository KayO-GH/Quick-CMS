<?php
session_start();
include_once('../includes/connection.php');

if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    /* 
     * Check if form was just submitted
     * If it was, validate details and POST
     * If it wasn't display Add Article form
     */
    if(isset($_POST['title'], $_POST['content'])){
        $title = $_POST['title'];
        $content = nl2br($_POST['content']);

        if(empty($title) or empty($content)){
            $error = 'All fields are required';
        }else{
            $query = $pdo->prepare("INSERT INTO articles (article_title, article_content, article_timestamp) VALUES (?, ?, ?)");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, time());

            $query->execute();

            header('Location: index.php');
            exit();
        }
    }
    ?>
    <!-- Display form -->
    <html>

    <head>
        <title>CMS Tutorial</title>
        <link rel="stylesheet" href="../assets/style.css" />
    </head>

    <body>
        <div class="container">
            <a href="index.php" id="logo">CMS</a>

            <br />

            <h4>Add Article</h4>
            <?php
            if (isset($error)) {
                ?>
                <small style="color:#a00">
                    <?php echo $error; ?>
                </small>
            <?php
            }
            ?>
            <form action="add.php" method="post" autocomplete="off">
                <input type="text" name="title" placeholder="Title" required/>
                <br/><br/>
                <textarea name="content" cols="50" rows="15" placeholder="Content" required></textarea>
                <br/><br/>
                <input type="submit" value="Add Article">
            </form>
        </div>
    </body>

    </html>
<?php
} else {
    //redirect to index
    header('Location: index.php');
}
?>