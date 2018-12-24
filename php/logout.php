<?php
    session_start();

    session_destroy();
    //$_SESSION['status']=0;
    header('Location:index.php');
    exit;
?>