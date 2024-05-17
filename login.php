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
    <title>Logowanie</title>
</head>
<body>
    <canvas width="" height="" id='main-canvas'></canvas>
    <div id="form">
        <form action="logger.php" method="post">
            <span>Zaloguj się</span>
            <?php
            echo "<input type='text' id='login' name='login' placeholder='login' value='".(isset($_SESSION['login']) ? $_SESSION['login'] : '')."' requied>
                <div id='password-div' style='display: flex; justify-content: center; align-items: center; flex-direction: row;'>
                    <input type='password' id='password' name='password' placeholder='hasło' value='".(isset($_SESSION['password']) ? $_SESSION['password'] : '')."' requied>
                    <div id='show-password' onclick='togglePassword();'></div>
                    <input type='hidden' name='start' id='start'>
                </div>";
            ?>
            <div id="error">
                <?php
                    if(isset($_SESSION['err'])){
                        switch($_SESSION['err']){
                            case 1:
                                echo "Nie udało się połączyć z serwerem. Spróbuj później lub zgłoś to <a href='report.php/?errcode=".(isset($_SESSION['errcode']) ? $_SESSION['errcode'] : null)."&errdesc=".(isset($_SESSION['errdesc']) ? $_SESSION['errdesc'] : null)."'>tutaj</a>";
                                break;
                            case 2:
                                echo "Wystąpił problem z bazą danych. Zgłoś to <a href='report.php/?errcode=".(isset($_SESSION['errcode']) ? $_SESSION['errcode'] : null)."&errdesc=".(isset($_SESSION['errdesc']) ? $_SESSION['errdesc'] : null)."'>tutaj</a>";
                                break;
                            case 3:
                                echo "Niepoprawny login lub hasło";
                                break;
                        }
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
            <input type="submit" class='div-submit' value='zaloguj sie'>
            <a href="register.php">Utwórz konto</a>
        </form>
    </div>

    <?php echo "<script>document.getElementById('start').value = ".time()."</script>"; ?>

    <script>
        function gen(){
            if(bubbles.length > 150){
                bubbles.splice(150);
            }
            let b = [Math.floor(Math.random() * CWidth), Math.floor(Math.random() * CHeight), Math.random() * 2 - 1, Math.random() * 2 - 1, Math.floor(Math.random() * 4 + 1)];
            let n = bubbles.length;
            bubbles.push(b);
            setTimeout(() => {
                bubbles.splice(n, 1);
            }, Math.floor(Math.random() * 10000));
        }

        function anim(){
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
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
        const img = new Image(CWidth, CHeight);
        img.src = 'login-background.jpg';

        for(let i = 0; ++i < 100; gen());

        setInterval(gen, 75);
        setInterval(anim, 10);
  
        const password = document.getElementById("show-password");
        function togglePassword(){
            document.getElementById("password").setAttribute("type", document.getElementById("password").getAttribute("type") == "password" ? "text" : "password");
            if(document.getElementById('password').getAttribute('type') == 'text'){
                password.animate([
                    {filter: 'brightness(200%)'},
                    {filter: 'brightness(100%)'}
                ], {duration: 1500});
            }
            setTimeout(() => {
                if(document.getElementById("password").getAttribute("type") == "text"){
                    togglePassword();
                }
            }, 1500);
        }
    </script>
</body>
</html>
