<?php
    session_start();

    if(!isset($_SESSION['status'])) {
        header('Location:login.php');
        exit;
    } else if($_SESSION['status'] != 1) {
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
        
        // Si le paramétre n'existe pas ou si le paramétre est vide
        if(!isset($_GET['id']) || empty($_GET['id'])) {
            echo 'Invalid ID paramter';
            exit;
        }
        if(!is_numeric($_GET['id'])) {
            echo 'ID not a number';
            exit;
        }

        $id = $_GET['id'];
        $nom = $_POST['nom'];
        $prix = $_POST['prix'];
        $tva = $_POST['tva'];
        $cat = $_POST['categorie'];

        $sql='UPDATE articles SET nom=:n, prix=:p, tva=:t, id_categorie=:c WHERE id_article=:id';

        $data = [
            'n' => $nom,
            'p' => $prix,
            't' => $tva,
            'c' => $cat,
            'id' => $id
        ];

        $query = $conn->prepare($sql)->execute($data);

        $sql = 'DELETE FROM articles_couleurs WHERE id_article=:d';

        $query=$conn->prepare($sql);
        $query->bindValue('d', $id);
        //if(!$query->execute()) {echo "erreur delete"; exit;}

        if(isset($_POST['couleurs'])) {
            foreach($_POST['couleurs'] as $couleur) {
                $sql = 'INSERT INTO articles_couleurs (id_article, id_couleur) VALUE (:ida, :idc)';
                $query = $conn->prepare($sql);
                $query->bindValue('ida', $id);
                $query->bindValue('idc', $couleur);
                //if(!$query->execute()) {echo "erreur delete"; exit;}
            }
        }
    ?>
</body>
</html>