<?php 
include 'database.php';
$link = getDb(); 
//modositas
$successful_update = false;
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($link, $_POST['ID']);
    $nev = mysqli_real_escape_string($link, $_POST['Nev']);
    $cim = mysqli_real_escape_string($link, $_POST['Cim']);
    $telefon = mysqli_real_escape_string($link, $_POST['Telefon']);
    $email = mysqli_real_escape_string($link, $_POST['Email']);
    if (!$nev) {
        die('A név nem lehet üres');
    } else {
        $query = sprintf("UPDATE Vasarlo SET Nev='%s', Cim='%s', Telefon='%s', Email='%s' WHERE ID = %s",
                $nev, $cim, $telefon, $email, $id);

        mysqli_query($link, $query) or die(mysqli_error($link));
        $successful_update = true;
    }

} else if (isset($_POST['delete'])) {
    $query1 = sprintf('DELETE FROM Rendeles WHERE Vasarlo_ID = %s', 
        mysqli_real_escape_string($link, $_POST['ID']));
    $query2 = sprintf('DELETE FROM Vasarlo WHERE ID = %s', 
        mysqli_real_escape_string($link, $_POST['ID']));
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));
    header("Location: vasarlok.php");
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
            if (!isset($_GET['vasarloid'])) {
                header("Location: vasarlok.php");
                return;
            } 
            $vasarloid = $_GET['vasarloid'];
            $query = sprintf("SELECT ID, Nev, Cim, Telefon, Email FROM Vasarlo where ID = %s", 
                mysqli_real_escape_string($link, $vasarloid)) or die(mysqli_error($link));
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_array($result);
            if (!$row) {
                header("Location: vasarlok.php");
                return;
            }
        ?>

        <h1 class="my-3">Vásárló adatainak módosítása</h1>


        <?php if ($successful_update): ?>
            <p>
                <span class="badge badge-success">Vásárló adatai sikeresen módosítva</span>
            </p>
        <?php endif; ?>


        <form method="post" action="">
            <input type="hidden" name="ID" id="ID" value="<?=$vasarloid?>" />
            <div class="form-group">
                <label for="Nev">Név</label>
                <input required class="form-control" name="Nev" placeholder="Kis István" id="Nev" type="text" value="<?=$row['Nev']?>" />
            </div>
            <div class="form-group">
                <label for="Cim">Cím</label>
                <input required class="form-control" name="Cim" id="Cim" placeholder="Budapest" type="text" value="<?=$row['Cim']?>" />
            </div>
            <div class="form-group">
                <label for="Telefon">Telefon</label>
                <input class="form-control" name="Telefon" id="Telefon" placeholder="06201234567" type="number" value="<?=$row['Telefon']?>" />
            </div>
             <div class="form-group">
                <label for="Email">Email</label>
                <input required class="form-control" name="Email" placeholder="kisistvan@minta.com" id="Email" type="text" value="<?=$row['Email']?>" />
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