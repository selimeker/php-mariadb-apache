<?php
    $conn = new PDO('mysql:host=db;dbname=shop2;charset=utf8', 'root', 'toor');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>