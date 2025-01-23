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
    <title>Farmaci disponibili</title>
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
          <h4>Farmaci disponibili</h4>
          <div class="row mt-5 justify-content-end">
            <div class="col-md-2">
              <!-- select per selezionare un ambulatorio -->
              <label class="label" for="ambulatorio">Seleziona Ambulatorio:</label>
              <select class="form-control" id="ambulatorio" onchange="updateAmbulatorio()">
              <option value="cardiologia" <?php echo ($_SESSION['nome_ambulatorio'] == 'cardiologia') ? 'selected' : ''; ?>>Cardiologia</option>
              <option value="chirurgia" <?php echo ($_SESSION['nome_ambulatorio'] == 'chirurgia') ? 'selected' : ''; ?>>Chirurgia</option>
              <option value="endocrinologia" <?php echo ($_SESSION['nome_ambulatorio'] == 'endocrinologia') ? 'selected' : ''; ?>>Endocrinologia</option>
              <option value="neurologia" <?php echo ($_SESSION['nome_ambulatorio'] == 'neurologia') ? 'selected' : ''; ?>>Neurologia</option>
              <option value="ortopedia" <?php echo ($_SESSION['nome_ambulatorio'] == 'ortopedia') ? 'selected' : ''; ?>>Ortopedia</option>
              </select>
            </div>
          </div>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="12%">farmacia</th>
                <th width="5%">id farmaco</th>
                <th width="12%">nome</th>
                <th width="5%">quantità</th>
                <th width="12%">scadenza</th>
                <th width="10%">Opzioni</th>
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
      'url': 'gestione/fetch_data_farmaci.php',
      'type': 'post',
      'data': function(data) {
        data.ambulatorio = $('#ambulatorio').val();
      },
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

function updateAmbulatorio() {
    // Ricarica i dati della tabella senza modificare la pagina attuale
    $('#Tabella').DataTable().ajax.reload(null, false); 
}

// Gestione dell'invio del modulo per diminuire il numero di un farmaco tramite AJAX
$(document).on('click', '.diminuiscibtn', function(event) {
  event.preventDefault();
  var id = $(this).data('id'); 
  var trid = $(this).closest('tr').attr('id');
  var nome_farmaco = $(this).data('nome-farmaco'); 
  var nome_ambulatorio = $(this).data('nome-ambulatorio');
  var modifica = -1; 
  $.ajax({
    url: "gestione/quantità_farmaci.php",
    type: "post",
    data: {
      id: id,
      nome_ambulatorio: nome_ambulatorio,
      modifica: modifica,
    },
    success: function(data) {
      var json = JSON.parse(data);
      status = json.status;
      scadenza = json.scadenza;
      quantità = json.quantità;
      message = json.message;
      if (status == 'true') {
        tabella = $('#Tabella').DataTable();
        tabella.draw();
        $('#ImpostaformModulo').modal('hide');
      }else {
        alert(message);
        return;
      } 
    }
  });
})

// Gestione dell'invio del modulo per aumentare il numero di un farmaco tramite AJAX
$(document).on('click', '.aggiungibtn', function(event) {
  event.preventDefault();
  var id = $(this).data('id'); 
  var trid = $(this).closest('tr').attr('id');
  var nome_farmaco = $(this).data('nome-farmaco'); 
  var nome_ambulatorio = $(this).data('nome-ambulatorio');
  var modifica = 1; 
  $.ajax({
    url: "gestione/quantità_farmaci.php",
    type: "post",
    data: {
      id: id,
      nome_ambulatorio: nome_ambulatorio,
      modifica: modifica,
    },
    success: function(data) {
      var json = JSON.parse(data);
      status = json.status;
      scadenza = json.scadenza;
      quantità = json.quantità;
      message = json.message;
      if (status == 'true') {
        tabella = $('#Tabella').DataTable();
        tabella.draw();
        $('#ImpostaformModulo').modal('hide');
      } else {
        alert(message);
        return;
      }
    }
  });
})

// Gestione dell'invio del modulo per modificare quantità/scadenza di un farmaco tramite AJAX
$(document).on('submit', '#Impostaform', function(event) {
  event.preventDefault();
  var quantità = $('#ImpostaQuantitàCampo').val();
  var scadenza = $('#ImpostaScadenzaCampo').val();
  var id = $('#id').val();
  var trid = $('#trid').val();
  var nome_ambulatorio = $('#nome_ambulatorio').val();
  var nome_farmaco = $('#nome_farmaco').val();
  $.ajax({
    url: "gestione/imposta_farmaci.php",
    type: "post",
    data: {
      quantità: quantità,
      scadenza: scadenza,
      id: id,
      nome_ambulatorio: nome_ambulatorio,
    },
    success: function(data) {
      var json = JSON.parse(data); 
      var status = json.status;
      var message = json.message;
      if (status == 'true') {
        tabella = $('#Tabella').DataTable();
        tabella.draw();
        $('#ImpostaformModulo').modal('hide');
      } else {
        alert(message);
      }
    }
  });
});

// Gestione del click sul pulsante di modifica di un'assicurazione tramite AJAX
$(document).on('click', '.editbtn', function(event) {
  var trid = $(this).closest('tr').attr('id');
  var id = $(this).data('id'); 
  var nome_farmaco = $(this).data('nome-farmaco'); 
  var nome_ambulatorio = $(this).data('nome-ambulatorio'); 
  $('#ImpostaformModulo').modal('show'); 
  $.ajax({
    url: "gestione/singola_riga_farmaco.php",
    type: 'post',
    data: {
      id: id,
      nome_ambulatorio:nome_ambulatorio,
    },
    success: function(data) {
      var json = JSON.parse(data);
      $('#ImpostaQuantitàCampo').val(json.quantità);
      $('#ImpostaScadenzaCampo').val(json.scadenza);
      $('#trid').val(trid);
      $('#id').val(id);
      $('#nome_ambulatorio').val(nome_ambulatorio);
      $('#nome_farmaco').val(nome_farmaco);
    }
  })
});

</script>
<!-- Modulo per aggiungere un farmaco -->
<div class="modal fade" id="ImpostaformModulo" tabindex="-1" aria-labelledby="ImpostaformEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ImpostaformModuloLabel">Imposta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Impostaform">
          <input type="hidden" name="id" id="id" value=""> 
          <input type="hidden" name="trid" id="trid" value=""> 
          <input type="hidden" name="nome_ambulatorio" id="nome_ambulatorio" value=""> 
          <input type="hidden" name="nome_farmaco" id="nome_farmaco" value=""> 
          <div class="mb-3 row">
            <label for="ImpostaQuantitàCampo" class="form-label">Imposta quantità</label>
            <div class="col-md-9">
              <input type="number" class="form-control" name="quantità" id = "ImpostaQuantitàCampo">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ImpostaScadenzaCampo" class="form-label">Imposta Scadenza</label>
            <div class="col-md-9">
              <input type="date" class="form-control" name="scadenza" id = "ImpostaScadenzaCampo">
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">invia</button>
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

