<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID dall'input POST
$id = $_POST['id'];

// Disabilita l'autocommit per avviare la transazione
mysqli_autocommit($con, false);

// Query SQL per selezionare il tipo di contratto per l'utente specificato
$sql_contratto = "SELECT contratto.id_dipendente, tipo FROM contratto JOIN dipendente ON contratto.id_dipendente = dipendente.id_dipendente WHERE id_utente='$id'";
$query_contratto = mysqli_query($con, $sql_contratto);

// Verifica se la query è stata eseguita con successo
if($query_contratto) {
    // Ottieni i dettagli del contratto
    $row = mysqli_fetch_assoc($query_contratto);
    $tipo = $row['tipo'];
    $id_dipendente = $row['id_dipendente'];
    $data_cessazione = date('Y-m-d');
    
    // Aggiorna la data di cessazione del contratto per il dipendente
    $sql_dipendente = "UPDATE `contratto` SET  `data_cessazione`= '$data_cessazione' WHERE id_dipendente='$id_dipendente'";
    $query_dipendente = mysqli_query($con, $sql_dipendente);
} else {
    // Se la query non è stata eseguita con successo, esegui il rollback della transazione
    mysqli_rollback($con);
    // Restituisce un messaggio di errore in formato JSON
    $data = array(
        'status' => 'false',
    );
    echo json_encode($data);
} 

// Verifica se entrambe le query sono state eseguite con successo
if($query_dipendente && $query_contratto) {
    // Se entrambe le query sono state eseguite con successo, esegui il commit della transazione
    mysqli_commit($con); 
    // Restituisce uno stato di successo in formato JSON
    $data = array(
        'status' => 'true',
    );
    echo json_encode($data);
} else {
    // Se una delle query non è stata eseguita con successo, esegui il rollback della transazione
    mysqli_rollback($con);
    // Restituisce un messaggio di errore in formato JSON
    $data = array(
        'status' => 'false',
    );
    echo json_encode($data);
} 
?>
