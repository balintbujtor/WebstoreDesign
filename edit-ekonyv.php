<?php 
include 'database.php';
$link = getDb();

//modositas
$successful_update = false;
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['ID']);
    $gyarto = mysqli_real_escape_string($link, $_POST['Gyarto']);
    $modell = mysqli_real_escape_string($link, $_POST['Modell']);
    $ar = mysqli_real_escape_string($link, $_POST['Ar']);
    $keszlet = mysqli_real_escape_string($link, $_POST['Keszlet']);
    if (!$gyarto) {
        die('A gyártó nem lehet üres');
    } 
    else {
        $query = sprintf("UPDATE EkonyvOlvaso SET Gyarto='%s', Modell='%s', Ar='%s', Keszlet='%s' WHERE ID = %s",
                $gyarto, $modell, $ar, $keszlet, $id);
        mysqli_query($link, $query) or die(mysqli_error($link));
        $successful_update = true;
    }

} 
else if (isset($_POST['delete'])) {
    $query1 = sprintf('DELETE FROM Rendeles WHERE EkonyvOlvaso_ID = %s', 
        mysqli_real_escape_string($link, $_POST['ID']));
    $query2 = sprintf('DELETE FROM EkonyvOlvaso WHERE ID = %s', 
        mysqli_real_escape_string($link, $_POST['ID']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));
    header("Location: ekonyv.php");
    return;
}
?>

<html>
    <head>
    <?php include 'head.html'; ?>
    </head>
    <body>
        <?php include 'menu.html'; ?>
        <div class="container main-content">

            <?php
                //a megfelelő ekönyv kivalasztasa
                if (!isset($_GET['ekonyvid'])) {
                    header("Location: ekonyv.php");
                    return;
                } 
                $ekonyvid = $_GET['ekonyvid'];
                $query = sprintf("SELECT ID, Gyarto, Modell, Ar, Keszlet FROM EkonyvOlvaso where ID = %s", 
                    mysqli_real_escape_string($link, $ekonyvid)) or die(mysqli_error($link));
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                if (!$row) {
                    header("Location: ekonyv.php");
                    return;
                }
            ?>

            <h1 class="my-3">E-könyv olvasó adatainak módosítása</h1>


            <?php if ($successful_update): ?>
                <p>
                    <span class="badge badge-success">E-könyv olvasó adatai sikeresen módosítva</span>
                </p>
            <?php endif; ?>


            <form method="post" action="">
                <input type="hidden" name="ID" id="ID" value="<?=$ekonyvid?>" />
                <div class="form-group">
                    <label for="Gyarto">Gyártó</label>
                    <input required class="form-control" name="Gyarto" id="Gyarto" placeholder="Amazon Kindle" type="text" value="<?=$row['Gyarto']?>" />
                </div>
                <div class="form-group">
                    <label for="Modell">Modell</label>
                    <input required class="form-control" name="Modell" placeholder="Oasis" id="Modell" type="text" value="<?=$row['Modell']?>" />
                </div>
                <div class="form-group">
                    <label for="Ar">Ár</label>
                    <input required class="form-control" name="Ar" id="Ar" placeholder="99990" type="number" value="<?=$row['Ar']?>" />
                </div>
                <div class="form-group">
                    <label for="Keszlet">Készlet</label>
                    <input class="form-control" name="Keszlet" placeholder="9" id="Keszlet" type="number" value="<?=$row['Keszlet']?>" />
                </div>
                <input class="btn btn-success" name="update" type="submit" value="Mentés" />
                <input class="btn btn-danger" name="delete" type="submit" value="Törlés" />
            </form>

            
        </div>
        
        <?php
            closeDb($link);
        ?>

    </body>
</html>