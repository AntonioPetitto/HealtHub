<?php 
// e il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$email = $_POST['email'];
$password = $_POST['password'];
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$telefono = $_POST['telefono'];
$codice_fiscale = $_POST['codice_fiscale'];
$cie = $_POST['cie'];
$data_nascita = $_POST['data_nascita'];
$sesso = $_POST['sesso'];
$nazionalita = $_POST['nazionalita'];
$città = $_POST['città'];
$indirizzo = $_POST['indirizzo'];
$assicurazione = $_POST['assicurazione'];
$numero_polizza = isset($_POST['numero_polizza']) ? $_POST['numero_polizza'] : NULL;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : NULL;
$data_scadenza = isset($_POST['data_scadenza']) ? $_POST['data_scadenza'] : NULL;
$id_compagnia = isset($_POST['compagnia']) ? $_POST['compagnia'] : NULL;

// Ottieni la data corrente formattata per la registrazione
$data_formattata_registrazione = date("Y-m-d");

// Se è stata fornita una data di scadenza, formattala correttamente
if ($data_scadenza != NULL){
    $timestamp_scadenza = strtotime($data_scadenza);
    $data_formattata_scadenza = date("Y-m-d", $timestamp_scadenza);
}

// Disabilita l'autocommit per avviare una transazione
mysqli_autocommit($con, false);

// Controlla se l'email è già presente nel database
$sql_check_email = "SELECT COUNT(*) AS count FROM utente WHERE email = '$email'";
$result_check_email = mysqli_query($con, $sql_check_email);
$row_check_email = mysqli_fetch_assoc($result_check_email);
if ($row_check_email['count'] > 0) {
    mysqli_rollback($con); 
    $data = array(
        'status' => 'false',
        'message' => 'Email già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Controlla se il codice fiscale è già presente nell'anagrafica
$sql_check_cf = "SELECT COUNT(*) AS count FROM anagrafica WHERE codice_fiscale = '$codice_fiscale'";
$result_check_cf = mysqli_query($con, $sql_check_cf);
$row_check_cf = mysqli_fetch_assoc($result_check_cf);
if ($row_check_cf['count'] > 0) {
    mysqli_rollback($con); 
    $data = array(
        'status' => 'false',
        'message' => 'Codice fiscale già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Controlla se la CIE è già presente nell'anagrafica
$sql_check_cie = "SELECT COUNT(*) AS count FROM anagrafica WHERE cie = '$cie'";
$result_check_cie = mysqli_query($con, $sql_check_cie);
$row_check_cie = mysqli_fetch_assoc($result_check_cie);
if ($row_check_cie['count'] > 0) {
    mysqli_rollback($con); 
    $data = array(
        'status' => 'false',
        'message' => 'CIE già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Controlla se il telefono è già presente nell'anagrafica
$sql_check_telefono = "SELECT COUNT(*) AS count FROM anagrafica WHERE telefono = '$telefono'";
$result_check_telefono = mysqli_query($con, $sql_check_telefono);
$row_check_telefono = mysqli_fetch_assoc($result_check_telefono);
if ($row_check_telefono['count'] > 0) {
    mysqli_rollback($con); 
    $data = array(
        'status' => 'false',
        'message' => 'Telefono già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
// Inserisce i dati dell'utente nella tabella "utente"
$sql_utente = "INSERT INTO utente (email, pass, data_registrazione) VALUES ('$email', '$password_hash', '$data_formattata_registrazione')";
$query_utente = mysqli_query($con, $sql_utente);

// Se l'inserimento dell'utente ha successo, procedi con l'inserimento dei dati nell'anagrafica e nel record del paziente
if ($query_utente) {

    // Ottieni l'ID dell'utente appena inserito
    $id_utente = mysqli_insert_id($con);

    // Inserisce i dati dell'anagrafica nella tabella "anagrafica"
    $sql_anagrafica = "INSERT INTO anagrafica (codice_fiscale, cie, nome, cognome, telefono, data_nascita, nazionalità, città, sesso, indirizzo, id_utente) VALUES ('$codice_fiscale', '$cie', '$nome', '$cognome', '$telefono', '$data_nascita', '$nazionalita', '$città', '$sesso', '$indirizzo', '$id_utente')";
    $query_anagrafica = mysqli_query($con, $sql_anagrafica);

    // Inserisce un record per il paziente nella tabella "paziente"
    $sql_paziente = "INSERT INTO paziente (id_utente) VALUES ('$id_utente')";
    $query_paziente = mysqli_query($con, $sql_paziente);

    $id_paziente = mysqli_insert_id($con);

    // Se è stata fornita un'assicurazione, verifica e inserisce i dati dell'assicurazione
    if($numero_polizza != NULL && $query_paziente){
        // Controlla se il numero di polizza è già presente nel database
        $sql_check_assicurazione = "SELECT COUNT(*) AS count FROM assicurazione WHERE numero_polizza = '$numero_polizza'";
        $result_check_assicurazione = mysqli_query($con, $sql_check_assicurazione);
        $row_check_assicurazione = mysqli_fetch_assoc($result_check_assicurazione);
        if ($row_check_assicurazione['count'] > 0) {
            mysqli_rollback($con); 
            $data = array(
                'status' => 'false',
                'message' => 'Numero polizza già esistente nel database',
            );
            echo json_encode($data);
            exit;
        }
       
        // Inserisce i dati dell'assicurazione nella tabella "assicurazione"
        $sql_assicurazione = "INSERT INTO assicurazione (numero_polizza, tipo, data_scadenza, id_paziente, id_compagnie) VALUES ('$numero_polizza', '$tipo', '$data_formattata_scadenza', '$id_paziente', '$id_compagnia')";
        $query_assicurazione = mysqli_query($con, $sql_assicurazione);
        if(!$query_assicurazione){
            mysqli_rollback($con); 
            $data = array(
                'status' => 'false',
                'message' => "Errore durante l'inserimento dell'assicurazione",
            );
            echo json_encode($data);
            exit;
        }
    }

    // Se tutti gli inserimenti hanno successo, conferma la transazione e avvia una sessione per l'utente
    if (($query_paziente && $query_anagrafica && $numero_polizza == NULL) || ($query_paziente && $query_anagrafica && $query_assicurazione)){
        mysqli_commit($con); 

        // Avvia una nuova sessione per l'utente
        session_start();
        session_unset();

        // Imposta l'ID dell'utente nella sessione
        $_SESSION['id_utente'] = $id_utente;
        $_SESSION['id_paziente'] = $id_paziente;
        
        // Restituisce uno stato di successo
        $data = array(
            'status' => 'true'
        );
        echo json_encode($data);
    } else {
        // Se c'è un errore durante l'inserimento dei dati, esegui il rollback della transazione
        mysqli_rollback($con); 
        $data = array(
            'status' => 'false',
            'message' => "Errore durante l'inserimento dei dati",
        );
        echo json_encode($data);
    }
        
} else {
    // Se c'è un errore durante l'inserimento dell'utente, esegui il rollback della transazione
    mysqli_rollback($con);
    $data = array(
        'status' => 'false',
        'message' => "Errore durante l'inserimento dell'utente",
    );
    echo json_encode($data);
}
?>