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
  <title>Lista Dipendenti</title>
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
    overflow-x: auto; 
  }


  </style>

  <!-- Struttura della pagina -->
  <div class="row">
    <div class="col-md-12">
      <div class="card table-responsive">
        <div class="card-header">
          <h4>Lista Dipendeti</h4>
          <div class="btnAdd">
            <!-- Pulsante per aggiungere un dipendente -->
            <a href="aggiungi_dipendenti.php" class="btn bg-gradient-primary text-dark btn-sm">Aggiungi Dipendente</a>      
          </div>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">ID</th>
                <th width="5%">ID dip</th>
                <th width="12%">Nome</th>
                <th width="12%">Cognome</th>
                <th width="12%">Ruolo</th>
                <th width="12%">Ambulatorio</th>
                <th width="10%">Stipendio</th>
                <th width="12%">Contratto</th>
                <th width="10%">Data cessazione</th>
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
      'url': 'gestione/fetch_data_dipendente.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [9]
    },
    ],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

// Gestione dell'invio del modulo per modificare un dipendente tramite AJAX
$(document).on('submit', '#ModificaDipendente', function(e) {
  e.preventDefault();
  var tabella = $('#Tabella').DataTable();
  var nome = $('#ModificaNomeCampo').val();
  var cognome = $('#ModificaCognomeCampo').val();
  var ruolo = $('#ModificaRuoloCampo').val();
  var ambulatorio = $('#ModificaAmbulatorioCampo').val();
  var stipendio = $('#ModificaStipendioCampo').val();
  var contratto = $('#ModificaContrattoCampo').val();
  var data_cessazione = $('#ModificaDatacessazioneCampo').val();
  var id_dipendente = $('#id_dipendente').val();
  var trid = $('#trid').val();
  var id = $('#id').val();
  if (nome != '' && cognome != '' && ruolo != '' && stipendio != '' && contratto != '') {
    $.ajax({
      url: "gestione/modifica_dipendente.php",
      type: "post",
      data: {
        nome : nome,
        cognome : cognome,
        ruolo : ruolo,
        ambulatorio : ambulatorio,
        stipendio : stipendio,
        contratto : contratto,
        data_cessazione : data_cessazione,
        id_dipendente: id_dipendente,
        id: id,
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          
          tabella.clear().draw();
          $('#ModificaDipendenteModulo').modal('hide');
        } else {
          alert('failed');
        }
      }
    });
  } else {
    alert('Riempi tutti i campi richiesti');
  }
});
  
// Gestione del click sul pulsante di modifica di un dipendente tramite AJAX
$('#Tabella').on('click', '.editbtn ', function(event) {
  var tabella = $('#Tabella').DataTable();
  var trid = $(this).closest('tr').attr('id');
  var id = $(this).data('id');
  $('#ModificaDipendenteModulo').modal('show');
    $.ajax({
      url: "gestione/singola_riga_dipendente.php",
      type: 'post',
    data: {
      id: id
    },
    success: function(data) {
      var json = JSON.parse(data);
      $('#ModificaNomeCampo').val(json.nome);
      $('#ModificaCognomeCampo').val(json.cognome);
      $('#ModificaRuoloCampo').val(json.ruolo);
      $('#ModificaAmbulatorioCampo').val(json.nome_ambulatorio);
      $('#ModificaStipendioCampo').val(json.stipendio);
      $('#ModificaContrattoCampo').val(json.tipo);
      $('#ModificaDatacessazioneCampo').val(json.data_cessazione);
      $('#id_dipendente').val(json.id_dipendente);
      $('#id').val(id);
      $('#trid').val(trid);
      }
    })
});

