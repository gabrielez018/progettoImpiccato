

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once 'tools.php';
        $level = $_POST["level"];
        
        $_SESSION["secretWord"] = getWord($level);
        echo $_SESSION["secretWord"];
    ?>
</body>
</html>