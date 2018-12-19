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
    echo '
    <form method="POST" action="check_login.php">
        Username : <input type="text" name="login"><br>
        Password : <input type="password" name="pass"><br>
        <input type="submit">
    </form>'
    ?>
</body>
</html>