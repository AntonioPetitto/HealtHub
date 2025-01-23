<link rel="icon" type="image/png" href="/../assets/img/favicon.png">
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">

          <h6 class="font-weight-bolder mb-0"></h6>
        </nav>
            <li class="nav-item d-flex align-items-center">
              <a >
                <i id=InfUtente class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none" id="InformazioniUtentiNome"></span>
                <span class="d-sm-inline d-none" id="InformazioniUtentiCognome"></span>
            </div>
            </li>
      </div>
    </nav>

    <script>



</script>

<div class="modal fade" id="InformazioniUtenteModulo" tabindex="-1" aria-labelledby="InformazioniUtenteEtichetta" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="InformazioniUtenteModulo">Informazioni Utente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="InformazioniUtenti" action="">
            <div class="mb-3 row">
              <label for="InformazioniUtentiNome" class="col-md-3 form-label">Nome: </label>
              <div class="col-md-9">
                <span id="InformazioniUtentiNome"></span>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="InformazioniUtentiCognome" class="col-md-3 form-label">Cognome: </label>
              <div class="col-md-9">
                <span id="InformazioniUtentiCognome"></span>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="InformazioniUtentiEmail" class="col-md-3 form-label">Email: </label>
              <div class="col-md-9">
                <span id="InformazioniUtentiEmail"></span>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
        </div>
      </div>
    </div>
  </div>