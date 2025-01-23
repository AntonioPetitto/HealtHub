<?php
// Include il file di configurazione del database
include('config.php');

// Inizializza un array per l'output
$output = array();

// Query SQL per selezionare gli utenti
$sql = "SELECT id_utente, nome, cognome, email, pass, data_registrazione FROM UteAna";

// Esegui la query SQL per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_utente',
    1 => 'nome',
    2 => 'cognome',
    3 => 'email',
    4 => 'pass',
    5 => 'data_registrazione'
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " WHERE email LIKE '%".$ricerca."%'";
    $sql .= " OR nome LIKE '%".$ricerca."%'";
    $sql .= " OR cognome LIKE '%".$ricerca."%'";
    $sql .= " OR pass LIKE '%".$ricerca."%'";
    $sql .= " OR data_registrazione LIKE '%".$ricerca."%'";
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
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    $sub_array[] = $riga['email'];
    $sub_array[] = $riga['pass'];
    if ($riga['data_registrazione'] != null) {
        $sub_array[] = date('d/m/Y', strtotime($riga['data_registrazione']));
    } else {
        $sub_array[] = ''; 
    }
    // Aggiungi un pulsante di modifica per ciascun utente
    $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a>';
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
