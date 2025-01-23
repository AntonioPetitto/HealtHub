<?php
// Include il file di configurazione del database
include('config.php');

// Recupera la data dalla richiesta POST
$data = $_POST['data'];
$id_ambulatorio = $_POST['ambulatorio'];

// Estrai il mese e l'anno dalla data fornita
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));
// Ottieni il numero della settimana per la data fornita
$settimana = date('W', strtotime($data));

// Ottieni la data odierna nel formato 'YYYY-MM-DD'
$data_odierna = date('Y-m-d');

// Inizializza un array per l'output
$output = array();

// Definisce un array associativo per memorizzare gli orari per ogni giorno della settimana
$orari = array(
    'lunedì' => null,
    'martedì' => null,
    'mercoledì' => null,
    'giovedì' => null,
    'venerdì' => null,
    'sabato' => null,
    'domenica' => null
);

// Inizializza un array per memorizzare le query SQL per gli orari di lavoro
$sql_orari = array(); 

if($id_ambulatorio!=""){
    // le query SQL vengono salvate nell'array per ottenere gli orari di lavoro per ogni giorno della settimana
    foreach ($orari as $giorno => $orario) {
        $sql_orario = "SELECT id_dipendente, '$giorno' AS giorno, ora_inizio AS orario_inizio_giorno, ora_fine AS orario_fine_giorno FROM UteAnaDipConTurCal WHERE giorno = '$giorno' AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND id_ambulatorio='$id_ambulatorio'";
        $sql_orari[$giorno] = $sql_orario;
    }

    // Inizializza un array per memorizzare gli orari per ogni turno di lavoro
    $orari_per_turno = array();

    // Esegui le query SQL per ottenere gli orari di lavoro e memorizzali nell'array $orari_per_turno
    foreach ($sql_orari as $giorno => $sql_query) {
        $query_orario = mysqli_query($con, $sql_query);

        while ($riga_orario = mysqli_fetch_assoc($query_orario)) {
            $orari_per_turno[$giorno][] = $riga_orario;
        }
    }

    // Query SQL per selezionare i dipendenti e i loro orari di lavoro
    $sql = "SELECT id_dipendente, id_calendario, nome, cognome FROM UteAnaDipConTurCal2 WHERE settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND id_ambulatorio='$id_ambulatorio'";

}else{
    foreach ($orari as $giorno => $orario) {
        $sql_orario = "SELECT id_dipendente, '$giorno' AS giorno, ora_inizio AS orario_inizio_giorno, ora_fine AS orario_fine_giorno FROM UteAnaDipConTurCal WHERE giorno = '$giorno' AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno'";
        $sql_orari[$giorno] = $sql_orario;
    }
    
    // Inizializza un array per memorizzare gli orari per ogni turno di lavoro
    $orari_per_turno = array();
    
    // Esegui le query SQL per ottenere gli orari di lavoro e memorizzali nell'array $orari_per_turno
    foreach ($sql_orari as $giorno => $sql_query) {
        $query_orario = mysqli_query($con, $sql_query);
    
        while ($riga_orario = mysqli_fetch_assoc($query_orario)) {
            $orari_per_turno[$giorno][] = $riga_orario;
        }
    }  

    // Query SQL per selezionare i dipendenti e i loro orari di lavoro
    $sql = "SELECT id_dipendente, id_calendario, nome, cognome FROM UteAnaDipConTurCal2 WHERE settimana = '$settimana' AND mese = '$mese' AND anno='$anno'";
}

// Esegui la query per ottenere il totale delle righe
$query = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($query);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'nome',
    1 => 'cognome',
    2 => 'lunedì',
    3 => 'martedì',
    4 => 'mercoledì',
    5 => 'giovedì',
    6 => 'venerdì',
    7 => 'sabato',
    8 => 'domenica'
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " AND (nome LIKE '%".$ricerca."%'";
    $sql .= " OR cognome LIKE '%".$ricerca."%')";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
    $sql .= " ORDER BY id_dipendente ASC";
}

// Gestione della paginazione
if($_POST['length'] != -1) {
    $inizio = $_POST['start'];
    $lunghezza = $_POST['length'];
    $sql .= " LIMIT ".$inizio.", ".$lunghezza;
}   

$query = mysqli_query($con, $sql);
$conto_righe = mysqli_num_rows($query);

// Inizializza un array per i dati
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while ($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    // Aggiungi gli orari di lavoro per ciascun giorno della settimana
    foreach ($orari_per_turno as $giorno => $orario) {
        $orari_inizio = [];
        $orari_fine = [];
        foreach ($orario as $orario_giorno) {
            if ($orario_giorno['id_dipendente'] == $riga['id_dipendente']) {
                // Verifica se l'orario è null, in tal caso assegna '' direttamente
                $orari_inizio[]= $orario_giorno['orario_inizio_giorno'] !== null ? date('H:i', strtotime($orario_giorno['orario_inizio_giorno'])) : '';
                $orari_fine[] = $orario_giorno['orario_fine_giorno'] !== null ? date('H:i', strtotime($orario_giorno['orario_fine_giorno'])) : '';
            }
        }
        // Concatena gli orari di inizio e fine in una stringa
        $sub_array[] = implode(', ', $orari_inizio) . ' - ' . implode(', ', $orari_fine);
    }
    // Aggiungi un pulsante di modifica per ciascun dipendente
    $sub_array[] = '<a href="javascript:void();" data-id-calendario="' . $riga['id_calendario'] . '" data-id="' . $riga['id_dipendente'] . '"  class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a>';
    $data[] = $sub_array;
}

// Costruisce l'array per la risposta JSON
$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $conto_righe,
    'recordsFiltered' => $totale_righe,
    'data' => $data,
);

// Restituisce la risposta JSON
echo json_encode($output);
?>
