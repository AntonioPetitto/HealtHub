<?php 
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Cancella tutte le variabili di sessione
session_unset(); 

// Distrugge la sessione
session_destroy(); 
?>