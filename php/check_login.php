<?php
    session_start();

    require_once('conn_sql.php');

    $username = $_POST['login'];
    $password = $_POST['pass'];

    $sql = 'SELECT user, pass FROM compte WHERE user="'.$username.'"';
    $query=$conn->prepare($sql);
    //$query->bindValue('a',$username);
    $query->execute();

    $value = $query->fetch(PDO::FETCH_ASSOC);

   // var_dump($value);

    if($value) {
        if($username == $value['user']) {
            $pass_hash = sha1($password);
            if($pass_hash == $value['pass']){
                $_SESSION['status']=1;
                header('Location:index.php');
                exit;
                //echo "login success";
            } else {
                header('Location:login.php');
                exit;
                //echo "login failure";
            }
        }
    } else {
        header('Location:login.php');
        exit;
        //echo "no data found";
    }
?>