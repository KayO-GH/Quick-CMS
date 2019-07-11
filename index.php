<?php
session_start();
include_once('includes/connection.php');
include_once('includes/article.php');

$article = new Article;
$articles = $article->fetch_all();
?>

<html>

<head>
	<title>CMS Tutorial</title>
	<link rel="stylesheet" href="assets/style.css" />
</head>

<body>
	<div class="container">
		<a href="index.php" id="logo">CMS</a>
		<ol>
			<?php foreach ($articles as $article) { ?>
				<li>
					<a href="article.php?id=<?php echo $article['article_id']; ?>">
						<?php echo $article['article_title']; ?>
					</a>
					- <small>
						<!-- Use PHP date formatting -->
						posted: <?php echo date('l jS', $article['article_timestamp']); ?>
					</small>
				</li>
			<?php } ?>
		</ol>

		<br>

		<small>
			<?php if (isset($_SESSION['logged_in']) and $_SESSION['logged_in'] == true) { ?>
				<a href="logout.php">Log out</a> | <a href="add.php">Add Article</a>
			<?php } else { ?>
				<a href="admin">admin</a>
			<?php } ?>
		</small>
	</div>
</body>

</html>