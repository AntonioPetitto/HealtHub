<?php
// Stabilisce una connessione al database MySQL utilizzando i dettagli di accesso specificati
$con  = mysqli_connect('localhost','root','','healthub');

// Controlla se si è verificato un errore durante la connessione
if(mysqli_connect_errno()) {
    // Se si è verificato un errore, stampa un messaggio di errore
    echo 'Database Connection Error';
}
?>