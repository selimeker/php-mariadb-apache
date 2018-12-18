<?php
    session_start();

    if(!isset($_SESSION['status'])) {
        header('Location:login.php');
        exit;
    } else if ($_SESSION['status'] != 1) {
        header('Location:login.php');
        exit;
    }
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

        $id=$_GET['id'];
        $nom=$_POST['nom'];
        $prix=$_POST['prix'];
        $tva=$_POST['tva'];

        $sql='UPDATE articles SET nom=:n, prix=:p, tva=:t WHERE id_article=:id';

        $data = [
            'n' => $nom,
            'p' => $prix,
            't' => $tva,
            'id' => $id
        ];

        $query=$conn->prepare($sql)->execute($data);

        $sql='DELETE FROM articles_couleurs WHERE id_article=:d';

        $query=$conn->prepare($sql);
        $query->bindValue('d', $id);
        if(!$query->execute()) {echo "erreur delete"; exit;}

        if(isset($_POST['couleurs'])){
            foreach($_POST['couleurs'] as $couleur){
                $sql='INSERT INTO articles_couleurs (id_article, id_couleur) VALUE (:ida, :idc)';
                $query=$conn->prepare($sql);
                $query->bindValue('ida', $id);
                $query->bindValue('idc', $couleur);
                if(!$query->execute()) {echo "erreur delete"; exit;}
            }
        }
    ?>
</body>
</html>