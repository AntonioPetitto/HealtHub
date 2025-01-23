<?php include('includes/header.php'); ?>
<?php include('gestione/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="../assets/stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <title>Document</title>
</head>
<body>
    <style>

    .col-md-2 {
        margin-right: 32px;
    }

    .dataTables_wrapper .dataTables_filter {
        margin-right: 10px;
        text-align: end;
    }

    .dataTables_wrapper .sorting:before, 
    .dataTables_wrapper .sorting_asc:before, 
    .dataTables_wrapper .sorting_desc:before {
        content: "\2195"; 
        visibility: visible;
    }

    .table-responsive {
        overflow-x: auto; /* Abilita lo scorrimento orizzontale */
    }

    </style>
    <!-- Struttura della pagina -->
    <div class="row">
        <div class="col-md-12">
            <div class="card table-responsive">
                <div class="card-header">
                    <h4>Organizzazione Turni</h4>
                    <div class="row mt-5 justify-content-end">         
                        <div class="col-md-2">
                            <!-- campo di tipo settimana per inserire la data -->
                            <label for="data">Seleziona Data:</label>
                            <input class="form-control" type="week" id="data" name="data" onchange="updateWeek()">
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Tabella -->
                        <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
                            <thead>
                                <th width="15%">Nome</th>
                                <th width="15%">Cognome</th>
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
            'url': 'gestione/fetch_data_turni.php',
            'type': 'post',
            'data': function(data) {
                data.data = $('#data').val();
            },
        },
        "language": {
            "url": '../assets/js/Datatable_italiano.json',
        }
    });
});

// Funzione per aggiornare la tabella quando viene chiamata
function updateWeek() {
    // Ricarica i dati della tabella DataTable senza aggiornare l'ordine delle colonne
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


</script>
</body>
</html>
