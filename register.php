<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="icon.png">
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tworzenie konta</title>
</head>
<body>
    <canvas width="" height=""></canvas>
    <div id="form">
        <form action="registrator.php" method="post">
            <span>Załóż konto</span>
            <?php
            echo "<input type='mail' id='email' name='adres_e_mail' placeholder='e-mail' value='".(isset($_SESSION["email"]) ? $_SESSION['email'] : '')."' requied>";
            echo "<input type='text' id='login' name='login' placeholder='login' value='".(isset($_SESSION['login']) ? $_SESSION['login'] : '')."' requied>";
            echo "<div id='password-div' style='display: flex; justify-content: center; align-items: center; flex-direction: row;'>
                <input type='password' id='password' name='password' placeholder='hasło' value='".(isset($_SESSION['password']) ? $_SESSION['password'] : '')."' requied>
                <div id='show-password' onclick='togglePassword();'></div>
            </div>";
            echo "<input type='tel' id='tel' name='telefon' placeholder='telefon' value='".(isset($_SESSION['tel']) ? $_SESSION['tel'] : '')."' requied>";
            ?>
            <div id="error">
                <?php
                    if(isset($_SESSION['err'])){
                        switch($_SESSION['err']){
                            case 1:
                                echo "Nie udało się połaczyć z serwerem. Spróbuj później albo zgłoś to <a href='report.php/?errcode=".(isset($_SESSION['errcode']) ? $_SESSION['errcode'] : null)."&errdesc=".(isset($_SESSION['errdesc']) ? $_SESSION['errdesc'] : null)."'>tutaj</a>";
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
                                echo "Nie udało się utworzyć konto. Spróbuj później. Zgłoś to <a href='report.php/?errcode=".(isset($_SESSION['errcode']) ? $_SESSION['errcode'] : null)."&errdesc=".(isset($_SESSION['errdesc']) ? $_SESSION['errdesc'] : null)."'>tutaj</a>";
                                break;
                            case 6:
                                echo "Hasło ma mieć przynajmniej 8 znaków. W tym: <br><ul>
                                    <li>2 duże litery</li>
                                    <li>2 małe litery</li>
                                    <li>2 cyfry</li>
                                    <li>2 znaki zpecjalne</li>
                                    <li>liczba dzieląca się przez 5</li>
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
            <div id="error-desc">
                <?php
                    if(isset($_SESSION['errdesc'])){
                        echo 'Błąd '.$_SESSION['errdesc'];
                    }
                ?>
            </div>
            <input type="submit">
            <a href="login.php">Już masz konto?</a>
        </form>
    </div>

    <script>
        function gen(){
            let b = [Math.floor(Math.random() * CWidth), Math.floor(Math.random() * CHeight), Math.random() * 2 - 1, Math.random() * 2 - 1, Math.floor(Math.random() * 4 + 1)];
            let n = bubbles.length;
            bubbles.push(b);
            setTimeout(() => {
                bubbles.splice(n, 1);
            }, Math.floor(Math.random() * 10000));
        }

        function anim(){
            ctx.fillStyle = "black";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "white";
            bubbles.forEach(bubble => {
                bubble[0] += bubble[2];
                bubble[1] += bubble[3];
                if(bubble[0] < -20 || bubble[0] > CWidth + 20){
                    bubble[0] = Math.floor(Math.random() * CWidth);
                    bubble[1] = Math.floor(Math.random() * CHeight);
                    bubble[2] *= Math.random() - 0.5;
                    bubble[3] *= Math.random() - 0.5;
                }
                if(bubble[1] < -20 || bubble[1] > CHeight + 20){
                    bubble[0] = Math.floor(Math.random() * CWidth);
                    bubble[1] = Math.floor(Math.random() * CHeight);
                    bubble[2] *= Math.random() - 0.5;
                    bubble[3] *= Math.random() - 0.5;
                }
                if(Math.random() < 0.05){
                    bubble[2] += Math.random() * 2 - 1;
                    bubble[3] += Math.random() * 2 - 1;
                }
                if(bubble[2] > 10){bubble[2] = 0;}
                if(bubble[3] > 10){bubble[3] = 0;}
                ctx.beginPath();
                ctx.arc(bubble[0], bubble[1], bubble[4], 0, 360);
                ctx.fill();
            });
        }

        function canvasClicked(event){
            let x = event.clientX;
            let y = event.clientY;
            bubbles.forEach(bubble => {
                if(Math.sqrt(Math.pow(bubble[0] - x, 2) + Math.pow(bubble[1] - y, 2)) < 200){
                    bubble[2] = (x - bubble[0]) / 20;
                    bubble[3] = (y - bubble[1]) / 20;
                }
            });
        }

        const canvas = document.querySelector('canvas');
        document.querySelectorAll('*').forEach(idk => {idk.onmousemove = canvasClicked;});

        const CWidth = window.innerWidth;
        const CHeight = window.innerHeight;

        canvas.setAttribute("width", CWidth);
        canvas.setAttribute("height", CHeight);

        const ctx = canvas.getContext('2d');

        var bubbles = [];

        for(let i = 0; ++i < 200; gen());

        setInterval(gen, 75);
        setInterval(anim, 10);

        const password = document.getElementById("show-password");
        function togglePassword(){
            document.getElementById("password").setAttribute("type", document.getElementById("password").getAttribute("type") == "password" ? "text" : "password");
            if(document.getElementbyId('password').getAttribute('type') == 'text'){
                password.animate([
                    {filter: 'brightness(200%)'},
                    {filter: 'brightness(100%)'}
                ], {duration: 750});
            }
            setTimeout(() => {
                if(document.getElementById("password").getAttribute("type") == "text"){
                    togglePassword();
                }
            }, 750);
        }
    </script>
</body>
</html>