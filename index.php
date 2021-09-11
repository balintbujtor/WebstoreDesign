<html>
    <head>
        <?php include 'head.html'; ?>
    </head>

    <body>
        <?php include 'menu.html'; ?>

        <div class="container main-content my-3">
        
            <h1 class="display-3">E-könyv olvasó adatbázis</h1>
            <p class="lead">Házi feladat</p>
        
        </div>

        <div class="container-fluid p-0 m-0">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox" style="width:100%; height: 500px !important;">
                    <div class="carousel-item active">
                    <img src="reader1.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                    <img src="reader2.jpg" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                    <img src="reader3.jpg" class="d-block w-100" alt="...">
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <h3 class="pt-3"> <span><i class="fas fa-comment-alt"></i></span> A feladat informális leírása</h3>
            <p>A házi feladatom célja egy képzeletbeli e-könyv kereskedés adatbázisának a megvalósítása. A
                kereskedésnek vannak e-könyv olvasói (ID, gyártó, modell, ár, készlet), amikkel kereskedik. Ezeket az
                olvasókat a vevők (ID, név, cím, email, telefon) tudják megvásárolni (ID, dátum, darabszám).
            </p>
        </div>
        
        <div class="container">
            <h3> <span><i class="fas fa-tools"></i></span> Funkciók</h3>
            <p>Az alkalmazásommal az alábbi funkciókat lehet végrehajtani:</p>
        </div>

        <div class="container">

            <div class="row">
                <div class="col-sm">
                    <h5>E-könyv olvasók</h5>
                    <ul class="">
                        <li>új e-könyv olvasó felvétele</li>
                        <li>e-könyv olvasó adatainak a módosítása</li>
                        <li>meglévő e-könyv olvasó törlése</li>
                        <li>raktárkészlet lekérdezése: mennyi van raktáron</li>
                    </ul>
                </div>
                <div class="col-sm">
                    <h5>Rendelések</h5>
                    <ul class="">
                        <li>új rendelés felvétele</li>
                        <li>rendelések módosítása</li>
                        <li>rendelések törlése</li>
                        <li>legutolsó rendelések</li>
                    </ul>
                </div>
                <div class="col-sm">
                    <h5>Vásárlók</h5>
                    <ul class="">
                        <li>új vásárló felvétele</li>
                        <li>meglévő vásárló adatainak a módosítása</li>
                        <li>meglévő vásárló törlése</li>
                        <li>melyik városból van a legtöbb vásárló</li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="container my-2">
            <h3> <span><i class="fas fa-image"></i></span> Adatbázis séma</h3>
            <div class="text-center">
                <img src="ekonyvERDiagram.png" class="img-fluid mx-auto d-blocks" alt="adatbázis séma">
            </div>
        </div>

        <?php include 'footer.html' ; ?>
    </body>
</html>