//Gestione del click licenzia per licenziare un dipendente tramite AJAX
$(document).on('click', '.licenziaBtn', function(event) {
  event.preventDefault();
  var tabella = $('#Tabella').DataTable();
  var id = $(this).data('id');
  if (confirm("Sei sicuro di voler licenziare questo dipendente? ")) {
    $.ajax({
      url: "gestione/licenzia_dipendente.php",
      type: "post",
      data: {
        id: id
      },        
      success: function(data) {
        var json = JSON.parse(data);
        status = json.status;
        message = json.message;
        if (status == 'true') {
          tabella.draw();
          $('#ModificaDipendenteModulo').modal('hide');
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

//Gestione del click elimina per eliminare un paziente tramite AJAX
$(document).on('click', '.deleteBtn', function(event) {
  event.preventDefault();
  var tabella = $('#Tabella').DataTable();
  var id = $(this).data('id');
  if (confirm("Sei sicuro di voler eliminare questo dipendente? ")) {
    $.ajax({
      url: "gestione/elimina_dipendente.php",
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

<!--Modulo per modificare un dipendente-->
<div class="modal fade" id="ModificaDipendenteModulo" tabindex="-1" aria-labelledby="ModificaDipendenteEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModificaDipendenteModulo">Modifica Utenti</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ModificaDipendente">
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">
          <input type="hidden" name="id_dipendente" id="id_dipendente" value="">
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
            <label for="ModificaRuoloCampo" class="col-md-3 form-label">Ruolo</label>
            <div class="col-md-9">
              <select class="form-control" id="ModificaRuoloCampo" name="ruolo">
                <option value="admin">Admin</option>
                <option value="medico">Medico</option>
                <option value="infermiere">Infermiere</option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaAmbulatorioCampo" class="col-md-3 form-label">Ambulatorio</label>
            <div class="col-md-9">
              <select class="form-control" id="ModificaAmbulatorioCampo" name="ambulatorio" disabled>
                <option value="">Seleziona ambulatorio</option>
                <option value="cardiologia">Cardiologia</option>
                <option value="chirurgia">Chirurgia</option>
                <option value="endocrinologia">Endocrinologia</option>
                <option value="neurologia">Neurologia</option>
                <option value="ortopedia">Ortopedia</option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaStipendioCampo" class="col-md-3 form-label">Stipendio</label>
            <div class="col-md-9">
              <input type="number" class="form-control" id="ModificaStipendioCampo" name="stipendio">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaContrattoCampo" class="col-md-3 form-label">Contratto</label>
            <div class="col-md-9">
              <select class="form-control" id="ModificaContrattoCampo" name="contratto">
                <option value="determinato">Determinato</option>
                <option value="indeterminato">Indeterminato</option>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ModificaDatacessazioneCampo" class="col-md-3 form-label">Data Cessazione</label >
            <div class="col-md-9">
              <input type="date" class="form-control" id="ModificaDatacessazioneCampo" name="data_cessazione" disabled>
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

$('#ModificaDipendenteModulo').on('shown.bs.modal', function () {
  // Dichiarazione dei select all'interno della funzione di callback
  var selRuolo = document.getElementById("ModificaRuoloCampo");
  var ambulatorio = document.getElementById("ModificaAmbulatorioCampo");
  var selTipo = document.getElementById("ModificaContrattoCampo");
  var data_cessazione = document.getElementById("ModificaDatacessazioneCampo");

  // Aggiorna lo stato dei campi in base ai valori selezionati
  updateFieldStatus(selRuolo, ambulatorio, selTipo, data_cessazione);

  // Aggiungi eventi onchange ai select per aggiornare lo stato dei campi in tempo reale
  selRuolo.onchange = function(e) {
    updateFieldStatus(selRuolo, ambulatorio, selTipo, data_cessazione);
  };

  selTipo.onchange = function(e) {
    updateFieldStatus(selRuolo, ambulatorio, selTipo, data_cessazione);
  };
});

// Funzione per controllare lo stato dei campi e abilitare/disabilitare in base ai select corrispondenti
function updateFieldStatus(selRuolo, ambulatorio, selTipo, data_cessazione) {

  // Se il ruolo è admin, svuota il campo dell'ambulatorio e disabilitatalo
  if (selRuolo.value === "admin") {
    ambulatorio.value = "";
    ambulatorio.disabled = true;
  // Altrimenti, abilita il campo dell'ambulatorio
  } else {
    ambulatorio.disabled = false;
  }
  // Se il tipo di contratto è "indeterminato", lascia il campo della data di cessazione vuoto ma abilitatalo
  if (selTipo.value === "indeterminato") {    
    data_cessazione.value = "";
    data_cessazione.disabled = true;
  // Altrimenti, abilita il campo della data di cessazione
  } else {    
    data_cessazione.disabled = false;
  }
}

</script>
</body>
</html>