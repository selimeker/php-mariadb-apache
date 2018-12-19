<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Page Title</title>
</head>
<body>
    <?php
        require_once('conn_sql.php');

        // Si le paramétre n'existe pas ou si le paramétre est vide
        if(!isset($_GET['id']) || empty($_GET['id'])){
            echo 'Invalid ID paramter';
            exit;
        }
        if(!is_numeric($_GET['id'])) {
            echo 'ID not a number';
            exit;
        }

        $id=intval($_GET['id']);
        $sql='SELECT * FROM articles WHERE id_article=:a';
        $query=$conn->prepare($sql);
        $query->bindValue('a',$id);
        $query->execute();

        $value = $query->fetch(PDO::FETCH_ASSOC);
        
        if($value) {
            echo 'Article : ';
            echo $value['nom'];
            echo ' - Prix : ';
            echo $value['prix'].' €';
            echo ' - TVA : ';
            echo $value['tva'];
            echo ' % <br>';
            echo '<a href=modifier.php?id='.$id.'>Modifer</a>';
        } else {
            echo 'ID unkown';
        }
    ?>
</body>
</html>