<?php
    session_start();

    $_SESSION['status']=0;
    header('Location:index.php');
    exit;
?>