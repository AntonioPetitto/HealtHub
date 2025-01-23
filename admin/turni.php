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


    .btnAdd {
        padding: 0.75rem 1rem;
        margin-top: 31px;
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
                        <div class="col-md-1">
                            <a href="javascript:void();" class="btn btnAdd bg-gradient-primary text-dark btn-sm">Aggiungi turni</a>
                        </div>
                        <div class="col-md-2">
                            <!-- select per selezionare un ambulatorio -->
                            <label for="ambulatorio">Seleziona Ambulatorio:</label>
                            <select class="form-control" id="ambulatorio" onchange="updateWeek()">
                                <option value="">Tutti gli ambulatori</option>
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
                                <th width="15%">Opzioni</th>
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
                data.ambulatorio = $('#ambulatorio').val();
                data.data = $('#data').val();
            },
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [9]
        }],
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

// Gestione dell'invio del modulo per l'aggiunta dei turni in una settimana tramite AJAX
$(document).on('click', '.btnAdd', function(event) {
    var tabella = $('#Tabella').DataTable();
    var data = $('#data').val();
    if(confirm("sei sicuro di voler aggiungere turni a questa settimana?")){
        if (data != ""){
            $.ajax({
            url: "gestione/aggiungi_turni.php",
            data: {
                data : data,
            },
            type: 'post',
                success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    var message = json.message;
                    if (status == 'true') {
                    tabella.draw();
                    alert(message);
                    } else {
                    alert(message);
                    }
                }
            })
        }else{
            alert("Non è stata inserita nessuna data");
        }
    }else {
        return null;
    }
});

// Gestione dell'invio del modulo per modificare dei turni in una settimana tramite AJAX
$(document).on('submit', '#ModificaOrario', function(e) {
    event.preventDefault();
    var data = $('#data').val();
    var lunedì_inizio = $('#ModificaLunedìInizioCampo').val();
    var martedì_inizio = $('#ModificaMartediInizioCampo').val();
    var mercoledì_inizio = $('#ModificaMercoledìInizioCampo').val();
    var giovedì_inizio = $('#ModificaGiovedìInizioCampo').val();
    var venerdì_inizio = $('#ModificaVenerdìInizioCampo').val();
    var sabato_inizio = $('#ModificaSabatoInizioCampo').val();
    var domenica_inizio = $('#ModificaDomenicaInizioCampo').val();
    var lunedì_fine = $('#ModificaLunedìFineCampo').val();
    var martedì_fine = $('#ModificaMartediFineCampo').val();
    var mercoledì_fine = $('#ModificaMercoledìFineCampo').val();
    var giovedì_fine = $('#ModificaGiovedìFineCampo').val();
    var venerdì_fine = $('#ModificaVenerdìFineCampo').val();
    var sabato_fine = $('#ModificaSabatoFineCampo').val();
    var domenica_fine = $('#ModificaDomenicaFineCampo').val();
    var id_calendario = $('#id_calendario').val();
    var id = $('#id').val();
    $.ajax({
        url: "gestione/modifica_turno.php",
        type: "post",
        data: {
            data : data,
            lunedì_inizio: lunedì_inizio,
            martedì_inizio: martedì_inizio,
            mercoledì_inizio: mercoledì_inizio,
            giovedì_inizio: giovedì_inizio,
            venerdì_inizio: venerdì_inizio,
            sabato_inizio: sabato_inizio,
            domenica_inizio: domenica_inizio,
            lunedì_fine: lunedì_fine,
            martedì_fine: martedì_fine,
            mercoledì_fine: mercoledì_fine,
            giovedì_fine: giovedì_fine,
            venerdì_fine: venerdì_fine,
            sabato_fine: sabato_fine,
            domenica_fine: domenica_fine,
            id_calendario: id_calendario,
            id: id,
        },
        success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'true') {
            tabella = $('#Tabella').DataTable();
            tabella.draw();
            $('#ModificaOrarioModulo').modal('hide');
            } else {
                alert('failed');
            }
        }
    });  
});

