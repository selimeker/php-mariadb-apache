<?php
    session_start();

    require_once('conn_sql.php');

    $username = $_POST['login'];
    $password = $_POST['pass'];

    $sql = 'SELECT user, pass FROM compte WHERE user="'.$username.'"';
    $query = $conn->prepare($sql);
    $query->execute();

    $value = $query->fetch(PDO::FETCH_ASSOC);

    if($value) {
        if($username == $value['user']) {
            $pass_hash = sha1($password);
            if($pass_hash == $value['pass']){
                $_SESSION['status']=1;
                header('Location:index.php');
                exit;
            } else {
                header('Location:login.php');
                exit;
            }
        }
    } else {
        header('Location:login.php');
        exit;
    }
?>