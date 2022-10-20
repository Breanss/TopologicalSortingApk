<?php
require_once "algorytmy.php";
if (isset($_POST['dane'])) {
    $dane = json_decode($_POST['dane']);
    $listaKrokow = array();
    $listaKrokow[] = "";
    $listaSasiedztwa = $dane->lista;
    $ktorySposob = $dane->sposob;
    $alg = $dane->algorytm;



    if ($ktorySposob == 1) {
        $liczbaWierzcholkow = count($listaSasiedztwa);
        if ($liczbaWierzcholkow > 1) {
            if (!sprawczCzyAcykliczny()) {
                if ($alg == 1)
                    algorytmKahna();
                else
                    algorytmTarjana();
                if (count($listaKrokow) > 1) {
                    global $listaKrokow;
                    $json = json_encode($listaKrokow);
                    echo "<div id='emp' style='display:none'>" . $json . "</div>";
                }
            } else {
                echo '<p style="color:red; font-weight:bold;">Graf nie jest grafem acyklicznym !</p>';
            }
        } else {
            echo '<p style="color:red; font-weight:bold;">Graf nie został wprowadzony !</p>';
        }
    } else if ($ktorySposob == 2) {
        if (strlen($listaSasiedztwa)) {
            if (textDoGraf()) {
                $liczbaWierzcholkow = count($listaSasiedztwa);
                if (!sprawczCzyAcykliczny()) {
                    if ($alg == 1)
                        algorytmKahna();
                    else
                        algorytmTarjana();
                    if (count($listaKrokow)) {
                        global $listaKrokow;
                        $json = json_encode($listaKrokow);
                        echo "<div id='emp' style='display:none'>" . $json . "</div>";
                    }
                } else {
                    echo '<p style="color:red; font-weight:bold;">Graf nie jest grafem acyklicznym !</p>';
                }
            } else {
                echo '<p style="color:red; font-weight:bold;">Graf nie został poprawnie wprowadzony !</p>';
            }
        } else {
            echo '<p style="color:red; font-weight:bold;">Graf nie został wprowadzony !</p>';
        }
    } else {
        echo "Coś poszło nie tak!";
    }

}
