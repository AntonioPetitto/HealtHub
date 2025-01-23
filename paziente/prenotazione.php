<?php 
// Include l'intestazione comune
include('includes/header.php'); 
// Include il file di configurazione
include('gestione/config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="../assets/stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <title>Prenotazione</title>
</head>
<body>
    <style>

    .dataTables_wrapper .dataTables_filter {
        margin-right: 10px;
        text-align: end;
    }


    .table-responsive {
        overflow-x: auto; /* Abilita lo scorrimento orizzontale */
    }

    #Tabella th:first-child,
        #Tabella td:first-child {
            vertical-align: middle;
        }

    </style>
    <!-- Struttura della pagina -->
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive">
                <div class="card-header">
                    <h4>Prenota la tua visita</h4>
                    <div class="row mt-5 justify-content-end">
                        <div class="col-md-2">
                            <!-- select per selezionare un ambulatorio -->
                            <label for="ambulatorio">Seleziona Ambulatorio:</label>
                            <select class="form-control" id="ambulatorio" onchange="updateWeek()">
                                <option value="">Seleziona Ambulatorio</option>
                                <option value="1">Cardiologia</option>
                                <option value="2">Chirurgia</option>
                                <option value="3">Endocrinologia</option>
                                <option value="4">Neurologia</option>
                                <option value="5">Ortopedia</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="margin-right: 32px;">
                            <!-- campo di tipo settimana per inserire la data -->
                            <label for="data">Seleziona Data:</label>
                            <input class="form-control" type="week" id="data" name="data" onchange="updateWeek()">
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="Tabella" class="table table-bordered table-striped text-center table-responsive">
                            <thead>
                                <th width="15%">Dottore</th>
                                <th width="8%">lunedì</th>
                                <th width="8%">martedì</th>
                                <th width="8%">mercoledì</th>
                                <th width="8%">giovedì</th>
                                <th width="8%">venerdì</th>
                                <th width="8%">sabato</th>
                                <th width="8%">domenica</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Inclusione delle librerie JavaScript -->
<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../assets/js/dt-1.10.25datatables.min.js"></script>    

<!-- Inizializzazione della tabella DataTable -->
<script type="text/javascript">

// Configurazioni della tabella DataTable
$(document).ready(function() {
    $('#Tabella').DataTable({
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
            $(nRow).attr('id', aData[0]);
        },
        'serverSide': true,
        'processing': true,
        'paging': true,
        'order': [],
        'ajax': {
            'url': 'gestione/fetch_data_prenotazione.php',
            'type': 'post',
            'data': function(data) {
                data.ambulatorio = $('#ambulatorio').val();
                data.data = $('#data').val();
            },
        },
        "language": {
            "url": '../assets/js/Datatable_italiano.json',
        }
    });
});


// Funzione per aggiornare la tabella della settimana
function updateWeek() {
    // Ricarica i dati della tabella senza modificare la pagina attuale
    $('#Tabella').DataTable().ajax.reload(null, false); 
}

// Evento eseguito quando il documento HTML è completamente caricato
document.addEventListener('DOMContentLoaded', function() {
    // Ottieni la data odierna
    var today = new Date();
    // Ottieni l'anno corrente
    var year = today.getFullYear();
    // Ottieni il numero della settimana corrente
    var week = getWeek(today);
    // Imposta il valore del campo data con l'anno e il numero della settimana corrente
    document.getElementById('data').value = year + '-W' + week;
});

// Funzione per ottenere il numero della settimana data una data
function getWeek(date) {
    // Ottieni la data del primo giorno dell'anno corrente
    var onejan = new Date(date.getFullYear(), 0, 1);
    // Numero di millisecondi in un giorno
    var millisecsInDay = 86400000;
    // Calcola il numero della settimana usando la formula ISO-8601
    return Math.ceil((((date - onejan) / millisecsInDay) + onejan.getDay() + 1) / 7);
}

// Gestione del click sul pulsante dell'orario di una visita libera per prenotare tramite AJAX
$(document).on('click', '.btn-prenota', function(event) {
    var orario = $(this).data('id');
    var data = $(this).data('data');
    var id_dipendente = $(this).data('dipendente');
    var ambulatorio = $('#ambulatorio').val();
    $.ajax({
        
        url: 'gestione/prenota_visita.php',
        type: 'POST',
        data: { 
            orario: orario,
            data: data,
            id_dipendente: id_dipendente,
            ambulatorio: ambulatorio,
        },
        success: function(response) {
            var json = JSON.parse(response);
            var status = json.status;
            var message = json.message;
            if(status=="true"){
                alert(message);
                tabella = $('#Tabella').DataTable();
                tabella.draw();
            }else{
                alert(message);
            }
        },
        // Gestisce eventuali errori di connessione o dal server
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});


</script>
</body>
</html>