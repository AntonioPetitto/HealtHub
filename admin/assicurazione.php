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
  <title>Aggiungi/Modifica Assicurazione</title>
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
          <h4>Gestione Assicurazioni</h4>
          <div class="btnAdd">
            <!-- Pulsante per aggiungere un'assicurazione -->
            <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#AggiungiAssicurazioneModulo" class="btn bg-gradient-primary text-dark btn-sm">Aggiungi assicurazione</a>
          </div>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">ID</th>
                <th width="5%">ID paz</th>
                <th width="12%">Nome</th>
                <th width="12%">Cognome</th>
                <th width="12%">Numero polizza</th>
                <th width="12%">tipo</th>
                <th width="10%">data scadenza</th>
                <th width="12%">Compagnia</th>
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
      'url': 'gestione/fetch_data_assicurazione.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [8]
    },
    ],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

// Gestione dell'invio del modulo per l'aggiunta di un'assicurazione tramite AJAX
$(document).on('submit', '#AggiungiAssicurazione', function(e) {
  event.preventDefault();
  var numero_polizza = $('#AggiungiNumeroPolizzaCampo').val();
  var tipo = $('#AggiungiTipoCampo').val();
  var data_scadenza = $('#AggiungiDatascadenzaCampo').val();
  var id_compagnia = $('#AggiungiCompagniaCampo').val();
  var id_paziente= $('#AggiungiIdCampo').val();
    if (numero_polizza != '' && tipo != '' && data_scadenza != '' && id_compagnia != '' && id_paziente !='') {
      $.ajax({
        url: "gestione/aggiungi_assicurazione.php",
        type: "post",
        data: {
          numero_polizza : numero_polizza,
          tipo : tipo,
          data_scadenza : data_scadenza,
          id_compagnia : id_compagnia,
          id_paziente: id_paziente,
        },
        success: function(data) {
          var json = JSON.parse(data);
          var status = json.status;
          if (status == 'true') {
            tabella = $('#Tabella').DataTable();
            tabella.draw();
            alert('Assicurazione inserita con successo');
            $('#AggiungiAssicurazioneModulo').modal('hide');
            $('#AggiungiAssicurazione')[0].reset();
          } else {
            alert('failed');
          }
        }
      });
    } else {
      alert('Riempi tutti i campi richiesti');
    }
});

