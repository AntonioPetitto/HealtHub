<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$numero_polizza = $_POST['numero_polizza'];
$data_scadenza = isset($_POST['data_scadenza']) ? $_POST['data_scadenza'] : NULL;
$nome_compagnia = isset($_POST['nome_compagnia']) ? $_POST['nome_compagnia'] : NULL;
$id_paziente = $_POST['id_paziente'];
$id = $_POST['id'];

// Formatta la data di scadenza se è stata fornita
if ($data_scadenza != NULL){
    $timestamp = strtotime($data_scadenza);
    $data_formattata = date("Y-m-d", $timestamp);
}

// Disabilita l'autocommit per consentire il rollback in caso di errore
mysqli_autocommit($con, false);

// Inizializza l'id della compagnia assicurativa
$id_compagnia = NULL;

// Se è stata fornita una compagnia assicurativa, cerca il suo id nel database
if($nome_compagnia != NULL){
    $sql_id_compagnia = "SELECT id_compagnie FROM compagnie_assicurative WHERE nome='$nome_compagnia'";
    $query_id_compagnia = mysqli_query($con, $sql_id_compagnia);

    if ($query_id_compagnia) {
        // Controlla se ci sono risultati
        if(mysqli_num_rows($query_id_compagnia) > 0) {
            $row = mysqli_fetch_assoc($query_id_compagnia);
            $id_compagnia = $row['id_compagnie'];   
        } else {
            // Se non ci sono risultati, esegui il rollback e restituisce un messaggio di errore
            mysqli_rollback($con); 
            $data = array(
                'status'=>'false',
            );
            echo json_encode($data);
        }
    }
}

// Aggiorna i dati dell'anagrafica del paziente
$sql_anagrafica = "UPDATE `anagrafica` SET  `nome`='$nome' , `cognome`= '$cognome' WHERE id_utente='$id' ";
$query_anagrafica = mysqli_query($con, $sql_anagrafica);

// Aggiorna o elimina i dati relativi all'assicurazione del paziente
if ($tipo != NULL || $data_scadenza != NULL|| $nome_compagnia != NULL){
    $sql_assicurazione = "UPDATE `assicurazione` SET  `tipo`= '$tipo' , `data_scadenza`= '$data_scadenza' , `id_compagnie`= '$id_compagnia' WHERE numero_polizza='$numero_polizza'";
    $query_assicurazione = mysqli_query($con, $sql_assicurazione);
} else {
    $sql_assicurazione = "DELETE FROM assicurazione WHERE numero_polizza='$numero_polizza'";
    $query_assicurazione = mysqli_query($con, $sql_assicurazione);
}

// Se entrambe le query hanno avuto successo, esegui il commit dei cambiamenti nel database
if($query_anagrafica && $query_assicurazione){
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