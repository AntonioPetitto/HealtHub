<?php
// Include il file di configurazione del database
include('config.php'); 

// Avvia la sessione
session_start(); 

// Ottieni l'ID del paziente dalla variabile di sessione
$id_paziente = $_SESSION['id_paziente']; 

// Inizializza un array per l'output
$output = array(); 

// Query per selezionare i dati delle fatture del paziente dal database
$sql = "SELECT visita.id_visita, numero_fattura, importo, data_pagamento, pagato, metodo FROM fattura JOIN visita ON fattura.id_visita = visita.id_visita LEFT JOIN modalita ON modalita.id_modalità = fattura.id_modalità WHERE id_paziente='$id_paziente'"; 

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql); 
$totale_righe = mysqli_num_rows($queryTotale); 

// Definisce le colonne della tabella
$colonne = array( 
    0 => 'id_visita',
    1 => 'numero_fattura',
    2 => 'importo',
    3 => 'data_pagamento',
    4 => 'metodo',
    5 => 'pagato',
);

// Gestione della ricerca
if (isset($_POST['search']['value'])) { 
    $ricerca = $_POST['search']['value'];
    $sql .= " AND (numero_fattura LIKE '%" . $ricerca . "%'";
    $sql .= " OR metodo LIKE '%" . $ricerca . "%'";
    $sql .= " OR pagato LIKE '%" . $ricerca . "%')";
}

// Gestione dell'ordinamento
if (isset($_POST['order'])) { 
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY " . $colonne[$nome_colonna] . " " . $ordinamento . "";
} else {
    $sql .= " ORDER BY id_visita DESC"; 
}

// Gestione della paginazione
if ($_POST['length'] != -1) { 
    $inizio = $_POST['start'];
    $lunghezza = $_POST['length'];
    $sql .= " LIMIT  " . $inizio . ", " . $lunghezza;
}

$query = mysqli_query($con, $sql); 
$conto_righe = mysqli_num_rows($query); 

// Inizializza un array per i dati
$data = array(); 

// Costruisce l'array dei dati per la risposta JSON
while ($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array(); 
    $sub_array[] = $riga['id_visita'];
    $sub_array[] = $riga['numero_fattura'];
    $sub_array[] = $riga['importo'];
    $sub_array[] = $riga['pagato'];
    $sub_array[] = $riga['metodo'];

    if (!empty($riga['data_pagamento'])){
        $sub_array[] = date('d/m/Y', strtotime($riga['data_pagamento'])); // Formatta la data di pagamento
    } else {
        $sub_array[] = ''; // O qualsiasi valore predefinito tu preferisca
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

// Restituisce l'output JSON
echo json_encode($output); 
?>