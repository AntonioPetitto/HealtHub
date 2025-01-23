<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$email = $_POST['email'];
$password = $_POST['password'];
$data_registrazione = $_POST['data_registrazione'];
$id = $_POST['id'];

// Converti la data di registrazione nel formato corretto
$timestamp = strtotime($data_registrazione);
$data_formattata = date("Y-m-d", $timestamp);

// Disabilita l'autocommit per consentire le transazioni
mysqli_autocommit($con, false);

//ottiene l'hash della nuova password inserita dall'amministratore
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Query per aggiornare l'email, la password e la data di registrazione dell'utente
$sql_utente = "UPDATE `utente` SET  `email`='$email' , `pass`= '$password_hash', `data_registrazione`='$data_formattata' WHERE id_utente='$id' ";
$query_utente= mysqli_query($con,$sql_utente);

// Query per aggiornare il nome e il cognome nell'anagrafica dell'utente
$sql_anagrafica = "UPDATE `anagrafica` SET  `nome`='$nome' , `cognome`= '$cognome' WHERE id_utente='$id' ";
$query_anagrafica= mysqli_query($con,$sql_anagrafica);

// Se entrambe le query hanno successo, esegui il commit della transazione
if($query_utente && $query_anagrafica){
    mysqli_commit($con); 
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
} else {
    // In caso di errore in una delle query, esegui il rollback della transazione
    mysqli_rollback($con);
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 
?>