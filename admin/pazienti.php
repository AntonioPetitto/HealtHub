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
    <title>Lista Pazienti</title>
</head>
<body>
  <style>

  .btnAdd {
    text-align: end;
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
          <h4>Lista  Pazienti</h4>
          <div class="btnAdd">
            <!-- Pulsante per aggiungere un paziente -->
            <a href="aggiungi_pazienti.php" class="btn bg-gradient-primary text-dark btn-sm">Aggiungi Paziente</a>
          </div>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">ID</th>
                <th width="5%">ID paz</th>
                <th width="12%">Nome</th>
                <th width="12%">Cognome</th>
                <th width="12%">Codice fiscale</th>
                <th width="12%">CIE</th>
                <th width="12%">Telefono</th>
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
      'url': 'gestione/fetch_data_paziente.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [7]
    },
    ],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

//Gestione dell'invio del modulo per modificare un paziente tramite AJAX
$(document).on('submit', '#ModificaPaziente', function(e) {
  e.preventDefault();
  var nome = $('#ModificaNomeCampo').val();
  var cognome = $('#ModificaCognomeCampo').val();
  var codice_fiscale = $('#ModificaCfCampo').val();
  var cie = $('#ModificaCieCampo').val();
  var telefono = $('#ModificaTelefonoCampo').val();
  var id_paziente = $('#id_paziente').val();
  var trid = $('#trid').val();
  var id = $('#id').val();
  if (nome != '' && cognome != '') {
    $.ajax({
    url: "gestione/modifica_paziente.php",
      type: "post",
      data: {
        nome : nome,
        cognome : cognome,
        codice_fiscale : codice_fiscale,
        cie : cie,
        telefono :  telefono,
        id_paziente: id_paziente,
        id: id,
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          tabella = $('#Tabella').DataTable();
          tabella.draw();
          $('#ModificaPazienteModulo').modal('hide');
        } else {
          alert('failed');
        }
      }
    });
  } else {
    alert('Riempi tutti i campi richiesti');
  }
});

// Gestione del click sul pulsante di modifica di un'assicurazione tramite AJAX
$('#Tabella').on('click', '.editbtn ', function(event) {
  var tabella = $('#Tabella').DataTable();
  var trid = $(this).closest('tr').attr('id');
  var id = $(this).data('id');
  $('#ModificaPazienteModulo').modal('show');
  $.ajax({
    url: "gestione/singola_riga_paziente.php",
    type: 'post',
    data: {
      id: id
    },  
    success: function(data) {
      var json = JSON.parse(data);
      $('#ModificaNomeCampo').val(json.nome);
      $('#ModificaCognomeCampo').val(json.cognome);
      $('#ModificaCfCampo').val(json.codice_fiscale);
      $('#ModificaCieCampo').val(json.cie);
      $('#ModificaTelefonoCampo').val(json.telefono);
      $('#id_paziente').val(json.id_paziente);
      $('#id').val(id);
      $('#trid').val(trid);
    }
  })
});

//Gestione del click elimina per eliminare un paziente tramite AJAX
$(document).on('click', '.deleteBtn', function(event) {
  event.preventDefault();
  var tabella = $('#Tabella').DataTable();
  var id = $(this).data('id');
    if (confirm("Sei sicuro di voler eliminare questo paziente? ")) {
      $.ajax({
        url: "gestione/elimina_paziente.php",
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
      return null;
  }
})

</script>

<!--Modulo per modificare un paziente-->
<div class="modal fade" id="ModificaPazienteModulo" tabindex="-1" aria-labelledby="ModificaPazienteEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModificaPazienteModulo">Modifica Utenti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ModificaPaziente">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">
          <input type="hidden" name="id_paziente" id="id_paziente" value="">
          <div class="mb-3 row">
            <label for="ModificaNomeCampo" class="col-md-3 form-label">Nome</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaNomeCampo" name="nome">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaCognomeCampo" class="col-md-3 form-label">Cognome</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaCognomeCampo" name="cognome">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaCfCampo" class="col-md-4 form-label">Codice fiscale</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaCfCampo" name="codice_fiscale">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaCieCampo" class="col-md-3 form-label">CIE</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaCieCampo" name="cie">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaTelefonoCampo" class="col-md-3 form-label">Telefono</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaTelefonoCampo" name="telefono">
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Conferma Modifiche</button>
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
