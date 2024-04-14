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
    echo "<nav>
        <div><a href='login.php'>Log in</a></div>".
        (isset($_GET['uid']) ? "<div><a href='settings.php?uid=".$_GET['uid']."'>Ustawienia</a></div>" : "")
        ."</nav>";

    echo "<main>";

    $id = mysqli_connect("localhost", "root", "", "ksiegarnia");

    for($i = 0; $i < 100; ++$i){
        $book = mysqli_query($id, "select ksiazki.tytul, concat(substr(autor.imie, 1, 1), '. ' autor.nazwisko), ksiazki.cena,  ksiazki.gatunek, ksiazki.jezyk_ksiazki, ksiazki.rok_wydania from ksiazki join autor using (id_autora) limit $i, 1;");
        if($book){
            $data = mysqli_fetch_row($book);
            echo "<div class='ksiazka'>
                    <h2>".$data[0]."</h2>
                    <span>".$data[1]."</span>
                </div>" //TODO
        }
    }
      
    echo "<footer>Created by <a href='github.com/Evgen4X'>Evgen4X</a></footer>";

    ?>
</body>
</html>