// Gestione dell'invio del modulo per modificare un'assicurazione tramite AJAX
$(document).on('submit', '#ModificaAssicurazione', function(e) {
  event.preventDefault();
  var nome = $('#ModificaNomeCampo').val();
  var cognome = $('#ModificaCognomeCampo').val();
  var tipo = $('#ModificaTipoCampo').val();
  var data_scadenza = $('#ModificaDatascadenzaCampo').val();
  var nome_compagnia = $('#ModificaCompagniaCampo').val();
  var numero_polizza = $('#numero_polizza').val();
  var id_paziente = $('#id_paziente').val();
  var trid = $('#trid').val();
  var id = $('#id').val();
  if (nome != '' && cognome != '') {
    $.ajax({
      url: "gestione/modifica_assicurazione.php",
      type: "post",
      data: {
        nome : nome,
        cognome : cognome,
        tipo : tipo,
        data_scadenza : data_scadenza,
        nome_compagnia : nome_compagnia,
        numero_polizza: numero_polizza,
        id_paziente: id_paziente,
        id: id,
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          tabella = $('#Tabella').DataTable();
          tabella.draw();
          $('#ModificaAssicurazioneModulo').modal('hide');
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
  $('#ModificaAssicurazioneModulo').modal('show');
    $.ajax({
      url: "gestione/singola_riga_assicurazione.php",
      type: 'post',
      data: {
        id: id
      },
      success: function(data) {
        var json = JSON.parse(data);
        $('#ModificaNomeCampo').val(json.nome);
        $('#ModificaCognomeCampo').val(json.cognome);
        $('#ModificaTipoCampo').val(json.tipo);
        $('#ModificaDatascadenzaCampo').val(json.data_scadenza);
        $('#ModificaCompagniaCampo').val(json.nome_compagnia);
        $('#numero_polizza').val(json.numero_polizza);
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
        id: id,
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

<!-- Modulo per aggiungere un'assicurazione -->
<div class="modal fade" id="AggiungiAssicurazioneModulo" tabindex="-1" aria-labelledby="AggiungiAssicurazioneEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AggiungiAssicurazioneModulo">Aggiungi Assicurazione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="AggiungiAssicurazione" action="">
          <div class="mb-3 row">
            <label for="AggiungiIdCampo" class="col-md-3 form-label">Id paziente</label>
            <div class="col-md-9">
              <input type="number" class="form-control" id="AggiungiIdCampo" name="id_paziente">
            </div>
          </div>
        <div class="mb-3 row">
          <label for="AggiungiNumeroPolizzaCampo" class="col-md-3 form-label">numero polizza</label>
          <div class="col-md-9">
            <input type="number" class="form-control" id="AggiungiNumeroPolizzaCampo" name="numero_polizza">
          </div>
        </div>
          <div class="mb-3 row">
            <label for="AggiungiTipoCampo" class="col-md-3 form-label">tipo</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="AggiungiTipoCampo" name="tipo">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="AggiungiDatascadenzaCampo" class="col-md-3 form-label">Data Scadenza</label >
            <div class="col-md-9">
              <input type="date" class="form-control" id="AggiungiDatascadenzaCampo" name="data_scadenza">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="AggiungiCompagniaCampo" class="col-md-3 form-label">Compagnia</label>
            <div class="col-md-9">
              <select class="form-control" id="AggiungiCompagniaCampo" name="compagnia">
                <option value="" data-value="">Seleziona compagnia</option>
                  <option value="1">StaySafe</option>
                  <option value="2">HealthCare</option>
                  <option value="3">SafeShield</option>
              </select>
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

<!--Modulo per modificare un'assicurazione-->
<div class="modal fade" id="ModificaAssicurazioneModulo" tabindex="-1" aria-labelledby="ModificaAssicurazioneEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModificaAssicurazioneModulo">Modifica Assicurazione</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ModificaAssicurazione">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">
          <input type="hidden" name="id_paziente" id="id_paziente" value="">
          <input type="hidden" name="numero_polizza" id="numero_polizza" value="">
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
            <label>Modifica/elimina l'assicurazione</label><br>
            <div class="col-md-9">
              <input type="radio" name="assicurazione" id="possesso1" value="si" required onclick="abilitaCampi()">modifica 
              <input type="radio" name="assicurazione" id="possesso2" value="no" required onclick="abilitaCampi()">elimina 
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaTipoCampo" class="col-md-3 form-label">tipo</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaTipoCampo" name="tipo" disabled>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaDatascadenzaCampo" class="col-md-3 form-label">Data Scadenza</label >
            <div class="col-md-9">
              <input type="date" class="form-control" id="ModificaDatascadenzaCampo" name="data_scadenza" disabled>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaCompagniaCampo" class="col-md-3 form-label">Compagnia</label>
            <div class="col-md-9">
              <select class="form-control" id="ModificaCompagniaCampo" name="compagnia" disabled>
                <option value="" data-value="">Seleziona compagnia</option>
                  <option value="StaySafe">StaySafe</option>
                  <option value="HealthCare">HealthCare</option>
                  <option value="SafeShield">SafeShield</option>
              </select>
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

<script>

// Funzione per abilitare/disabilitare campi in base alla selezione
function abilitaCampi() {
  var possesso1 = document.getElementById('possesso1');
  var TipoCampo = document.getElementById('ModificaTipoCampo');
  var DataScadenzaCampo = document.getElementById('ModificaDatascadenzaCampo');
  var numero_polizza = document.getElementById('numero_polizza');
  var CompagniaCampo = document.getElementById('ModificaCompagniaCampo');

  // Codice per abilitare/disabilitare campi
  if (possesso1.checked) {
    TipoCampo.disabled = false;
    DataScadenzaCampo.disabled = false;
    CompagniaCampo.disabled = false;
        // Se numero_polizza è vuoto e entrambe le radio sono selezionate, disabilita i campi
    if (numero_polizza.value.trim() === '') {
      TipoCampo.disabled = true;
      DataScadenzaCampo.disabled = true;
      CompagniaCampo.disabled = true;
      TipoCampo.value = '';
      DataScadenzaCampo.value = '';
      CompagniaCampo.value = '';
    }
  } else {
    TipoCampo.disabled = true;
    DataScadenzaCampo.disabled = true;
    CompagniaCampo.disabled = true;
    TipoCampo.value = '';
    DataScadenzaCampo.value = '';
    CompagniaCampo.value = '';
  }
}

// Evento alla chiusura del modulo di modifica per deselezionare i radio button
$('#ModificaAssicurazioneModulo').on('hidden.bs.modal', function (e) {
    // Codice per deselezionare i radio button
    $('input[name="assicurazione"]').prop('checked', false);
});

</script>
</body>
</html>