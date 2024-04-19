<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ksiegarnia Internetowa</title>
</head>
<body>
    <?php
    $id = mysqli_connect("localhost", "root", "", "ksiegarnia");
    echo "<nav>
        <div><a href='login.php'>Log in</a></div>".
        (isset($_GET['uid']) ? "<div><a href='settings.php?uid=".$_GET['uid']."'>Ustawienia</a></div>" : "").
        (mysqli_query()).
        "</nav>";

    echo "<main><div id='main'>";

    for($i = 1; $i < 100; ++$i){
        $book = mysqli_query($id, "select ksiazki.tytul, concat(substr(autor.imie, 1, 1), '. ', autor.nazwisko), ksiazki.cena,  ksiazki.gatunek, ksiazki.jezyk_ksiazki, ksiazki.rok_wydania, ksiazki.id_ksiazki from ksiazki join autor using (id_autora) limit $i, 1;");
        if($book){
            $data = mysqli_fetch_row($book);
            echo "<div class='ksiazka'>
                    <form action='order.php' method='post'>
                        <h2>".$data[0]."</h2>
                        <div class='autor'>".$data[1]."</div>
                        <div class='cena'>".$data[2]."</div>
                        <div class='gatunek'>".$data[3]."</div>
                        <div class='jezyk'>".$data[4]."</div>
                        <div class='rok'>".$data[5]."</div>
                        <input type='hidden' name='data' value=".$data[6].">
                        ".(isset($_GET['uid']) ? "
                        <input type='hidden' name='uid' value='".$_GET['uid']."'>
                        <input type='submit' class='kup' value='kup'>" : "<a href='login.php' class='div-submit'>kup</a>")."
                    </form>
                </div>"; //TODO
        }
    }

    echo "</div></main>";
      
    echo "<footer>Created by <a href='https://github.com/Evgen4X'>Evgen4X</a></footer>";

    ?>
</body>
</html>