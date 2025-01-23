<?php
// Include il file di configurazione del database
include('config.php');

// Recupera i valori inviati tramite metodo POST dal modulo 
$email = $_POST['email'];
$password = $_POST['password'];
$data_registrazione = $_POST['data_registrazione'];
$ruolo = $_POST['ruolo'];
$ambulatorio = isset($_POST['ambulatorio']) ? $_POST['ambulatorio'] : NULL;
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
$stipendio = $_POST['stipendio'];
$tipo = $_POST['tipo'];
$data_cessazione = isset($_POST['data_cessazione']) ? $_POST['data_cessazione'] : NULL;

// Converte la data di registrazione in un formato compatibile con il database (YYYY-MM-DD)
$timestamp_registrazione = strtotime($data_registrazione);
$data_formattata_registrazione = date("Y-m-d", $timestamp_registrazione);

// Converte la data di cessazione, se presente, in un formato compatibile con il database
if ($data_cessazione != NULL){
    $timestamp_cessazione = strtotime($data_cessazione);
    $data_formattata_cessazione = date("Y-m-d", $timestamp_cessazione);
}

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Verifica se l'email è già presente nel database
$sql_check_email = "SELECT COUNT(*) AS count FROM utente WHERE email = '$email'";
$result_check_email = mysqli_query($con, $sql_check_email);
$row_check_email = mysqli_fetch_assoc($result_check_email);
if ($row_check_email['count'] > 0) {
    mysqli_rollback($con); // Annulla la transazione in caso di errore
    $response = array(
        'status'=>'false',
        'message'=>'Email già esistente nel database',
    );
    echo json_encode($response);
    exit;
}

// Verifica se il codice fiscale è già presente nell'anagrafica
$sql_check_cf = "SELECT COUNT(*) AS count FROM anagrafica WHERE codice_fiscale = '$codice_fiscale'";
$result_check_cf = mysqli_query($con, $sql_check_cf);
$row_check_cf = mysqli_fetch_assoc($result_check_cf);
if ($row_check_cf['count'] > 0) {
    mysqli_rollback($con); 
    $response = array(
        'status'=>'false',
        'message'=>'Codice fiscale già esistente nel database',
    );
    echo json_encode($response);
    exit;
}

// Verifica se la CIE è già presente nell'anagrafica
$sql_check_cie = "SELECT COUNT(*) AS count FROM anagrafica WHERE cie = '$cie'";
$result_check_cie = mysqli_query($con, $sql_check_cie);
$row_check_cie = mysqli_fetch_assoc($result_check_cie);
if ($row_check_cie['count'] > 0) {
    mysqli_rollback($con); 
    $response = array(
        'status'=>'false',
        'message'=>'CIE già esistente nel database',
    );
    echo json_encode($response);
    exit;
}

// Verifica se il telefono è già presente nell'anagrafica
$sql_check_telefono = "SELECT COUNT(*) AS count FROM anagrafica WHERE telefono = '$telefono'";
$result_check_telefono = mysqli_query($con, $sql_check_telefono);
$row_check_telefono = mysqli_fetch_assoc($result_check_telefono);
if ($row_check_telefono['count'] > 0) {
    mysqli_rollback($con); 
    $response = array(
        'status'=>'false',
        'message'=>'Telefono già esistente nel database',
    );
    echo json_encode($response);
    exit;
}

// Inserisce l'utente nella tabella 'utente'
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$sql_utente = "INSERT INTO utente (email, pass, data_registrazione) VALUES ('$email', '$password_hash', '$data_formattata_registrazione')";
$query_utente = mysqli_query($con, $sql_utente);

if ($query_utente) {
    // Se l'inserimento dell'utente ha successo, recupera l'id dell'utente appena inserito
    $id_utente = mysqli_insert_id($con);

    // Inserisce i dettagli personali dell'utente nella tabella 'anagrafica'
    $sql_anagrafica = "INSERT INTO anagrafica (codice_fiscale, cie, nome, cognome, telefono, data_nascita, nazionalità, città, sesso, indirizzo, id_utente) VALUES ('$codice_fiscale', '$cie', '$nome', '$cognome', '$telefono', '$data_nascita', '$nazionalita', '$città', '$sesso', '$indirizzo', '$id_utente')";
    $query_anagrafica = mysqli_query($con, $sql_anagrafica);

    // Se l'utente è un dipendente, inserisce i dettagli del dipendente nella tabella 'dipendente'
    if ($ambulatorio != NULL){
        $sql_dipendente = "INSERT INTO dipendente (ruolo, id_utente, id_ambulatorio) VALUES ('$ruolo', '$id_utente', '$ambulatorio')";
        $query_dipendente = mysqli_query($con, $sql_dipendente);
    } else {
        $sql_dipendente = "INSERT INTO dipendente (ruolo, id_utente) VALUES ('$ruolo', '$id_utente')";
        $query_dipendente = mysqli_query($con, $sql_dipendente);  
    }
        
    // Recupera l'id del dipendente appena inserito
    $id_dipendente = mysqli_insert_id($con);

    // Inserisce i dettagli del contratto del dipendente nella tabella 'contratto'
    if ($tipo == "determinato"){
        $sql_contratto = "INSERT INTO contratto (stipendio, tipo, data_cessazione, id_dipendente) VALUES ('$stipendio', '$tipo', '$data_formattata_cessazione', '$id_dipendente')";
        $query_contratto = mysqli_query($con, $sql_contratto);
    } else {
        $sql_contratto = "INSERT INTO contratto (stipendio, tipo, data_cessazione, id_dipendente) VALUES ('$stipendio', '$tipo', NULL, '$id_dipendente')";
        $query_contratto = mysqli_query($con, $sql_contratto);
    }

    // Se tutte le operazioni hanno successo, conferma la transazione e restituisce uno stato 'true'
    if ($query_dipendente && $query_anagrafica && $query_contratto) {
        mysqli_commit($con); 
        $response = array(
            'status'=>'true',
        );
        echo json_encode($response);
    } else {
        // Se una delle operazioni fallisce, esegue il rollback della transazione e restituisce uno stato 'false'
        mysqli_rollback($con); 
        $response = array(
            'status'=>'false',
            'message'=>'Errore nell\'inserimento dei dati',
        );
        echo json_encode($response);
    }
} else {
    // Se l'inserimento dell'utente fallisce, esegue il rollback della transazione e restituisce uno stato 'false'
    mysqli_rollback($con);
    $response = array(
        'status'=>'false',
        'message'=>'Errore nell\'inserimento dell\'utente',
    );
    echo json_encode($response);
}
?>
