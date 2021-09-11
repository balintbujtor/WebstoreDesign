<?php 
include 'database.php';
$link = getDb();

//modositas
$successful_update = false;

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['ID']);
    $datum = mysqli_real_escape_string($link, $_POST['Datum']);
    $ekonyvid = mysqli_real_escape_string($link, $_POST['EkonyvID']);
    $ujdb = mysqli_real_escape_string($link, $_POST['Darabszam']);

    $query = sprintf("UPDATE Rendeles SET Datum='%s', Darabszam='%s' WHERE ID=%s", $datum, $ujdb, $id);
    mysqli_query($link, $query) or die(mysqli_error($link));
    $query2 = sprintf("UPDATE EkonyvOlvaso SET Keszlet = (Keszlet - '%s') WHERE ID=%s", $ujdb, $ekonyvid); //656313135163
    mysqli_query($link, $query2) or die(mysqli_error($link));
    $successful_update = true;
    header("Location: rendelesek.php");
    return;
} 
else if(isset($_GET['darabszam'])) //FIGYELEM! - emiatt a megoldas miatt hiba lép fel abban az esetben, ha mentés/törlés nélkül nyomunk vissza gombot a böngészőben
{
    $regidb = mysqli_real_escape_string($link, $_GET['darabszam']);
    $ekonyvid = mysqli_real_escape_string($link, $_GET['ekonyvid']);
    $query3 = sprintf("UPDATE EkonyvOlvaso SET Keszlet = Keszlet + '%s' WHERE ID='%s'", $regidb, $ekonyvid);
    mysqli_query($link, $query3) or die(mysqli_error($link));
}
else if (isset($_POST['delete'])) {

    $query1 = sprintf('DELETE FROM Rendeles WHERE ID = %s', 
        mysqli_real_escape_string($link, $_POST['ID']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    header("Location: rendelesek.php");
    return;
}
?>

<html>
    <head>
    <?php include 'head.html'; ?>
    </head>
    <body>

        <?php include 'menu.html';?>

        <div class="container main-content">

        
            <?php
                if (!isset($_GET['rendelesid'])) {
                    die('Nincs megadva rendelés azonosító');
                    return;
                } 
                $rendelesid = $_GET['rendelesid'];
                $query = sprintf("SELECT Rendeles.ID, Vasarlo_ID, Datum, Darabszam, EkonyvOlvaso_ID, 
                Vasarlo.Nev as Nev, EkonyvOlvaso.Gyarto as Gyarto, EkonyvOlvaso.Modell as Modell 
                FROM EkonyvOlvaso INNER JOIN Rendeles ON Ekonyvolvaso.ID = EkonyvOlvaso_ID 
                INNER JOIN Vasarlo ON Vasarlo_ID=Vasarlo.ID WHERE Rendeles.ID = %s",
                mysqli_real_escape_string($link, $rendelesid));
                $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
                $row = mysqli_fetch_array($eredmeny);
                if (!$row) {
                    die('Nincs ilyen azonosítójú rendelés');
                    return;
                }
            ?>


            <h1 class="my-3">Rendelés adatai</h1>


            <?php if ($successful_update): ?>
            <p>
                <span class="badge badge-success">Rendelés módosítva</span>
            </p>
            <?php endif; ?>


            <form method="post" action="edit-rendeles.php?rendelesid=<?=$rendelesid?>"> <!-- &darabszam=//$_POST['Darabszam'] lehet nem is kell-->
                <input type="hidden" name="ID" id="ID" value="<?=$rendelesid?>" />
                <input type="hidden" name="EkonyvID" id="EkonyvID" value="<?=$row['EkonyvOlvaso_ID']?>" />
                <div class="form-group">
                    <label for='Nev'>Vásárló</label>
                    <input id="Nev" class="form-control" readonly type="text" value="<?=$row['Nev']?>" />
                </div>

                <div class="form-group">
                    <label for='Gyarto'>Gyártó</label>
                    <input class="form-control" readonly type="text" id="Gyarto" value="<?=$row['Gyarto']?>" />
                </div>

                <div class="form-group">
                    <label for='Modell'>Modell</label>
                    <input class="form-control" readonly type="text" id="Modell" value="<?=$row['Modell']?>" />
                </div>

                <div class="form-group">
                    <label for='Darabszam'>Darabszám</label>
                    <input class="form-control" type="number" name="Darabszam" id="Darabszam" value="<?=$row['Darabszam']?>" />
                </div>
                <div class="form-group">
                    <label for='Datum'>Dátum</label>
                    <input class="form-control" type="date" id="Datum" name='Datum' value="<?=$row['Datum']?>" />
                </div>
                <input class="btn btn-success" name="update" type="submit" value="Mentés" />
                <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
            </form>

            <?php
                closeDb($link);
            ?>

        </div>

    </body>
</html>