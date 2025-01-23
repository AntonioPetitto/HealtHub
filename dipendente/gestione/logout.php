<?php 
// Include il file di configurazione del database
include('config.php');

// Inizia la sessione
session_start();

// Elimina tutte le variabili di sessione
session_unset(); 

// Distrugge la sessione corrente
session_destroy(); 
?>
