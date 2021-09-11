<?php
include 'database.php';
$link = getDb(); 

$created = false;
if (isset($_POST['create'])) 
{
    $gyarto = mysqli_real_escape_string($link, $_POST['Gyarto']);
    $modell = mysqli_real_escape_string($link, $_POST['Modell']);
    $ar = mysqli_real_escape_string($link, $_POST['Ar']);
    $keszlet = mysqli_real_escape_string($link, $_POST['Keszlet']);

    $createQuery = sprintf("INSERT INTO EkonyvOlvaso(Gyarto, Modell, Ar, Keszlet) VALUES ('%s', '%s', '%s', '%s')",
        $gyarto,
        $modell,
        $ar,
        $keszlet
    );
    mysqli_query($link, $createQuery) or die(mysqli_error($link));
    $created = true;
}
?>

<html>
<head>
<?php include 'head.html'; ?>
</head>

<body>
    <?php include 'menu.html'; ?>
    <div class="container main-content">

        <h1 class="display-3 my-3"> <span><i class="fas fa-book-open"></i></span> E-könyv olvasók</h1>
        
        <?php if ($created): ?>
            <p>
                <span class="badge badge-success">Új e-könyv olvasó hozzáadva</span>
            </p>
        <?php endif; ?>

        <?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>

        <form class="form-inline" method="post">
                <div class="form-group form-row my-2">
                    <label for="colFormLabel" class="col-auto col-form-label">Keresés:</label>
                    <div class="col-auto">
                        <input class="form-control" type="search" placeholder="Amazon Kindle" name="search" value="<?=$search?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" >  <span><i class="fas fa-search"></i></span> Keresés</button>
                    </div>
                </div>
        </form>


        <?php
            $querySelect = "SELECT ID, Gyarto, Modell, Ar, Keszlet FROM EkonyvOlvaso";
            if ($search) 
            {
                $querySelect = $querySelect . sprintf(" WHERE LOWER(Gyarto) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
            }
            $concat = " ORDER BY Gyarto, Modell";
            $querySelect = $querySelect . $concat;
            $result = mysqli_query($link, $querySelect) or die(mysqli_error($link));
        ?>

            <table class="table table-sm table-dark table-striped table-borderless table-hover">
                <thead>
                    <tr>
                        <th scope="col">Gyártó</th>
                        <th scope="col">Modell</th>      
                        <th scope="col">Ár</th>      
                        <th scope="col">Készlet</th>
                        <th></th>
                    </tr> 
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td><?=$row['Gyarto']?></td>
                        <td><?=$row['Modell']?></td>
                        <td><?=$row['Ar']?></td>
                        <td><?=$row['Keszlet']?></td>
                        <td>
                            <a class="btn btn-warning btn-sm" href="edit-ekonyv.php?ekonyvid=<?=$row['ID']?>">
                                <i class="fa fa-edit"></i> Szerkesztés
                            </a>
                        </td>
                    </tr>                
                <?php endwhile; ?> 
                </tbody>
            </table>

            <h5 class="my-3">Új e-könyv olvasó hozzáadása</h5>

            <form method="post" action="">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="Gyarto">Gyártó</label>
                            <input required class="form-control" placeholder="Amazon Kindle" name="Gyarto" id="Gyarto" type="text"  />
                        </div>
                        <div class="form-group">
                            <label for="Modell">Modell</label>
                            <input required class="form-control" name="Modell" placeholder="Oasis" id="Modell" type="text" />
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="Ar">Ár</label>
                                <input required class="form-control" name="Ar" placeholder="99990" id="Ar" type="number"  />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Keszlet">Készlet</label>
                                <input class="form-control" name="Keszlet" placeholder="99" id="Keszlet" type="number" />
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-danger" name="create" type="submit" value="Hozzáadás" />
                        </div>
                    </div>
                </div>
            </form>


    </div>

    <?php
        include 'footer.html';
    ?>

    <?php
    closeDb($link);
    ?>

</body>
</html>