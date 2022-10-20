<?php

function pomTarjana($graph, $current_key, &$wynik, &$explore, &$listaKrokow)
{
    $explore[$current_key] = 1;
    $listaKrokow[] = "Oznaczenie wierzchołka o numerze " . $current_key . " jako odwiedzony.";

    foreach ($graph[$current_key] as $node_key => $is_vertex) {
        if ($is_vertex > 0 && $explore[$is_vertex] == 0) {
            pomTarjana($graph, $is_vertex, $wynik, $explore, $listaKrokow);
        }
    }
    $listaKrokow[] = "Koniec przetwarzania i dodanie wierzchołka " . $current_key . " do stosu.";
    $wynik[] = $current_key;
}

function algorytmTarjana()
{
    global $listaSasiedztwa;
    global $liczbaWierzcholkow;
    global $listaKrokow;

    $wynik = array();
    $tab = array();

    for ($i = 1; $i < $liczbaWierzcholkow; $i++) {
        $tab[$i] = 0;
    }
    for ($i = 1; $i < $liczbaWierzcholkow; $i++) {
        if ($tab[$i] == 0)
            pomTarjana($listaSasiedztwa, $i, $wynik, $tab, $listaKrokow);
    }

    echo '<p style="font-weight:bold;">Wynik sortowania Algorytmem Tarjana: ';
    for ($i = (count($wynik) - 1); $i >= 0; $i--) {
        echo $wynik[$i] . ' ';
    }
    $listaKrokow[] = "Cały graf odwiedzony, sortowanie zakończone.";
    $listaKrokow[] = "Wyświetlenie stosu.";
}


function pomCzyAcykliczny($start, &$odwieczone, &$odwiedzone2, $listaSasiedztwa)
{
    $odwieczone[$start] = 1;
    $odwiedzone2[$start] = 1;

    foreach ($listaSasiedztwa[$start] as $node_key => $is_vertex) {
        if ($is_vertex > 0 && $odwieczone[$is_vertex] == 0 && pomCzyAcykliczny($is_vertex, $odwieczone, $odwiedzone2, $listaSasiedztwa)) {
            return true;
        } else if ($is_vertex > 0 && $odwiedzone2[$is_vertex]) {
            return true;
        }
    }
    $odwiedzone2[$start] = 0;
    return false;
}

function sprawczCzyAcykliczny()
{
    global $listaSasiedztwa;
    global $liczbaWierzcholkow;
    $odwiedzone = array();
    $odwiedzone2 = array();

    for ($i = 0; $i < $liczbaWierzcholkow; $i++) {
        $odwiedzone[$i] = 0;
        $odwiedzone2[$i] = 0;
    }

    $odwiedzone[0] = 1;
    $odwiedzone2[0] = 1;

    for ($i = 0; $i < $liczbaWierzcholkow; $i++) {
        if ($odwiedzone[$i] == 0) {
            if (pomCzyAcykliczny($i, $odwiedzone, $odwiedzone2, $listaSasiedztwa)) {
                return true;
            }
        }
    }
    return false;
}

function textDoGraf()
{
    global $listaSasiedztwa;
    $text = trim(preg_replace('/\s+/', ' ', $listaSasiedztwa));
    $textt = explode(" ", $text);


    if (count($textt) < 2) {
        return false;
    }

    if (is_numeric($textt[0]) && is_numeric($textt[1])) {
        $liczbaWierzcholkow = intval($textt[0]);
        $liczbaKrawedzi = intval($textt[1]);
        if ($liczbaKrawedzi < 0 || $liczbaWierzcholkow < 1) {
            return false;
        }
    } else {
        return false;
    }

    if ((count($textt) - 2) != ($liczbaKrawedzi * 2)) {
        return false;
    }
    $tab = array();

    for ($i = 0; $i <= $liczbaWierzcholkow; $i++) {
        $tab[$i] = array();
        $tab[$i][0] = null;
    }

    for ($i = 2; $i < count($textt); $i += 2) {
        if (is_numeric($textt[$i]) && is_numeric($textt[$i + 1])) {
            $pom1 = intval($textt[$i]);
            $pom2 = intval($textt[$i + 1]);
            if (($pom1 == $pom2) || ($pom1 < 1) || ($pom2 < 1) || ($pom1 > $liczbaWierzcholkow) || ($pom2 > $liczbaWierzcholkow)) {
                return false;
            }

            $tab[$pom1][] = $pom2;

        } else {
            return false;
        }
    }
    $listaSasiedztwa = $tab;
    return true;
}

function algorytmKahna()
{
    global $listaSasiedztwa;
    global $listaKrokow;
    global $liczbaWierzcholkow;

    $stopien = array();

    for ($i = 1; $i < $liczbaWierzcholkow; $i++)
        $stopien[$i] = 0;

    $listaKrokow[] = "Wyznaczenie stopni wchodzących dla wszystkich wierzchołków";

    for ($i = 1; $i < $liczbaWierzcholkow; $i++) {
        $pom = $listaSasiedztwa[$i];
        for ($wierzcholek = 1; $wierzcholek < count($pom); $wierzcholek++) {
            $stopien[$pom[$wierzcholek]]++;
        }
    }

    $kolejka = array();

    for ($i = 1; $i < $liczbaWierzcholkow; $i++) {
        if ($stopien[$i] == 0) {
            $listaKrokow[] = "Usunięcie i wypisanie wierzchołka o numerze " . $i;
            $kolejka[] = $i;
        }
    }

    echo '<p style="font-weight:bold;">Wynik sortowania Algorytmem Kahna: ';

    while (count($kolejka) != 0) {
        $u = array_shift($kolejka);
        echo $u . ' ';
        for ($wierzcholek = 1; $wierzcholek < count($listaSasiedztwa[$u]); $wierzcholek++) {
            if ($wierzcholek == 1)
                $listaKrokow[] = "Zmiana stopni wchodzących dla wierzchołków z których zostały usuniete krawędzie wchodzące";
            if (--$stopien[$listaSasiedztwa[$u][$wierzcholek]] == 0) {
                $kolejka[] = $listaSasiedztwa[$u][$wierzcholek];
                $listaKrokow[] = "Usunięcie i wypisanie wierzchołka o numerze " . $listaSasiedztwa[$u][$wierzcholek];
            }
        }
    }

    $listaKrokow[] = "Graf pusty, sortowanie zakończone";
    echo '</p>';
}

function wyczysc()
{
    global $listaKrokow;
    unset($listaKrokow);
}