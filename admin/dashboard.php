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
<body>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Numero Dipendenti</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio dei dipendenti
                            $sql_ndipendenti = "SELECT COUNT(id_dipendente) as totale_dipendenti FROM dipendente";
                            $query_ndipendenti = mysqli_query($con, $sql_ndipendenti);
                            if ($query_ndipendenti){
                                $row = mysqli_fetch_assoc($query_ndipendenti);
                                $totale_dipendenti = $row['totale_dipendenti'];
                                echo $totale_dipendenti;
                            }else
                                echo"Errore nel trovare i dipendenti";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Numero Pazienti</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio dei pazienti
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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Numero Pazienti Assicurati</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio dei pazienti assicurati
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
                            // Query per il conteggio delle visite totali
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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite totali eseguite</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio delle visite eseguite
                            $sql_totvisite_fatte = "SELECT COUNT(id_visita) as totale_visite_fatte FROM visita WHERE stato='svolta'";
                            $query_totvisite_fatte = mysqli_query($con, $sql_totvisite_fatte);
                            if ($query_totvisite_fatte){
                                $row = mysqli_fetch_assoc($query_totvisite_fatte);
                                $totale_visite_fatte = $row['totale_visite_fatte'];
                                echo $totale_visite_fatte;
                            }else
                                echo"Errore nel trovare il totale dello stipendio";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite totali in corso</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio delle visite in corso
                            $sql_totvisite_corso = "SELECT COUNT(id_visita) as totale_visite_corso FROM visita WHERE stato='corso'";
                            $query_totvisite_corso = mysqli_query($con, $sql_totvisite_corso);
                            if ($query_totvisite_corso){
                                $row = mysqli_fetch_assoc($query_totvisite_corso);
                                $totale_visite_corso = $row['totale_visite_corso'];
                                echo $totale_visite_corso;
                            }else
                                echo"Errore nel trovare il totale dello stipendio";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Spese manodopera</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio delle spese
                            $sql_totstipendio = "SELECT SUM(stipendio) as totale_stipendio FROM contratto";
                            $query_totstipendio = mysqli_query($con, $sql_totstipendio);
                            if ($query_totstipendio){
                                $row = mysqli_fetch_assoc($query_totstipendio);
                                $totale_stipendio = $row['totale_stipendio'];
                                if ($totale_stipendio != NULL){
                                    echo $totale_stipendio . '€';
                                }else{
                                    echo '0€';
                                }
                            }else
                                echo"Errore nel trovare il totale dello stipendio";
                            ?>
                            </h5>      
                        </div> 
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite pagate</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio delle visite pagate
                            $sql_totimporto= "SELECT SUM(importo) as totale_importo FROM fattura WHERE pagato = 'si'";
                            $query_totimporto = mysqli_query($con, $sql_totimporto);
                            if ($query_totimporto){
                                $row = mysqli_fetch_assoc($query_totimporto);
                                $totale_importo = $row['totale_importo'];
                                if ($totale_importo != NULL){
                                    echo $totale_importo . '€';
                                }else{
                                    echo '0€';
                                }
                            }else
                                echo"Errore nel trovare il totale dell'importo";
                            ?>
                            </h5>      
                        </div> 
                    </div> 
                    <div class="col-md-3 mb-4">
                        <div class="card card-body p-3">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Visite coperte dall'assicurazione</p>
                            <h5 class="font-weight-bolder mb-0">
                            <?php 
                            // Query per il conteggio delle visite coperte dall'assicurazione
                            $sql_totimportocoperto = "SELECT SUM(importo) as totale_importo_coperto FROM fattura WHERE numero_polizza IS NOT NULL and pagato = 'si'";
                            $query_totimportocoperto = mysqli_query($con, $sql_totimportocoperto);
                            if ($query_totimportocoperto){
                                $row = mysqli_fetch_assoc($query_totimportocoperto);
                                $totale_importo_coperto = $row['totale_importo_coperto'];
                                if ($totale_importo_coperto != NULL){
                                    echo $totale_importo_coperto . '€';
                                }else{
                                    echo '0€';
                                }
                            }else
                                echo"Errore nel trovare il totale dell'importo coperto";
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