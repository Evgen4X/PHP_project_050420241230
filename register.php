<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tworzenie konta</title>
</head>
<body>
    <div id="form">
        <form action="registrator.php" method="post">
            <span>Załóż konto</span>
            <?php
            echo "<input type='mail' id='email' name='adres_e_mail' placeholder='e-mail' value='".(isset($_GET["email"]) ? $_GET['email'] : '')."' requied>";
            echo "<input type='text' id='login' name='login' placeholder='login' value='".(isset($_GET['login']) ? $_GET['login'] : '')."' requied>";
            echo "<input type='password' id='password' name='password' placeholder='hasło' value='".(isset($_GET['password']) ? $_GET['password'] : '')."' requied>";
            echo "<input type='tel' id='tel' name='telefon' placeholder='telefon' value='".(isset($_GET['tel']) ? $_GET['tel'] : '')."' requied>";
            ?>
            <div id="error">
                <?php
                    if(isset($_GET['err'])){
                        switch($_GET['err']){
                            case 1:
                                echo "Nie udało się połaczyć z serwerem. Spróbuj później";
                                break;
                            case 2:
                                echo "Login jest zajęty. Wymyśl inny";
                                break;
                            case 3:
                                echo "Hasło już jest zajęte. Wymyśl inne";
                                break;
                            case 4:
                                echo "Na ten adres e-mail już jest założone konto";
                                break;
                            case 5:
                                echo "Nie udało się utworzyć konto. Spróbuj później";
                                break;
                            case 6:
                                echo "Hasło ma mieć przynajmniej 8 znaków. W tym: <br><ul>
                                    <li>2 duże litery</li>
                                    <li>2 małe litery</li>
                                    <li>2 cyfry</li>
                                    <li>2 znaki zpecjalne</li>
                                    <li>nie może zawierać ponad 4 znaków z loginu, imienia, nazwiska, adresu e-mail lub telefonu</li>
                                </ul>";
                                break;
                            case 7:
                                echo "Niepoprawny adres e mail";
                                break;
                            case 8:
                                echo "Długość loginu ma być większa niż 6";
                                break;
                            case 9:
                                echo "Niepoprawny number telefonu";
                                break;
                        }
                    } else {
                        echo "";
                    }
                ?>
            </div>
            <input type="submit">
            <a href="login.php">Już masz konto?</a>
        </form>
    </div>
</body>
</html>