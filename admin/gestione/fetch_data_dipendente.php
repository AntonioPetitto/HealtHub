<?php 
// Include il file di configurazione del database
include('config.php');

// Array per memorizzare i dati in uscita
$output = array();

// Query per selezionare tutti i dati necessari
$sql = "SELECT id_utente, id_dipendente, nome, cognome, ruolo, nome_ambulatorio, stipendio, tipo, data_cessazione  FROM UteAnaDIpConAmb";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_utente',
    1 => 'id_dipendente',
    2 => 'nome',
    3 => 'cognome',
    4 => 'ruolo',
    5 => 'nome_ambulatorio',
    6 => 'stipendio',
    7 => 'tipo',
    8 => 'data_cessazione'
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " WHERE nome LIKE '%".$ricerca."%'";
    $sql .= " OR cognome LIKE '%".$ricerca."%'";
    $sql .= " OR ruolo LIKE '%".$ricerca."%'";
    $sql .= " OR nome_ambulatorio LIKE '%".$ricerca."%'";
    $sql .= " OR stipendio LIKE '%".$ricerca."%'";
    $sql .= " OR tipo LIKE '%".$ricerca."%'";
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
    // controlla se la data cessazione è null
    if ($riga['data_cessazione'] === null) {
        $data_cessazione_formattata = null;
        $classe_data_cessazione = ''; 
        $mostra_licenzia_btn = true;
    } else {
        // Confronta la data di cessazione con quella odierna
        $data_cessazione = strtotime($riga['data_cessazione']);
        $data_odierna = strtotime(date('Y-m-d'));
        // Aggiungi una classe CSS per cambiare colore al testo se la data di cessazione è minore rispetto alla data odierna
        $classe_data_cessazione = ($data_cessazione <= $data_odierna) ? 'text-danger' : '';
        // Formatta la data nel formato desiderato
        $data_cessazione_formattata = date('d/m/Y', $data_cessazione);
        $mostra_licenzia_btn = ($data_cessazione > $data_odierna);
    }

    $sub_array = array();
    $sub_array[] = $riga['id_utente'];
    $sub_array[] = $riga['id_dipendente'];
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    $sub_array[] = $riga['ruolo'];
    $sub_array[] = $riga['nome_ambulatorio'];
    $sub_array[] = $riga['stipendio'];
    $sub_array[] = $riga['tipo'];
    $sub_array[] = '<span class="'.$classe_data_cessazione.'">'.$data_cessazione_formattata.'</span>';
    // Aggiungi pulsanti per modificare, licenziare ed eliminare
    if($mostra_licenzia_btn){
        $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a> <a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-warning btn-sm licenziaBtn align-middle mb-0">Licenzia</a> <a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-danger btn-sm deleteBtn align-middle mb-0">Elimina</a>';
    }else{
        $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a> <a href="javascript:void();" class="btn bg-gradient-faded-dark btn-sm align-middle text-white mb-0">Licenzia</a> <a href="javascript:void();" data-id="'.$riga['id_utente'].'" class="btn bg-gradient-danger btn-sm deleteBtn align-middle mb-0">Elimina</a>';   
    }

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