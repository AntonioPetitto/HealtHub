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
    <title>Visite prenotate</title>
</head>
<body>
  <style>

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
          <h4>Visite prenotate</h4>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">id Visita</th>
                <th width="5%">medico</th>
                <th width="12%">Ambulatorio</th>
                <th width="12%">Data</th>
                <th width="12%">Orario</th>
                <th width="12%">Opzioni</th>
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
      'url': 'gestione/fetch_data_prenotate.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [5]
    }],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

// Gestione del click sul pulsante per annullare una visita tramite AJAX
$(document).on('click', '.annullaBtn', function(event) {
  event.preventDefault();
  var tabella = $('#Tabella').DataTable();  
  var id = $(this).data('id');
  if (confirm("Sei sicuro di voler annullare la prenotazione? ")) {
    $.ajax({
      url: "gestione/annulla_prenotazione.php",
      type: "post",
      data: {
        id: id
      },
      success: function(data) {
        var json = JSON.parse(data);
        status = json.status;
        message = json.message;
        if (status == 'true') {
          $(this).closest('tr').remove(); 
        } else {
          alert(message);
          return;
        }
      }.bind(this)
    });
  } else {
    return false;
  }
})

</script>
</body>
</html>