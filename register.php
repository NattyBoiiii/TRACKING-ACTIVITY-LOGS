<?php
require_once "core/models.php";
require_once "core/handleForms.php";
require_once 'core/dbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale1.0">
    <title>Document</title>
    <style>
        body {
            font-family: "Arial"
        }
        input {
            font-size: 1.5em;
            height: 50 px;
            width: 200px;
        }
        table, th, td {
            border:1px solid black;
        }
        </style>
</head>
<body>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
    <?php } unset($_SESSION['message']); ?>
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username">
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password">
            <input type="submit" name="registerUserBtn">
        </p>
    </form>
</body>
</html>