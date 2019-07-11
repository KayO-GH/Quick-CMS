<?php
session_start();
include_once('includes/connection.php');
include_once('includes/article.php');

$article = new Article;

if (isset($_GET['id'])) {
    //display article
    $id = $_GET['id'];
    $data = $article->fetch_data($id);

    ?>
    <html>

    <head>
        <title>CMS Tutorial</title>
        <link rel="stylesheet" href="assets/style.css" />
    </head>

    <body>
        <div class="container">
            <a href="index.php" id="logo">CMS</a>
            <h4>
                <?php echo $data['article_title']; ?> -
                <small>posted: <?php echo date('l jS', $data['article_timestamp']); ?></small>
            </h4>
            <p>
                <?php echo $data['article_content']; ?>
            </p>

            <?php if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) { ?>
                <a href="admin/delete.php?id=<?php echo $data['article_id']; ?>">
                    &times; Delete
                </a> 
                <a href="edit.php?id=<?php echo $data['article_id']; ?>">
                     Edit
                </a>
                <br /><br />
            <?php } ?>

            
            <a href="index.php">&larr; Back</a>


        </div>
    </body>

    </html>
<?php
} else {
    header('Location: index.php');
    exit();
}
?>