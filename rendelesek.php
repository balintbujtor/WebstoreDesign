<?php
include 'database.php';
$link = getDb(); 

$create = false;
if (isset($_POST['create'])) {
    $olvasoid = mysqli_real_escape_string($link, $_POST['EkonyvOlvaso_ID']);
    $vasarloid = mysqli_real_escape_string($link, $_POST['Vasarlo_ID']);
    $darabszam = mysqli_real_escape_string($link, $_POST['Darabszam']);
    $query1 = sprintf("INSERT INTO Rendeles (Datum, Darabszam, Vasarlo_ID, EkonyvOlvaso_ID) 
    VALUES (curdate(), '%s', '%s', '%s')", $darabszam, $vasarloid, $olvasoid);
    $ret1 = mysqli_query($link, $query1) or die(mysqli_error($link));

    //meg kell nézni, hogy mi van ha így kisebb lesz mint nulla? - nem, hogy a vasarlo tudjon rendelni akkor is,
    //ha nincs elég készleten, de a tulaj lássa, hogy hiány van abbol a termekbol

    $query2 = sprintf("UPDATE EkonyvOlvaso SET Keszlet = Keszlet - '%s' WHERE ID='%s'", $darabszam, $olvasoid);
    $ret2 = mysqli_query($link, $query2) or die(mysqli_error($link));
    $create = true;
}
?>


<html>
    <head>

    <?php include 'head.html'; ?>
    </head>
    <body>
        <?php include 'menu.html'; ?>
        <div class="container main-content">

            <h1 class="display-3 my-3"> <span><i class="fas fa-shopping-cart"></i></span> Rendelések</h1>

            <?php if ($create): ?>
                <p>
                    <span class="badge badge-success">Új rendelés létrehozva mai dátummal</span>
                </p>
            <?php endif; ?>

            <?php
                $query = "SELECT Rendeles.ID, Vasarlo_ID, Datum, Darabszam, EkonyvOlvaso_ID, 
                Vasarlo.Nev as Nev, EkonyvOlvaso.Gyarto as Gyarto, EkonyvOlvaso.Modell as Modell, EkonyvOlvaso.Ar as Olvasoar 
                FROM EkonyvOlvaso INNER JOIN Rendeles ON Ekonyvolvaso.ID = EkonyvOlvaso_ID 
                INNER JOIN Vasarlo ON Vasarlo_ID=Vasarlo.ID";
                $eredmeny = mysqli_query($link, $query) or die(mysqli_error($link));
            ?>

            <table class="table table-striped table-dark table-sm table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col">Vásárló</th>
                        <th scope="col">Gyártó</th>      
                        <th scope="col">Modell</th>      
                        <th scope="col">Ár</th>
                        <th scope="col">Darabszám</th>
                        <th scope="col">Dátum</th>
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><?=$row['Nev']?></td>
                        <td><?=$row['Gyarto']?></td>
                        <td><?=$row['Modell']?></td>
                        <td><?=$row['Olvasoar']?></td>
                        <td><?=$row['Darabszam']?></td>
                        <td><?=$row['Datum']?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="edit-rendeles.php?rendelesid=<?=$row['ID']?>&darabszam=<?=$row['Darabszam']?>&ekonyvid=<?=$row['EkonyvOlvaso_ID']?>">
                                <i class="fa fa-edit"></i> Szerkesztés
                            </a>
                        </td>
                    </tr>                
                <?php endwhile; ?>  
                </tbody>
            </table>

            <h5 class="my-3">Új rendelés létrehozása</h5>

            <form method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for='Vasarlo_ID'>Vásárló</label>
                            <select class="form-control" name='Vasarlo_ID' id='Vasarlo_ID'>
                            <?php
                                $queryMembers = 'SELECT ID, Nev FROM Vasarlo';
                                $resultQueryMembers = mysqli_query($link, $queryMembers) or die(mysqli_error($link));
                                while ($rowMember = mysqli_fetch_array($resultQueryMembers)):
                            ?>
                                <option value="<?=$rowMember['ID']?>"><?=$rowMember['Nev']?></option>
                            <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for='EkonyvOlvaso_ID'>E-könyv olvasó</label>
                            <select required class="form-control" name='EkonyvOlvaso_ID' id='EkonyvOlvaso_ID'>
                                <?php
                                    $queryBooks = 'SELECT ID, Gyarto, Modell FROM EkonyvOlvaso';
                                    $resultQueryBooks = mysqli_query($link, $queryBooks) or die(mysqli_error($link));
                                    while ($rowBook = mysqli_fetch_array($resultQueryBooks)):
                                ?>
                                    <option value="<?=$rowBook['ID']?>"><?=$rowBook['Gyarto']?> (<?=$rowBook['Modell']?>)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Darabszam">Darabszám</label>
                            <input required class="form-control" name="Darabszam" id="Darabszam" type="number" />
                        </div>
                        <div class="form-group">
                            <input class="btn btn-danger" name="create" type="submit" value="Létrehozás" />
                        </div>
                    </div>

                </div>  
            </form>


            <?php
                closeDb($link);
            ?>
        </div>

        <?php
            include 'footer.html';
        ?>

    </body>
</html>

    