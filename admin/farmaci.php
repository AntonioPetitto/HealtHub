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
  <title>Lista farmaci</title>
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
          <h4>Gestione Farmaci</h4>
          <div class="btnAdd">
            <!-- Pulsante per aggiungere un farmaco -->
            <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#AggiungiFarmacoModulo" class="btn bg-gradient-primary text-dark btn-sm">Aggiungi farmaco</a>
          </div>
          <div class="card-body">
            <!-- Tabella -->
            <table id="Tabella" class="table table-bordered table-striped text-center align-middle table-responsive">
              <thead>
                <th width="5%">ID farmaco</th>
                <th width="5%">Nome</th>
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
      'url': 'gestione/fetch_data_farmaco.php',
      'type': 'post',
    },
    "aoColumnDefs": [{
      "bSortable": false,
      "aTargets": [2]
    },
    ],
    "language": {
      "url": '../assets/js/Datatable_italiano.json',
    }
  });
});

// Gestione dell'invio del modulo per l'aggiunta di un farmaco tramite AJAX
$(document).on('submit', '#AggiungiFarmaco', function(event) {
  event.preventDefault();
  var id_farmaco = $('#AggiungiIdCampo').val();
  var nome = $('#AggiungiNomeCampo').val();
  if (id_farmaco != '' && nome != '' ) {
    $.ajax({
      url: "gestione/aggiungi_farmaco.php",
      type: "post",
      data: {
        id_farmaco : id_farmaco,
        nome : nome
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        var message = json.message;
        if (status == 'true') {
          tabella = $('#Tabella').DataTable();
          tabella.draw();
          alert(message);
          $('#AggiungiFarmacoModulo').modal('hide');
        } else {
          alert(message);
        }
      }
    });
  } else {
    alert('Riempi tutti i campi richiesti');
  }
});

// Gestione dell'invio del modulo per modificare un farmaco tramite AJAX
$(document).on('submit', '#ModificaFarmaco', function(event) {
  event.preventDefault();
  var nome = $('#ModificaNomeCampo').val();
  var trid = $('#trid').val();
  var id = $('#id').val();
  if (nome != '') {
    $.ajax({
      url: "gestione/modifica_farmaco.php",
      type: "post",
      data: {
        nome : nome,
        id: id,
      },
      success: function(data) {
        var json = JSON.parse(data);
        var status = json.status;
        if (status == 'true') {
          tabella = $('#Tabella').DataTable();
          var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn bg-gradient-info btn-sm editbtn">Modifica</a>  <a href="#!"  data-id="' + id + '"  class="btn bg-gradient-danger btn-sm deleteBtn">Elimina</a></td>';
          var riga = tabella.row("[id='" + trid + "']");
          riga.data("[id='" + trid + "']").data([id, nome, button]);
          $('#ModificaFarmacoModulo').modal('hide');
        } else {
          alert('failed');
        }
      }
    });
  } else {
    alert('Riempi tutti i campi richiesti');
  }
});

// Gestione del click sul pulsante di modifica di un farmaco tramite AJAX
$('#Tabella').on('click', '.editbtn ', function(event) {
  var tabella = $('#Tabella').DataTable();
  var trid = $(this).closest('tr').attr('id');
  var id = $(this).data('id');
  $('#ModificaFarmacoModulo').modal('show');

  $.ajax({
    url: "gestione/singola_riga_farmaco.php",
    type: 'post',
    data: {
      id: id
    },
    success: function(data) {
      var json = JSON.parse(data);
      $('#ModificaNomeCampo').val(json.nome);
      $('#id').val(id);
      $('#trid').val(trid);
    }
  })
});

//Gestione del click elimina per eliminare un farmaco tramite AJAX
$(document).on('click', '.deleteBtn', function(event) {
  event.preventDefault();
  var tabella = $('#Tabella').DataTable();
  var id = $(this).data('id');
  if (confirm("Sei sicuro di voler eliminare questo farmaco? ")) {
    $.ajax({
      url: "gestione/elimina_farmaco.php",
      type: "post",
      data: {
        id: id
      },
      success: function(data) {
        var json = JSON.parse(data);
        status = json.status;
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

<!-- Modulo per aggiungere un farmaco -->
<div class="modal fade" id="AggiungiFarmacoModulo" tabindex="-1" aria-labelledby="AggiungiFarmacoEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AggiungiFarmacoLabel">Aggiungi farmaco</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="AggiungiFarmaco" action="">
          <div class="mb-3 row">
            <label for="AggiungiIdCampo" class="col-md-3 form-label">Id farmaco</label>
              <div class="col-md-9">
                <input type="number" class="form-control" id="AggiungiIdCampo" name="id_farmaco">
              </div>
          </div>
          <div class="mb-3 row">
              <label for="AggiungiNomeCampo" class="col-md-3 form-label">nome</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="AggiungiNomeCampo" name="nome">
              </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Inserisci</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

<!--Modulo per modificare un farmaco-->
<div class="modal fade" id="ModificaFarmacoModulo" tabindex="-1" aria-labelledby="ModificafarmacoEtichetta" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModificaFarmacoLabel">Aggiungi farmaco</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="ModificaFarmaco" action="">
          <input type="hidden" name="id" id="id" value=""> 
          <input type="hidden" name="trid" id="trid" value=""> 
          <div class="mb-3 row">
            <label for="ModificaNomeCampo" class="col-md-3 form-label">nome</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="ModificaNomeCampo" name="nome">
            </div>
          </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Inserisci</button>
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