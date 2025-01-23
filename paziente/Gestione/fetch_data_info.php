<?php
// Include il file di configurazione del database
include('config.php'); 

// Avvia la sessione
session_start(); 

// Ottieni l'ID dell'utente dalla variabile di sessione
$id_utente = $_SESSION['id_utente']; 

// Query per selezionare i dati anagrafici dell'utente dal database
$sql_anagrafica = "SELECT nome, cognome, sesso, codice_fiscale, cie, telefono, data_nascita, nazionalità, città, indirizzo FROM anagrafica WHERE id_utente='$id_utente'"; 
$query_anagrafica = mysqli_query($con, $sql_anagrafica); 

// Verifica se la query ha restituito dei risultati
if ($query_anagrafica && mysqli_num_rows($query_anagrafica) > 0) { 
    $data = mysqli_fetch_assoc($query_anagrafica); 
    echo json_encode($data); 
}
?>