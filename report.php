<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <div id="form">
        <form action="reporter.php" method="post">
            <span>Zgłoś problem</span>
            <textarea name="description"><?php echo (isset($_GET['errcode']) ? "Problem id: ".$_GET['errcode'] : '');?>
            <?php echo (isset($_GET['errdesc']) ? "Problem description: ".$_GET['errdesc'] : '');?></textarea>
            <div id="error">
                <?php
                    if(isset($_GET['err'])){
                        switch($_GET['err']){
                            case 1:
                                echo "Nie udało się połączyć z serwerem. Spróbuj później";
                                break;
                            case 2:
                                echo "Wystąpił problem z bazą danych. Nie możesz tego nawet zgłosić...";
                                break;
                        }
                    }
                ?>
            </div>
            <input type="submit">
        </form>
    </div>
</body>
</html>