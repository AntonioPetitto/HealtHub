<?php
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera i dati POST 
$data = $_POST['data'];

// Recupera l'ID utente e il nome dell'ambulatorio dalla sessione
$id_utente = $_SESSION['id_utente'];
$nome_ambulatorio = $_SESSION['nome_ambulatorio'];

// Estrai il mese e l'anno dalla data fornita con il metodo POST
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));

// Ottieni il numero della settimana corrispondente alla data
$settimana = date('W', strtotime($data));

// Ottieni la data odierna
$data_odierna = date('Y-m-d');

// Inizializza un array per l'output
$output = array();

// Definisce un array associativo per ogni giorno della settimana
$orari = array(
    'lunedì' => null,
    'martedì' => null,
    'mercoledì' => null,
    'giovedì' => null,
    'venerdì' => null,
    'sabato' => null,
    'domenica' => null
);

// Definisce un array per ogni query in base al giorno per ottenere l'id_dipendente, gli orari di inizio e di fine dei turni
$sql_orari = array(); 
foreach ($orari as $giorno => $orario) {
    $sql_orario = "SELECT id_dipendente, '$giorno' AS giorno, ora_inizio AS orario_inizio_giorno, ora_fine AS orario_fine_giorno FROM UteAnaDipConTurCal WHERE giorno = '$giorno' AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND nome_ambulatorio='$nome_ambulatorio'";
    $sql_orari[$giorno] = $sql_orario;
}

$orari_per_turno = array();

// Esegui le query nell'array sql_orari per ottenere e gli orari inizio e fine per ciascun giorno della settimana e salvarli nell'array orari_per_turno
foreach ($sql_orari as $giorno => $sql_query) {
    $query_orario = mysqli_query($con, $sql_query);

    while ($riga_orario = mysqli_fetch_assoc($query_orario)) {
        $orari_per_turno[$giorno][] = $riga_orario;
    }
}

// Query per ottenere i dati dei dipendenti per la settimana e l'ambulatorio correnti
$sql = "SELECT id_utente, id_dipendente, id_calendario, nome, cognome FROM UteAnaDipConTurCal2 WHERE settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND nome_ambulatorio='$nome_ambulatorio'";

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
	$sql .= " AND (nome like '%".$ricerca."%'";
	$sql .= " OR cognome like '%".$ricerca."%')";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
	$nome_colonna = $_POST['order'][0]['column'];
	$ordinamento = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
	$sql .= " ORDER BY id_dipendente asc";
}

// Gestione della paginazione
if($_POST['length'] != -1) {
	$inizio = $_POST['start'];
	$lunghezza = $_POST['length'];
	$sql .= " LIMIT  ".$inizio.", ".$lunghezza;
}	

$query = mysqli_query($con,$sql);
$conto_righe = mysqli_num_rows($query);


// Inizializza un array per i dati
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while ($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    // Aggiungi gli orari di lavoro di ciascun giorno per il dipendente corrente
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
        // Concatena gli orari di inizio e fine separati da virgola
        $sub_array[] = implode(', ', $orari_inizio) . ' - ' . implode(', ', $orari_fine);
    }
    // Verifica se l'ID del dipendente corrente corrisponde all'ID della sessione
    if ($riga['id_utente'] == $id_utente) {
        // Inserisce il record del dipendente corrente all'inizio dell'array di dati
        array_unshift($data, $sub_array);
    } else {
        // Inserisce gli altri record dei dipendenti
        $data[] = $sub_array;
    }
}

// Costruisce l'array per la risposta JSON
$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$conto_righe ,
	'recordsFiltered'=>$totale_righe,
	'data'=>$data,
);

// Restituisce la risposta JSON
echo  json_encode($output);
?>