<?php
// Include il file di configurazione del database
include('config.php');

// Recupera i valori inviati tramite metodo POST dal modulo HTML
$email = $_POST['email'];
$password = $_POST['password'];
$data_registrazione = $_POST['data_registrazione'];
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

// Converte la data di registrazione in un formato compatibile con il database (YYYY-MM-DD)
$timestamp_registrazione = strtotime($data_registrazione);
$data_formattata_registrazione = date("Y-m-d", $timestamp_registrazione);

// Se è stata fornita una data di scadenza dell'assicurazione, la converte nel formato corretto
if ($numero_polizza != NULL){
    $timestamp_scadenza = strtotime($data_scadenza);
    $data_formattata_scadenza = date("Y-m-d", $timestamp_scadenza);
}

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Verifica se l'email è già presente nel database
$sql_check_email = "SELECT COUNT(*) AS count FROM utente WHERE email = '$email'";
$result_check_email = mysqli_query($con, $sql_check_email);
$row_check_email = mysqli_fetch_assoc($result_check_email);
if ($row_check_email['count'] > 0) {
    mysqli_rollback($con); // Annulla la transazione se l'email è già presente
    $data = array(
        'status'=>'false',
        'message'=>'Email già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Verifica se il codice fiscale è già presente nell'anagrafica
$sql_check_cf = "SELECT COUNT(*) AS count FROM anagrafica WHERE codice_fiscale = '$codice_fiscale'";
$result_check_cf = mysqli_query($con, $sql_check_cf);
$row_check_cf = mysqli_fetch_assoc($result_check_cf);
if ($row_check_cf['count'] > 0) {
    mysqli_rollback($con); // Annulla la transazione se il codice fiscale è già presente
    $data = array(
        'status'=>'false',
        'message'=>'Codice fiscale già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Verifica se la CIE è già presente nell'anagrafica
$sql_check_cie = "SELECT COUNT(*) AS count FROM anagrafica WHERE cie = '$cie'";
$result_check_cie = mysqli_query($con, $sql_check_cie);
$row_check_cie = mysqli_fetch_assoc($result_check_cie);
if ($row_check_cie['count'] > 0) {
    mysqli_rollback($con); // Annulla la transazione se la CIE è già presente
    $data = array(
        'status'=>'false',
        'message'=>'CIE già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Verifica se il telefono è già presente nell'anagrafica
$sql_check_telefono = "SELECT COUNT(*) AS count FROM anagrafica WHERE telefono = '$telefono'";
$result_check_telefono = mysqli_query($con, $sql_check_telefono);
$row_check_telefono = mysqli_fetch_assoc($result_check_telefono);
if ($row_check_telefono['count'] > 0) {
    mysqli_rollback($con); // Annulla la transazione se il telefono è già presente
    $data = array(
        'status'=>'false',
        'message'=>'Telefono già esistente nel database',
    );
    echo json_encode($data);
    exit;
}

// Inserisce l'utente nella tabella 'utente'
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$sql_utente = "INSERT INTO utente (email, pass, data_registrazione) VALUES ('$email', '$password_hash', '$data_formattata_registrazione')";
$query_utente = mysqli_query($con, $sql_utente);

// Se l'inserimento dell'utente ha successo, procede con l'inserimento nelle altre tabelle
if ($query_utente) {

    // Recupera l'id dell'utente appena inserito
    $id_utente = mysqli_insert_id($con);

    // Inserisce i dettagli personali dell'utente nella tabella 'anagrafica'
    $sql_anagrafica = "INSERT INTO anagrafica (codice_fiscale, cie, nome, cognome, telefono, data_nascita, nazionalità, città, sesso, indirizzo, id_utente) VALUES ('$codice_fiscale', '$cie', '$nome', '$cognome', '$telefono', '$data_nascita', '$nazionalita', '$città', '$sesso', '$indirizzo', '$id_utente')";
    $query_anagrafica = mysqli_query($con, $sql_anagrafica);

    // Inserisce l'utente come paziente nella tabella 'paziente'
    $sql_paziente = "INSERT INTO paziente (id_utente) VALUES ('$id_utente')";
    $query_paziente = mysqli_query($con, $sql_paziente);

    // Recupera l'id del paziente appena inserito
    $id_paziente = mysqli_insert_id($con);

    // Se è stata fornita un'assicurazione, verifica se è già presente
    if($numero_polizza != NULL && $query_paziente){
        // Verifica se il numero di polizza è già presente nel database
        $sql_check_assicurazione = "SELECT COUNT(*) AS count FROM assicurazione WHERE numero_polizza = '$numero_polizza'";
        $result_check_assicurazione = mysqli_query($con, $sql_check_assicurazione);
        $row_check_assicurazione = mysqli_fetch_assoc($result_check_assicurazione);
        if ($row_check_assicurazione['count'] > 0) {
            mysqli_rollback($con); // Annulla la transazione se il numero di polizza è già presente
            $data = array(
                'status'=>'false',
                'message'=>'Numero polizza già esistente nel database',
            );
            echo json_encode($data);
            exit;
        }
       
        // Inserisce i dettagli dell'assicurazione nella tabella 'assicurazione'
        $sql_assicurazione = "INSERT INTO assicurazione (numero_polizza, tipo, data_scadenza, id_paziente, id_compagnie) VALUES ('$numero_polizza', '$tipo', '$data_formattata_scadenza', '$id_paziente', '$id_compagnia')";
        $query_assicurazione = mysqli_query($con, $sql_assicurazione);
        
        // Se l'inserimento dell'assicurazione fallisce, annulla la transazione
        if(!$query_assicurazione){
            mysqli_rollback($con); 
            $data = array(
                'status'=>'false',
                'message'=>"Errore durante l'inserimento dell'assicurazione",
            );
            echo json_encode($data);
            exit;
        }
    }

    // Se tutte le operazioni hanno successo, conferma la transazione
    // e salva l'id dell'utente nella sessione
    if (($query_paziente && $query_anagrafica && $numero_polizza == NULL) || ($query_paziente && $query_anagrafica && $query_assicurazione)){
        mysqli_commit($con); 
        session_start();
        $_SESSION['id_utente'] = $id_utente;
        $data = array(
            'status'=>'true'
        );
        echo json_encode($data);
    } else {
        mysqli_rollback($con); // Annulla la transazione se qualcosa va storto
        $data = array(
            'status'=>'false',
            'message'=>"Errore durante l'inserimento dei dati",
        );
        echo json_encode($data);
    }
        
} else {
    mysqli_rollback($con); // Annulla la transazione se l'inserimento dell'utente fallisce
    $data = array(
        'status'=>'false',
        'message'=>"Errore durante l'inserimento dell'utente",
    );
    echo json_encode($data);
}
?>