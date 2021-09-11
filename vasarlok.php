<?php
include 'database.php';
$link = getDb(); 

$created = false;
if (isset($_POST['create'])) 
{
    $nev = mysqli_real_escape_string($link, $_POST['Nev']);
    $cim = mysqli_real_escape_string($link, $_POST['Cim']);
    $telefon = mysqli_real_escape_string($link, $_POST['Telefon']);
    $email = mysqli_real_escape_string($link, $_POST['Email']);

    $createQuery = sprintf("INSERT INTO Vasarlo(Nev, Cim, Telefon, Email) VALUES ('%s', '%s', '%s', '%s')",
        $nev,
        $cim,
        $telefon,
        $email
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

        <h1 class="display-3 my-3"> <span><i class="fas fa-user"></i></span> Vásárlók</h1>
        
        <?php if ($created): ?>
            <p>
                <span class="badge badge-success">Új vásárló hozzáadva</span>
            </p>
        <?php endif; ?>

        <?php
            $search = null;
             if (isset($_POST['search'])) {
                 $search = $_POST['search'];
            }
        ?>

        <form class="form-inline" method="post">
                <div class="form-group my-2 form-row">
                    <label for="colFormLabel" class="col-auto col-form-label">Keresés:</label>
                    <div class="col-auto">
                        <input class="form-control" placeholder="Kis István" type="search" name="search" value="<?=$search?>">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger" type="submit" >  <span><i class="fas fa-search"></i></span> Keresés</button>
                    </div>
                </div>
        </form>


        <?php
            $querySelect = "SELECT ID, Nev, Cim, Telefon, Email FROM Vasarlo";
            if ($search) 
            {
                $querySelect = $querySelect . sprintf(" WHERE LOWER(Nev) LIKE '%%%s%%'", mysqli_real_escape_string($link, strtolower($search)));
            }
            $concat = " ORDER BY Nev";
            $querySelect = $querySelect . $concat;
            $result = mysqli_query($link, $querySelect) or die(mysqli_error($link));
        ?>


        <table class="table table-sm table-dark table-striped table-borderless table-hover">
            <thead>
                <tr>
                    <th scope="col">Név</th>
                    <th scope="col">Cím</th>      
                    <th scope="col">Telefon</th>      
                    <th scope="col">Email</th>
                    <th></th>
                </tr> 
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_array($result)): ?>
                <tr>
                    <td><?=$row['Nev']?></td>
                    <td><?=$row['Cim']?></td>
                    <td><?=$row['Telefon']?></td>
                    <td><?=$row['Email']?></td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="edit-vasarlo.php?vasarloid=<?=$row['ID']?>">
                            <i class="fa fa-edit"></i> Szerkesztés
                        </a>
                    </td>
                </tr>                
            <?php endwhile; ?> 
            </tbody>
        </table>

        <h5 class="my-3">Új vásárló hozzáadása</h5>

        <form method="post" action="">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="Nev">Név</label>
                        <input required class="form-control" name="Nev" placeholder="Kis István" id="Nev" type="text"  />
                    </div>
                    <div class="form-group">
                        <label for="Cim">Cim</label>
                        <input required class="form-control" name="Cim" placeholder="Budapest" id="Cim" type="text" />
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="Telefon">Telefon</label>
                            <input class="form-control" name="Telefon" placeholder="201234567" id="Telefon" type="number"  />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="Email">Email</label>
                            <input required class="form-control" name="Email" placeholder="kisistvan@minta.com" id="Email" type="text" />
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-danger" name="create" type="submit" value="Hozzáadás" />
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
</html