// Gestione del click sul pulsante di modifica dei turni in una settimana tramite AJAX
$('#Tabella').on('click', '.editbtn ', function(event) {
    var tabella = $('#Tabella').DataTable();
    var id = $(this).data('id');
    var id_calendario = $(this).data('id-calendario');
    console.log(id);
    var data = $('#data').val();
    $('#ModificaOrarioModulo').modal('show');
    $.ajax({
    url: "gestione/singola_riga_turno.php",
    type: 'post',
    data: {
        id: id,
        data : data,
        data : data,
    },
        success: function(data) {
            var json = JSON.parse(data);
            $('#ModificaLunedìInizioCampo').val(json.lunedì.inizio);
            $('#ModificaMartediInizioCampo').val(json.martedì.inizio);
            $('#ModificaMercoledìInizioCampo').val(json.mercoledì.inizio);
            $('#ModificaGiovedìInizioCampo').val(json.giovedì.inizio);
            $('#ModificaVenerdìInizioCampo').val(json.venerdì.inizio);
            $('#ModificaSabatoInizioCampo').val(json.sabato.inizio);
            $('#ModificaDomenicaInizioCampo').val(json.domenica.inizio);
            $('#ModificaLunedìFineCampo').val(json.lunedì.fine);
            $('#ModificaMartediFineCampo').val(json.martedì.fine);
            $('#ModificaMercoledìFineCampo').val(json.mercoledì.fine);
            $('#ModificaGiovedìFineCampo').val(json.giovedì.fine);
            $('#ModificaVenerdìFineCampo').val(json.venerdì.fine);
            $('#ModificaSabatoFineCampo').val(json.sabato.fine);
            $('#ModificaDomenicaFineCampo').val(json.domenica.fine);
            $('#id_calendario').val(id_calendario);
            $('#id').val(id);
        }
    })
});

</script>

<!-- Modulo per modificare/inserire gli orari dei turni in una settimana -->
<div class="modal fade" id="ModificaOrarioModulo" tabindex="-1" aria-labelledby="ModificaOrarioEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ModificaOrarioModulo">Aggiungi Orario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="ModificaOrario" action="">
                <input type="hidden" name="id_calendario" id="id_calendario" value="">
                <input type="hidden" name="id" id="id" value="">
                <h6 class="col-md-4">Turno Lunedì</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaLunedìInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaLunedìInizioCampo" name="orario_inizio_lunedì">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaLunedìFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaLunedìFineCampo" name="orario_fine_lunedì">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Martedi</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaMartediInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaMartediInizioCampo" name="orario_inizio_Martedi">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaMartediFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaMartediFineCampo" name="orario_fine_Martedi">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Mercoledì</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaMercoledìInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaMercoledìInizioCampo" name="orario_inizio_Mercoledì">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaMercoledìFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaMercoledìFineCampo" name="orario_fine_Mercoledì">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Giovedì</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaGiovedìInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaGiovedìInizioCampo" name="orario_inizio_Giovedì">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaGiovedìFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaGiovedìFineCampo" name="orario_fine_Giovedì">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Venerdì</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaVenerdìInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaVenerdìInizioCampo" name="orario_inizio_Venerdì">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaVenerdìFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaVenerdìFineCampo" name="orario_fine_Venerdì">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Sabato</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaSabatoInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaSabatoInizioCampo" name="orario_inizio_Sabato">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaSabatoFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaSabatoFineCampo" name="orario_fine_Sabato">
                    </div>
                </div>
                <h6 class="col-md-4">Turno Domenica</h6>
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <label for="ModificaDomenicaInizioCampo" class="col-md-3 form-label">inizio</label>
                        <input type="time" class="form-control" id="ModificaDomenicaInizioCampo" name="orario_inizio_Domenica">
                    </div>
                    <div class="col-md-3">
                        <label for="ModificaDomenicaFineCampo" class="col-md-3 form-label">fine</label>
                        <input type="time" class="form-control" id="ModificaDomenicaFineCampo" name="orario_fine_Domenica">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Invia</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
        </div>
    </div>
  </div>
</div>
</body>
</html>
