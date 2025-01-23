<?php 
// Include il file di configurazione del database
include('config.php'); 

// Ottieni l'email e la password inviate tramite POST
$email = $_POST['email'];
$password = $_POST['password']; 

// Query per controllare se l'email e la password esistono nel database
$sql_controllo = "SELECT utente.id_utente, id_paziente, email, pass FROM utente JOIN paziente ON utente.id_utente = paziente.id_utente WHERE email='$email'";
$query_controllo = mysqli_query($con, $sql_controllo);

// Se la query restituisce una sola riga, l'autenticazione ha successo
if (mysqli_num_rows($query_controllo) == 1) {
    // Ottieni i dettagli dell'utente autenticato
    $row = mysqli_fetch_assoc($query_controllo);
    $password_hash = $row['pass'];
    if (password_verify($password, $password_hash)){
        $id_utente = $row['id_utente'];
        $id_paziente = $row['id_paziente'];

        // Avvia una nuova sessione se non è già attiva e distruggi eventuali sessioni precedenti
     
        session_start();
        session_unset();

        // Imposta le variabili di sessione per l'utente autenticato
        $_SESSION['id_paziente'] = $id_paziente;
        $_SESSION['id_utente'] = $id_utente;

        // Restituisce una risposta JSON con lo stato di autenticazione
        $data = array(
            'status' => 'true',
        );
        echo json_encode($data);
    } else {
        // Se l'autenticazione fallisce, restituisce un messaggio di errore
        $data = array(
            'status' => 'false',
            'message' => 'Email o password errati'
        );
        echo json_encode($data);
    }
} else {
    // Se l'autenticazione fallisce, restituisce un messaggio di errore
    $data = array(
        'status' => 'false',
        'message' => 'Email o password errati'
    );
    echo json_encode($data);
}
?>