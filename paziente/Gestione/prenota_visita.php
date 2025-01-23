<?php
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera l'id del paziente dalla sessione
$id_paziente = $_SESSION['id_paziente'];

// Ottieni i dati inviati tramite POST
$data = $_POST['data'];
$ora_visita = $_POST['orario'];
$id_dipendente= $_POST['id_dipendente'];
$id_ambulatorio= $_POST['ambulatorio'];

// Controlla se la data della visita è precedente alla data di domani
if (strtotime($data) <= strtotime(date('Y-m-d'))) {
    $response = array(
        'status' => 'false',
        'message' => 'La data della visita non può essere precedente al giorno seguente alla data odierna'
    );
    echo json_encode($response);
    exit; 
}

$sql_verifica_ora = "SELECT * FROM visita WHERE id_paziente = '$id_paziente' AND stato='corso' AND data_visita = '$data' AND ora_visita = '$ora_visita'";
$query_verifica_ora = mysqli_query($con, $sql_verifica_ora);

if(mysqli_num_rows($query_verifica_ora) > 0) {
$response = array(
    'status' => 'false',
    'message' => "All'orario selezionato è già presente una visita da effettuare in un altro ambulatorio."
);
echo json_encode($response);
exit; 
}

// Calcola la data di inizio della settimana (lunedì) e la data di fine della settimana (domenica)
$inizio_settimana = date('Y-m-d', strtotime('last monday', strtotime($data)));
$fine_settimana = date('Y-m-d', strtotime('next sunday', strtotime($data)));

// Query per verificare se sono state prenotate altre visite nello stesso intervallo di una settimana
$sql_verifica = "SELECT * FROM visita WHERE id_paziente = '$id_paziente' AND id_ambulatorio = '$id_ambulatorio' AND stato='corso' AND data_visita BETWEEN '$inizio_settimana' AND '$fine_settimana' ";
$query_verifica = mysqli_query($con, $sql_verifica);

if(mysqli_num_rows($query_verifica) > 0) {

    // Il paziente ha già prenotato una visita per lo stesso ambulatorio nella stessa settimana
    $response = array(
        'status' => 'false',
        'message' => 'Il paziente ha già prenotato una visita per questo ambulatorio nella stessa settimana'
    );
    echo json_encode($response);
} else {
    // Il paziente può prenotare la visita

    // Query per inserire la prenotazione della visita nel database
    $sql_visita = "INSERT INTO visita (data_visita, ora_visita, id_dipendente, id_ambulatorio, id_paziente, stato) VALUES ('$data', '$ora_visita', '$id_dipendente', '$id_ambulatorio', '$id_paziente', 'corso')";
    $query_visita = mysqli_query($con, $sql_visita);

    if($query_visita) {
        // Prenotazione riuscita
        $response = array(
            'status' => 'true',
            'message' => 'Visita prenotata con successo'
        );
        echo json_encode($response);
    } else {
        // Errore nella prenotazione
        $response = array(
            'status' => 'false',
            'message' => 'Errore nella prenotazione'
        );
        echo json_encode($response);
    }
}
?>
