<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Page Title</title>
</head>
<body>
    <?php
        require_once('conn_sql.php');

        $sql='SELECT id_article, nom FROM articles ORDER BY nom';
        $query=$conn->prepare($sql);
        $query->execute();

        $value = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($value as $article) {
            echo '<a target=_blank href=article.php?id='.$article['id_article'].'>';
            echo $article['nom'];
            echo '</a><br>';
		}
		
		if ($_SESSION['status']==1){
			echo '<a href="logout.php">Logout</a>';
		}
    ?>
</body>
</html>