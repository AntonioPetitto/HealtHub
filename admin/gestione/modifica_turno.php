<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$data = $_POST['data'];
$lunedì_inizio = $_POST['lunedì_inizio'];
$martedì_inizio = $_POST['martedì_inizio'];
$mercoledì_inizio = $_POST['mercoledì_inizio'];
$giovedì_inizio = $_POST['giovedì_inizio'];
$venerdì_inizio = $_POST['venerdì_inizio'];
$sabato_inizio = $_POST['sabato_inizio'];
$domenica_inizio = $_POST['domenica_inizio'];
$lunedì_fine = $_POST['lunedì_fine'];
$martedì_fine = $_POST['martedì_fine'];
$mercoledì_fine = $_POST['mercoledì_fine'];
$giovedì_fine = $_POST['giovedì_fine'];
$venerdì_fine = $_POST['venerdì_fine'];
$sabato_fine = $_POST['sabato_fine'];
$domenica_fine = $_POST['domenica_fine'];
$id_calendario = $_POST['id_calendario'];
$id_dipendente = $_POST['id'];

// Ottieni il mese e l'anno dalla data fornita
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));
// Ottieni il numero della settimana dalla data fornita
$settimana = date('W', strtotime($data));
// Ottieni la data odierna
$data_odierna = date('Y-m-d');

// Disabilita l'autocommit per consentire le transazioni
mysqli_autocommit($con, false);

// Funzione per aggiornare l'orario di un giorno specifico
function aggiornaOrario($giorno, $inizio, $fine, $id_calendario, $id_dipendente, $con) {
    $sql = "UPDATE `turno` SET `ora_inizio`= '$inizio', `ora_fine`='$fine' WHERE giorno = '$giorno' AND id_calendario = '$id_calendario' AND id_dipendente = '$id_dipendente'";
    $query = mysqli_query($con, $sql);
    if (!$query) {
        mysqli_rollback($con);
        $data = array(
            'status'=>'false',
        );
        echo json_encode($data);
        exit; // Termina lo script se il query fallisce
    }
}

// Aggiorna l'orario per ciascun giorno della settimana, se fornito
if ($lunedì_inizio != "" || $lunedì_fine != ""){
    aggiornaOrario('lunedì', $lunedì_inizio, $lunedì_fine, $id_calendario, $id_dipendente, $con);
}

if ($martedì_inizio != "" || $martedì_fine != ""){
    aggiornaOrario('martedì', $martedì_inizio, $martedì_fine, $id_calendario, $id_dipendente, $con);
}

if ($mercoledì_inizio != "" || $mercoledì_fine != ""){
    aggiornaOrario('mercoledì', $mercoledì_inizio, $mercoledì_fine, $id_calendario, $id_dipendente, $con);
}

if ($giovedì_inizio != "" || $giovedì_fine != ""){
    aggiornaOrario('giovedì', $giovedì_inizio, $giovedì_fine, $id_calendario, $id_dipendente, $con);
}

if ($venerdì_inizio != "" || $venerdì_fine != ""){
    aggiornaOrario('venerdì', $venerdì_inizio, $venerdì_fine, $id_calendario, $id_dipendente, $con);
}

if ($sabato_inizio != "" || $sabato_fine != ""){
    aggiornaOrario('sabato', $sabato_inizio, $sabato_fine, $id_calendario, $id_dipendente, $con);
}

if ($domenica_inizio != "" || $domenica_fine != ""){
    aggiornaOrario('domenica', $domenica_inizio, $domenica_fine, $id_calendario, $id_dipendente, $con);
}

// Se tutte le query sono andate a buon fine, esegui il commit della transazione
mysqli_commit($con); 
$data = array(
    'status'=>'true',
);
echo json_encode($data);
?>