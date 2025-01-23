<?php
// Include il file di configurazione del database
include('config.php'); 

// Avvia la sessione 
session_start(); 

// Ottieni l'ID del paziente dalla variabile di sessione
$id_paziente = $_SESSION['id_paziente']; 

// Query per selezionare i dettagli dell'assicurazione del paziente dal database
$sql_assicurazione = "SELECT nome, telefono, email, numero_polizza, tipo, DATE_FORMAT(data_scadenza, '%d/%m/%Y') AS data_scadenza FROM assicurazione JOIN compagnie_assicurative on assicurazione.id_compagnie = compagnie_assicurative.id_compagnie WHERE id_paziente='$id_paziente'";
$query_assicurazione = mysqli_query($con, $sql_assicurazione); 

// Verifica se la query è stata eseguita con successo e se ha restituito almeno una riga di risultato
if ($query_assicurazione && mysqli_num_rows($query_assicurazione) > 0) {
    $data = mysqli_fetch_assoc($query_assicurazione); 
    echo json_encode($data); 
}
?>