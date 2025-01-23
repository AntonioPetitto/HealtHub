<?php 
include('includes/header.php'); 
include('gestione/config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="assets/stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
  <title>Dashboard</title>
</head>
<style>
    .card {
    height: 100%; 
    overflow: auto; 
    }
</style>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Numero Pazienti</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            $sql_npazienti = "SELECT COUNT(id_paziente) as totale_pazienti FROM paziente";
                            $query_npazienti = mysqli_query($con, $sql_npazienti);
                            if ($query_npazienti){
                                $row = mysqli_fetch_assoc($query_npazienti);
                                $totale_pazienti = $row['totale_pazienti'];
                                echo $totale_pazienti;
                            }else
                                echo"Errore nel trovare i pazienti";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4 ">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Pazienti Assicurati</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            $sql_npazienti_assicurati = "SELECT COUNT(id_paziente) as totale_pazienti_assicurati FROM assicurazione";
                            $query_npazienti_assicurati = mysqli_query($con, $sql_npazienti_assicurati);
                            if ($query_npazienti_assicurati){
                                $row = mysqli_fetch_assoc($query_npazienti_assicurati);
                                $totale_pazienti_assicurati = $row['totale_pazienti_assicurati'];
                                echo $totale_pazienti_assicurati;
                            }else
                                echo"Errore nel trovare i pazienti";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite totali</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            $sql_totvisite = "SELECT COUNT(id_visita) as totale_visite FROM visita";
                            $query_totvisite = mysqli_query($con, $sql_totvisite);
                            if ($query_totvisite){
                                $row = mysqli_fetch_assoc($query_totvisite);
                                $totale_visite = $row['totale_visite'];
                                echo $totale_visite;
                            }else
                                echo"Errore nel trovare il totale dello stipendio";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite totali fatte</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            $sql_totvisite_fatte = "SELECT COUNT(id_visita) as totale_visite_fatte FROM visita WHERE stato='svolta'";
                            $query_totvisite_fatte = mysqli_query($con, $sql_totvisite_fatte);
                            if ($query_totvisite_fatte){
                                $row = mysqli_fetch_assoc($query_totvisite_fatte);
                                $totale_visite_fatte = $row['totale_visite_fatte'];
                                echo $totale_visite_fatte;
                            }else
                                echo"Errore nel trovare il totale delle visite fatte";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite totali in corso</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            $sql_totvisite_corso = "SELECT COUNT(id_visita) as totale_visite_corso FROM visita WHERE stato='corso'";
                            $query_totvisite_corso = mysqli_query($con, $sql_totvisite_corso);
                            if ($query_totvisite_corso){
                                $row = mysqli_fetch_assoc($query_totvisite_corso);
                                $totale_visite_corso = $row['totale_visite_corso'];
                                echo $totale_visite_corso;
                            }else
                                echo"Errore nel trovare il totale delle visite in corso";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Stipendio</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php
                                if(isset($_SESSION['id_utente'])) {
                                    $id_utente = $_SESSION['id_utente'];

                                // Query per ottenere l'ID dipendente associato all'ID utente
                                $sql_id_dipendente = "SELECT id_dipendente FROM dipendente WHERE id_utente = $id_utente";
                                $query_id_dipendente = mysqli_query($con, $sql_id_dipendente);

                                    if($query_id_dipendente && mysqli_num_rows($query_id_dipendente) > 0) {
                                        $row = mysqli_fetch_assoc($query_id_dipendente);
                                        $id_dipendente = $row['id_dipendente'];

                                    // Abbiamo l'ID del dipendente, possiamo utilizzarlo per ottenere il suo stipendio
                                    $sql_stipendio_dipendente = "SELECT stipendio FROM contratto WHERE id_dipendente = $id_dipendente";
                                    $query_stipendio_dipendente = mysqli_query($con, $sql_stipendio_dipendente);

                                    if($query_stipendio_dipendente && mysqli_num_rows($query_stipendio_dipendente) > 0) {
                                        $row = mysqli_fetch_assoc($query_stipendio_dipendente);
                                        $stipendio_dipendente = $row['stipendio'];
                                        echo $stipendio_dipendente;
                                        } else {
                                            echo "Errore nel trovare lo stipendio del dipendente.";
                                        }
                                            } else {
                                                echo "ID dipendente non trovato.";
                                            }
                                                    } else {
                                                    echo "ID utente non trovato nella sessione.";
                                                    }
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Contratto</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php
                                if(isset($_SESSION['id_utente'])) {
                                    $id_utente = $_SESSION['id_utente'];

                                // Query per ottenere il tipo di contratto e la data di cessazione per il dipendente corrente tramite un inner join
                                 $sql_contratto = "SELECT c.tipo, c.data_cessazione 
                                                   FROM contratto c
                                                   INNER JOIN dipendente d ON c.id_dipendente = d.id_dipendente
                                                   INNER JOIN utente u ON d.id_utente = u.id_utente
                                                   WHERE u.id_utente = $id_utente";
                                                   
                                $query_contratto = mysqli_query($con, $sql_contratto);

                                    if($query_contratto && mysqli_num_rows($query_contratto) > 0) {
                                        while($row = mysqli_fetch_assoc($query_contratto)) {
                                            $tipo_contratto = $row['tipo'];
                                            $data_cessazione = $row['data_cessazione'];
                                            echo $tipo_contratto . "<br>";
                                            echo $data_cessazione . "<br>";
                                            }
                                    } else {
                                        echo "Non è stato trovato un contratto per il dipendente corrente.<br>";
                                    }
                                    } else {
                                        echo "ID utente non trovato nella sessione.<br>";
                                    }
                            ?>
                            </h5>      
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>