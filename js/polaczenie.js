var sposobWprowadzenia = 1;
var algorytm = 1;
var listaKrawedzi;

function wprowadzenieGrafu(zmienna) {
    if (zmienna === 1) {
        sposobWprowadzenia = zmienna;
    } else if (zmienna === 2) {
        sposobWprowadzenia = zmienna;
    }
}

function rodzajAlgorytmu() {
    var x = document.getElementById("kahna").checked;
    if (x === true) {
        algorytm = 1;
    } else {
        algorytm = 2;
    }
}

function konwertujGrafzKreatora() {
    var grafInfo = graf.save();
    listaKrawedzi = Array(grafInfo["nodes"].length);
    console.log(grafInfo["nodes"].length);
    for (var i = 0; i <= grafInfo["nodes"].length; i++) {
        listaKrawedzi[i] = Array(1);
    }
    for (var j = 0; j < grafInfo["edges"].length; j++) {
        listaKrawedzi[grafInfo["edges"][j].source].push(grafInfo["edges"][j].target);
    }

    console.log(listaKrawedzi);

}

function przekazDane() {
    document.getElementById('kroki').innerHTML = "";
    if (sposobWprowadzenia === 1) {
        konwertujGrafzKreatora();
    } else if (sposobWprowadzenia === 2) {
        listaKrawedzi = document.getElementById("text").value;
    }

    var dane = {};
    dane.sposob = sposobWprowadzenia;
    dane.algorytm = algorytm;
    dane.lista = listaKrawedzi;

    $.ajax({
        url: "/sortowanie/php/walidacja.php",
        method: "post",
        data: {dane: JSON.stringify(dane)},
    })

        .done(function (data) {
            $('#test').html(data);
            emps = JSON.parse(document.getElementById('emp').innerHTML);
            if (emps.length > 1) {
                var wyswietl = '<ol>';
                for (var i = 1; i < emps.length; i++) {
                    wyswietl += '<li>' + emps[i] + '</li>';
                }
                wyswietl += '</ol>';
                document.getElementById('kroki').innerHTML = wyswietl;

            }
        });


}














