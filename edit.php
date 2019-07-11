<?php
session_start();
include_once('includes/connection.php');
include_once('includes/article.php');

$article = new Article;

if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) {
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $data = $article->fetch_data($id);
    }
    /* 
     * Check if form was just submitted
     * If it was, validate details and POST
     * If it wasn't display Edit Article form
     */
    if(isset($_POST['id'], $_POST['title'], $_POST['content'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = str_replace("\r\n", "<br />", $_POST['content']);

        if(empty($title) or empty($content)){
            $error = 'All fields are required';
        }else{
            $query = $pdo->prepare("UPDATE articles SET article_title = ?, article_content = ? WHERE article_id = ?");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, $id);

            $query->execute();

            header('Location: article.php?id='.$id);
            exit();
        }
    }
    ?>
    <!-- Display form -->
    <html>

    <head>
        <title>CMS Tutorial</title>
        <link rel="stylesheet" href="assets/style.css" />
    </head>

    <body>
        <div class="container">
            <a href="index.php" id="logo">CMS</a>

            <br />

            <h4>Edit Article</h4>
            <?php
            if (isset($error)) {
                ?>
                <small style="color:#a00">
                    <?php echo $error; ?>
                </small>
            <?php
            }
            ?>
            <form action="edit.php" method="post" autocomplete="off">
                <input type="text" name="title" placeholder="Title" required
                    value="<?php echo $data['article_title']; ?>"/>
                <br/><br/>
                <textarea name="content" cols="50" rows="15" placeholder="Content" required
                    ><?php 
                        echo str_replace("<br />","\r\n", $data['article_content']); 
                    ?></textarea>
                    <input type="hidden" name="id" value="<?php echo $data['article_id']; ?>">
                <br/><br/>
                <input type="submit" value="Save">
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