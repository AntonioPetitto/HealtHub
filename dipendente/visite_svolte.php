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
    <title>Visite svolte</title>
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
          <h4>Visite completate</h4>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">id Visita</th>
                <th width="5%">id Paziente</th>
                <th width="12%">Nome</th>
                <th width="12%">Cognome</th>
                <th width="12%">Data</th>
                <th width="12%">Orario</th>
                <th width="12%">Referto</th>
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
      'url': 'gestione/fetch_data_visite_svolte.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [7]
    }],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

// Gestione dell'invio del modulo per l'upload di un referto tramire AJAX
$(document).on('submit', '#UploadReferto', function(e) {
  e.preventDefault(); 
  tabella = $('#Tabella').DataTable();
  $.ajax({
    url: "gestione/upload.php",
    type: "post",
    data: new FormData(this),
    dataType: 'json',
    contentType: false,
    cache: false,
    processData: false,
    success: function(data, textStatus, jqXHR) {
      if (data.status == 'true') {
        tabella.draw();
        alert(data.message);
        $('#UploadForm').modal('hide');
        
      } else {
        alert(data.message);
      }
    },
    error: function() {
      alert("Errore");
    }
  });
});

// Gestione del click sul pulsante per l'upload di un referto tramire AJAX
$(document).on('click', '.uploadbtn', function(event) {
  $('#UploadForm').modal('show'); 
  var id = $(this).data('id'); 
  $('#id').val(id); 
});

// Gestione del click sul pulsante per l'eliminazione di un referto tramire AJAX
$(document).on('click', '.deleteBtn', function(event) {
  var tabella = $('#Tabella').DataTable();
  var percorso = $(this).data('file-path');
  var nome_file = $(this).data('file-name');
  var id = $(this).data('id');
  if (confirm("Sei sicuro di voler eliminare questo referto? ")) {
    $.ajax({
      url: 'gestione/elimina_file.php', 
      method: 'post',
      data: { 
        percorso: percorso, 
        nome_file: nome_file,
        id: id,
      },
      success: function(data, textStatus, jqXHR) {
        var data = JSON.parse(data);
        if (data.status == 'true') {
          alert(data.message);
          tabella.draw();
        } else {
          alert(data.message);
        }
      }
    });
  }
});

</script>
<!-- Modulo per aggiungere un referto -->
<div class="modal fade" id="UploadForm" tabindex="-1" aria-labelledby="UploadFormEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UploadFormModulo">Upload Referto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="UploadReferto">
          <input type="hidden" name="id" id="id" value=""> 
          <div class="mb-3 row">
            <label for="file" class="form-label">Select file</label>
            <div class="col-md-9">
              <input type="file" class="form-control" name="file" id = "file">
            </div>
          </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>
</script>
</body>
</html>