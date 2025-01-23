<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$ruolo = $_POST['ruolo'];
$ambulatorio = isset($_POST['ambulatorio']) ? $_POST['ambulatorio'] : NULL;
$stipendio = $_POST['stipendio'];
$contratto = $_POST['contratto'];
$data_cessazione = isset($_POST['data_cessazione']) ? $_POST['data_cessazione'] : NULL;
$id_dipendente = $_POST['id_dipendente'];
$id = $_POST['id'];

// Formatta la data di cessazione se è stata fornita
if ($data_cessazione != NULL){
    $timestamp = strtotime($data_cessazione);
    $data_formattata = date("Y-m-d", $timestamp);
}

// Disabilita l'autocommit per consentire il rollback in caso di errore
mysqli_autocommit($con, false);

// Aggiorna i dati dell'anagrafica del dipendente
$sql_anagrafica = "UPDATE `anagrafica` SET  `nome`='$nome' , `cognome`= '$cognome' WHERE id_utente='$id' ";
$query_anagrafica = mysqli_query($con, $sql_anagrafica);

// Se è stato specificato un ambulatorio, cerca il suo id nel database e aggiorna il ruolo e l'ambulatorio del dipendente
if ($ambulatorio!= NULL){
    $sql_id_ambulatorio = "SELECT id_ambulatorio FROM ambulatorio WHERE nome='$ambulatorio'";
    $query_id_ambulatorio = mysqli_query($con, $sql_id_ambulatorio);
    if($query_id_ambulatorio){
        $row = mysqli_fetch_assoc($query_id_ambulatorio);
        $id_ambulatorio = $row['id_ambulatorio'];
        $sql_dipendente = "UPDATE `dipendente` SET  `ruolo`='$ruolo' , `id_ambulatorio`= '$id_ambulatorio' WHERE id_utente='$id' ";
        $query_dipendente = mysqli_query($con, $sql_dipendente);
    }else{
        // Se si verifica un errore nella query, esegui il rollback e restituisce un messaggio di errore
        mysqli_rollback($con);
         $data = array(
            'status'=>'false',
        );
        echo json_encode($data);
    } 
} else {
    // Se non è stato specificato un ambulatorio, aggiorna solo il ruolo del dipendente
    $sql_dipendente = "UPDATE `dipendente` SET  `ruolo`='$ruolo' , `id_ambulatorio`= NULL WHERE id_utente='$id' ";
    $query_dipendente = mysqli_query($con, $sql_dipendente);
}

// Se è stata fornita una data di cessazione, aggiorna il contratto del dipendente con quella data
if ($data_cessazione!= NULL){
    $sql_contratto = "UPDATE `contratto` SET  `stipendio`='$stipendio' , `tipo`= '$contratto', `data_cessazione`= '$data_formattata' WHERE id_dipendente='$id_dipendente' ";
    $query_contratto= mysqli_query($con,$sql_contratto);
} else {
    // Altrimenti, aggiorna il contratto del dipendente senza data di cessazione
    $sql_contratto = "UPDATE `contratto` SET  `stipendio`='$stipendio' , `tipo`= '$contratto', `data_cessazione`= NULL WHERE id_dipendente='$id_dipendente' ";
    $query_contratto= mysqli_query($con,$sql_contratto);
}

// Se tutte le query hanno avuto successo, esegui il commit dei cambiamenti nel database
if($query_anagrafica && $query_dipendente && $query_contratto){
    mysqli_commit($con); 
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
} else {
    // Altrimenti, esegui il rollback e restituisce un messaggio di errore
    mysqli_rollback($con);
     $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 
?>