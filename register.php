<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Ksiegarnia Internetowa</title>
</head>
<body>
    <form action="registrator.php" method="post">
        <fieldset>
            <legend>Register</legend>
            <input type="text" id="imie" requied>
            <input type="text" id="nazwisko" requied>
            <input type="tel" id="tel" requied>
            <input type="mail" id="email" requied>
            <input type="login" id="login" requied>
            <input type="password" id="haslo" requied>
            <button onclick="check();">
            <a href="login.php">Already have an account?</a>
        </fieldset>
    </form>

    <script>
        function check(){
            if(document.getElementById("password").value.length < 8){
                return 1;
            }
            return 0;
        }
    </script>
</body>
</html>