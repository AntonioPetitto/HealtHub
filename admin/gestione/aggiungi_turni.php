<?php
// Include il file di configurazione del database
include('config.php');

// Recupera la data inviata tramite metodo POST
$data = $_POST['data'];

// Ottiene il mese e l'anno dalla data fornita
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));

// Ottiene il numero della settimana dall'anno dalla data fornita
$settimana = date('W', strtotime($data));

// Ottiene la data odierna nel formato corretto per il database (YYYY-MM-DD)
$data_odierna = date('Y-m-d');

// Array dei giorni della settimana
$giorni = array(
    'lunedì',
    'martedì',
    'mercoledì',
    'giovedì',
    'venerdì',
    'sabato',
    'domenica'
);

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Verifica se esiste già un record per questa settimana, mese e anno nella tabella dei calendari
$sql_check_calendario = "SELECT id_calendario FROM calendario WHERE settimana = '$settimana' AND mese = '$mese' AND anno = '$anno'";
$query_check_calendario = mysqli_query($con, $sql_check_calendario);

if (mysqli_num_rows($query_check_calendario) > 0) {
    // Se esiste già un record, restituisce un messaggio di errore
    mysqli_rollback($con);
    $data = array(
        'status' => 'false',
        'message' => 'Esiste già un calendario per questa settimana, mese e anno',
    );
    echo json_encode($data);
} else {
    // Altrimenti, procede con l'inserimento del calendario e dei turni
    $sql_calendario = "INSERT INTO calendario (settimana, mese, anno) VALUES ('$settimana', '$mese', '$anno')";
    $query_calendario = mysqli_query($con, $sql_calendario);
    $id_calendario = mysqli_insert_id($con);

    if ($query_calendario) {
        // Se l'inserimento del calendario ha successo, seleziona i dipendenti attivi
        $sql_dipendente = "SELECT dipendente.id_dipendente FROM uteana JOIN dipendente on uteana.id_utente = dipendente.id_utente JOIN contratto on dipendente.id_dipendente = contratto.id_dipendente WHERE ((data_cessazione > '$data_odierna') OR (contratto.tipo = 'indeterminato' AND data_cessazione IS NULL)) AND ruolo != 'admin' ";
        $query_dipendente = mysqli_query($con, $sql_dipendente);

        if ($query_dipendente) {
            while ($riga = mysqli_fetch_assoc($query_dipendente)) {
                // Per ogni dipendente attivo, inserisce un turno per ogni giorno della settimana
                $id_dipendente = $riga['id_dipendente'];

                foreach ($giorni as $giorno) {
                    $sql_turno = "INSERT INTO turno (id_dipendente, id_calendario, giorno) VALUES ('$id_dipendente', '$id_calendario', '$giorno')";
                    $query_turno = mysqli_query($con, $sql_turno);

                    if (!$query_turno) {
                        // Se l'inserimento del turno fallisce, annulla la transazione e restituisce un messaggio di errore
                        mysqli_rollback($con);
                        $data = array(
                            'status' => 'false',
                            'message' => "Errore durante l'inserimento dei turni",
                        );
                        echo json_encode($data);
                        exit(); // Esci dallo script in caso di errore
                    }
                }
            }
            // Se tutti i turni vengono inseriti con successo, conferma la transazione e restituisce un messaggio di successo
            mysqli_commit($con);
            $data = array(
                'status' => 'true',
                'message' => "Turni inseriti con successo",
            );
            echo json_encode($data);
        }
    } else {
        // Se l'inserimento del calendario fallisce, annulla la transazione e restituisce un messaggio di errore
        mysqli_rollback($con);
        $data = array(
            'status' => 'false',
            'message' => "Errore durante l'inserimento del calendario",
        );
        echo json_encode($data);
    }
}
?>