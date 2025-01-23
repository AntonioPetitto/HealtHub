<?php 
include('includes/header.php');
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
    margin-right: 28px;
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
  <div class="row mb-3">
    <div class="col-md-12">
      <div class="card table-responsive">
        <div class="card-header">
          <h4>Riepilogo visite</h4>
          <div class="card-body">
            <!-- Tabella riepilogo visite-->
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

  <div class="row">
    <div class="col-md-12">
      <div class="card table-responsive">
        <div class="card-header">
          <h4>Fatture</h4>
          <div class="card-body">
            <!-- Tabella fatture-->
            <table id="Tabella2" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">id Visita</th>
                <th width="5%">numero fattura</th>
                <th width="12%">Importo</th>
                <th width="12%">Pagato</th>
                <th width="12%">Modalità</th>
                <th width="12%">Data pagamento</th>
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

// Configurazioni della tabella riepilogo visite in DataTable
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
      'url': 'gestione/fetch_data_riepilogo.php',
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

// Configurazioni della tabella delle fatture in DataTable
$(document).ready(function() {
  $('#Tabella2').DataTable({
    "fnCreatedRow": function(nRow, aData, iDataIndex) {
      $(nRow).attr('id', aData[0]);
    },
    'serverSide': true,
    'processing': true,
    'paging': true,
    'order': [],
    'ajax': {
      'url': 'gestione/fetch_data_fatture.php',
      'type': 'post',
    },
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

</script>
</body>
</html>