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
  <title>Lista Utenti</title>
</head>
<body>
  <style>

  .dataTables_wrapper .dataTables_filter {
    margin-right: 26px;
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
          <h4>Lista Utenti</h4>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">ID</th>
                <th width="18%">Nome</th>
                <th width="18%">Cognome</th>
                <th width="18%">Email</th>
                <th width="18%">Password</th>
                <th width="10%">Data_registrazione</th>
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
      $(nRow).attr('id_utente', aData[0]);
    },
    'serverSide': 'true',
    'processing': 'true',
    'paging': 'true',
    'order': [],
    'ajax': {
      'url': 'gestione/fetch_data_utente.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [6]
    },
    ],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    },
  });
});

// Gestione dell'invio del modulo per modificare un utente tramite AJAX
$(document).on('submit', '#ModificaUtente', function(e) {
  e.preventDefault();
  var nome = $('#ModificaNomeCampo').val();
  var cognome = $('#ModificaCognomeCampo').val();
  var email = $('#ModificaEmailCampo').val();
  var password = $('#ModificaPasswordCampo').val();
  var data_registrazione = $('#ModificaDataregistrazioneCampo').val();
  var trid = $('#trid').val();
  var id = $('#id').val();

  if (email != '' && password != '' && data_registrazione != '') {
    $.ajax({
      url: "gestione/modifica_utente.php",
      type: "post",
      data: {
        nome: nome,
        cognome: cognome,
        email: email,
        password: password,
        data_registrazione: data_registrazione,
        id: id,
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          tabella = $('#Tabella').DataTable();
          tabella.draw();
          $('#ModificaUtenteModulo').modal('hide');
        } else {
          alert('failed');
        }
      }
    });
    } else {
      alert('Riempi tutti i campi richiesti');
    }
});

// Gestione del click sul pulsante di modifica di un utente tramite AJAX
$('#Tabella').on('click', '.editbtn ', function(event) {
  var tabella = $('#Tabella').DataTable();
  var trid = $(this).closest('tr').attr('id');
  var id = $(this).data('id');
  $('#ModificaUtenteModulo').modal('show');

  $.ajax({
    url: "gestione/singola_riga_utente.php",
    type: 'post',
    data: {
      id: id
    },
    success: function(data) {
      var json = JSON.parse(data);
      $('#ModificaNomeCampo').val(json.nome);
      $('#ModificaCognomeCampo').val(json.cognome);
      $('#ModificaEmailCampo').val(json.email);
      $('#ModificaPasswordCampo').val(json.pass);
      $('#ModificaDataregistrazioneCampo').val(json.data_registrazione);
      $('#id').val(id);
      $('#trid').val(trid);
    }
  })
});

</script>

<!--Modulo per modificare un utente -->
<div class="modal fade" id="ModificaUtenteModulo" tabindex="-1" aria-labelledby="ModificaUtenteEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModificaUtenteModulo">Modifica Utenti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ModificaUtente">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">
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
            <label for="ModificaEmailCampo" class="col-md-3 form-label">Email</label>
            <div class="col-md-9">
              <input type="email" class="form-control" id="ModificaEmailCampo" name="email">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaPasswordCampo" class="col-md-3 form-label">Password</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaPasswordCampo" name="password">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaDataregistrazioneCampo" class="col-md-3 form-label">Data registrazione</label>
            <div class="col-md-9">
              <input type="date" class="form-control" id="ModificaDataregistrazioneCampo" name="data_registrazione">
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