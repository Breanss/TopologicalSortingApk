<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <script src="https://gw.alipayobjects.com/os/antv/pkg/_antv.g6-3.7.1/dist/g6.min.js"></script>
    <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>
    <script src="js/kreator.js"></script>
    <script src="js/polaczenie.js"></script>

    <title>Sortowanie topologiczne</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><b class="logo-nav">Sortowanie topologiczne</b></a>
        <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler"data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">

            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-nav ">
                <li class="nav-item ">
                    <a aria-current="page" class="nav-link" href="index.php">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a aria-current="page" class="nav-link" href="podstrony/instrukcja.php">Instrukcja</a>
                </li>
            </ul>


        </div>
    </div>
</nav>
<div class="container mt-4 mb-2 tlo">
    <h2>Strona główna</h2>
    <hr/>
    <div class="row">
        <div class="col-sm-12 col-xl-9 mt-3">

            <nav class="mt-4 navbar-dark c-text">
                <div class="nav nav-tabs cos" id="nav-tab" role="tablist">
                    <button aria-controls="nav-home" aria-selected="true" class="nav-link active" data-bs-target="#nav-home"
                            data-bs-toggle="tab" id="kreator" onclick="wprowadzenieGrafu(1);" role="tab" type="button">Kreator grafu
                    </button>
                    <button aria-controls="nav-profile" aria-selected="false" class="nav-link" data-bs-target="#nav-profile"
                            data-bs-toggle="tab"  onclick="wprowadzenieGrafu(2);" role="tab" type="button">Graf jako lista krawędzi
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div aria-labelledby="nav-home-tab" class="tab-pane fade show active" id="nav-home" role="tabpanel">

                    <div id="textarea">
                        <div id="obszarKreatora">
                        </div>
                    </div>
                    <div class="narzedzia">
                        <input class="neon-przycisk" type="button" id="NewNode" onclick="onoff();"
                               value="Dodaj wierzchołek"/>
                        <input class="neon-przycisk" type="button" id="dodajKrawedz" value="Dodaj krawędź"/>
                        <input class="neon-przycisk" type="button" id="przesun" value="Przesuń wierzchołek"/>
                        <input class="neon-przycisk" type="button" id="usunElement" value="Usuń element"/>
                        <input class="neon-przycisk" type="button" id="usunGraf" onclick="usunGraf();"
                               value="Wyczyść graf"/>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div id="textarea2">
                        <div class="mb-2">
                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                            <textarea class="form-control" id="text" rows="40"></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-12 col-xl-3 mt-3">
            <div class="srodek">
                <h5 class="mt-3">Lista kroków</h5>
                <hr/>
                <div id="kroki" class="kroki">

                </div>
            </div>
        </div>
    </div>
    <hr/>
    <form>
        <div class="narzedzia mt-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="kahna" checked>
                <label class="form-check-label" for="kahna" >
                    Algorytm Kahna
                </label>
            </div>
            <div class="form-check form-check-inline ms-4">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="tarjana">
                <label class="form-check-label" for="tarjana" >
                    Algorytm Tarjana
                </label>
            </div>
            <br/>


            <input class="uruchom-przycisk mt-4" type="button" id="start" onclick="rodzajAlgorytmu(); przekazDane();  "
                   value="Uruchom algorytm"/>



        </div>
    </form>

    <div class="wynik mt-3">
        <div id="test"></div>
    </div>


</div>

<script src="bootstrap/js/bootstrap.js"></script>

</body>
</html>
