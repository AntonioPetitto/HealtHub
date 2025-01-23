<?php 
// Include il file di configurazione del database
include('config.php');

// Array per memorizzare i dati in uscita
$output = array();

// Query per selezionare tutti i dati necessari
$sql = "SELECT id_utente, id_paziente, nome, cognome, numero_polizza, tipo, data_scadenza, nome_compagnia  FROM UteAnapazAssCom";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_utente',
    1 => 'id_paziente',
    2 => 'nome',
    3 => 'cognome',
    4 => 'numero_polizza',
    5 => 'tipo', 
    6 => 'data_scadenza',
    7 => 'nome_compagnia',
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " WHERE nome LIKE '%".$ricerca."%'";
    $sql .= " OR cognome LIKE '%".$ricerca."%'";
    $sql .= " OR numero_polizza LIKE '%".$ricerca."%'";
    $sql .= " OR tipo LIKE '%".$ricerca."%'";
    $sql .= " OR data_scadenza LIKE '%".$ricerca."%'";
    $sql .= " OR nome_compagnia LIKE '%".$ricerca."%'";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
    $sql .= " ORDER BY id_utente ASC";
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
while($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $riga['id_utente'];
    $sub_array[] = $riga['id_paziente'];
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    $sub_array[] = $riga['numero_polizza'];
    $sub_array[] = $riga['tipo'];
    if ($riga['data_scadenza'] != null) {
        $sub_array[] = date('d/m/Y', strtotime($riga['data_scadenza']));
    } else {
        $sub_array[] = ''; 
    }
    $sub_array[] = $riga['nome_compagnia'];
    // Aggiungi pulsanti per modificare ed eliminare
    $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a> <a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-danger btn-sm deleteBtn align-middle mb-0">Elimina</a>';
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