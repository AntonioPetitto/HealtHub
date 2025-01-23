<?php 
// Include il file di configurazione del database
include('config.php');

// Inizializza un array per l'output
$output = array();

// Query per selezionare gli utenti associati a pazienti e assicurazioni
$sql = "SELECT paziente.id_utente, id_paziente, nome, cognome, codice_fiscale, cie, telefono FROM UteAna JOIN paziente ON uteana.id_utente = paziente.id_utente";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_utente',
    1 => 'id_paziente',
    2 => 'nome',
    3 => 'cognome',
    4 => 'codice_fiscale',
    5 => 'cie',
    6 => 'telefono'
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " AND (nome LIKE '%".$ricerca."%'";
    $sql .= " OR cognome LIKE '%".$ricerca."%'";
    $sql .= " OR codice_fiscale LIKE '%".$ricerca."%'";
    $sql .= " OR cie LIKE '%".$ricerca."%'";
    $sql .= " OR telefono LIKE '%".$ricerca."%')";
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
    $sub_array[] = $riga['codice_fiscale'];
    $sub_array[] = $riga['cie'];
    $sub_array[] = $riga['telefono'];
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
