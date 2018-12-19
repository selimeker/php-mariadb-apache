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

        $id = intval($_GET['id']);
        $sql = 'SELECT * FROM articles WHERE id_article=:a';
        $query = $conn->prepare($sql);
        $query->bindValue('a', $id);
        $query->execute();

        $value = $query->fetch(PDO::FETCH_ASSOC);
        
        if($value) {
            echo '<form method="POST" action="update.php?id='.$_GET['id'].'">';
            echo 'Nom de l\'article :<br>';
            echo '<input type="text" value="'.$value['nom'].'" name="nom" placeholder="'.$value['nom'].'" ><br>';
            echo 'Prix :<br>';
            echo '<input type="text" value="'.$value['prix'].'" name="prix" placeholder="'.$value['prix'].'"><br>';
            echo 'TVA :<br>';
            echo '<input type="text" value="'.$value['tva'].'" name="tva" placeholder="'.$value['tva'].'"><br>';
        } else {
            echo 'ID unkown';
        }

        $sql = 'SELECT couleurs.couleur, couleurs.id_couleur, articles_couleurs.id_article 
        FROM couleurs 
        LEFT JOIN articles_couleurs ON articles_couleurs.id_couleur = couleurs.id_couleur AND articles_couleurs.id_article=:a 
        ORDER BY couleurs.couleur';

        $query = $conn->prepare($sql);
        $query->bindValue('a', $id);
        $query->execute();

        $value = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($value as $article) {
            if(!is_null($article['id_article'])) {
                echo $article['couleur'].'<input type="checkbox" name="couleurs[]" value="'.$article['id_couleur'].'"checked><br>';
            } else {
                echo $article['couleur'].'<input type="checkbox" name="couleurs[]" value="'.$article['id_couleur'].'"><br>';
            }
        }

        $sql = 'SELECT categories.nom_categorie, categories.id_categorie, articles.id_article 
        FROM categories 
        LEFT JOIN articles ON articles.id_categorie = categories.id_categorie AND articles.id_article=:a 
        ORDER BY categories.nom_categorie'; 

        $query = $conn->prepare($sql);
        $query->bindValue('a',$id);
        $query->execute();

        $value = $query->fetchAll(PDO::FETCH_ASSOC);

        echo '<select name="categorie">';
        foreach($value as $categorie) {
            if(!is_null($categorie['id_article'])) {
                echo '<option value='.$categorie['id_categorie'].' selected>'.$categorie['nom_categorie'].'</option>';
            } else {
                echo '<option value='.$categorie['id_categorie'].'>'.$categorie['nom_categorie'].'</option>';
            }
        }
        echo '</select><br>';

        echo '<input type="submit" value="Modifier"><br><br>';
        echo '</form>'; 
    ?>
</body>
</html>