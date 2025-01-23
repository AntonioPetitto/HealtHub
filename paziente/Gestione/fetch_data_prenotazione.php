<?php
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera i dati dalla richiesta POST
$data = $_POST['data'];
$id_ambulatorio = $_POST['ambulatorio'];

// Estrai il mese, l'anno e la settimana dalla data fornita
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));
$settimana = date('W', strtotime($data));

// Calcola il primo giorno della settimana e la data della settimana
$giorno_inizio_settimana = strtotime("$anno-W$settimana-1");
$data_inizio_settimana = date("Y-m-d", $giorno_inizio_settimana); 
$data_settimana = date("Y-m-d", strtotime("$data_inizio_settimana -1day"));
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
    $sql_orario = "SELECT id_dipendente, '$giorno' AS giorno, ora_inizio AS orario_inizio_giorno, ora_fine AS orario_fine_giorno FROM UteAnaDipConTurCal WHERE giorno = '$giorno' AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND ruolo='medico' AND id_ambulatorio='$id_ambulatorio'";
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

// Ottiene l'elenco dei mediciche prestano servizio in settimana
$sql = "SELECT id_utente, id_dipendente, id_calendario, nome, cognome FROM UteAnaDipConTurCal2 WHERE ((data_cessazione > '$data_odierna' AND tipo ='determinato') OR tipo = 'indeterminato') AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND ruolo='medico' AND id_ambulatorio='$id_ambulatorio'";

$query = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($query);

$colonne = array(
    0 => 'nome',
    1 => 'lunedì',
    2 => 'martedì',
    3 => 'mercoledì',
    4 => 'giovedì',
    5 => 'venerdì',
    6 => 'sabato',
    7 => 'domenica'
);

if(isset($_POST['search']['value']))
{
	$ricerca = $_POST['search']['value'];
	$sql .= " AND (nome like '%".$ricerca."%'";
	$sql .= " OR cognome like '%".$ricerca."%')";
}

if(isset($_POST['order']))
{
	$nome_colonna = $_POST['order'][0]['column'];
	$ordinamento = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
}
else
{
	$sql .= " ORDER BY id_dipendente asc";
}

if($_POST['length'] != -1)
{
	$inizio = $_POST['start'];
	$lunghezza = $_POST['length'];
	$sql .= " LIMIT  ".$inizio.", ".$lunghezza;
}	
	

$query = mysqli_query($con,$sql);
$conto_righe = mysqli_num_rows($query);
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while ($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $riga['nome'] . " " . $riga['cognome']; //unisce il nome e cognome nella stessa colonna
	
    $data_settimana = date("Y-m-d", strtotime("$data_inizio_settimana -1day"));

    foreach ($orari_per_turno as $giorno => $orario) {
        // Definisce due array uno per gli orari disponibili e uno per quelli occupati
        $orari_disponibili = array();
        $orari_occupati = array();

        //aumenta la data di uno in base al giorno nella settimana
        $data_settimana = date("Y-m-d", strtotime("$data_settimana +1day"));

        foreach ($orario as $orario_giorno) {
            //se l'id_dipendente in questo turno è lo stesso che si ottiene dalla riga di mysqli_fetch_assoc($query)
            if ($orario_giorno['id_dipendente'] == $riga['id_dipendente']) {

                //ottiene il time stamp dell'ora di inizio e fine dei turni del medico
                $ora_inizio = strtotime($orario_giorno['orario_inizio_giorno']);
                $ora_fine = strtotime($orario_giorno['orario_fine_giorno']);
                
                //finchè ora_inizio, che aumenta di 30 minuti ogni iterazione, raggiunge ora_fine
                while ($ora_inizio < $ora_fine) {

                    //ottiene l'ora della visite libere/occupate
                    $ora_formattata = date("H:i:s", $ora_inizio);
                    
                    //controlla che l'orario è libero/occupato attraverso la funzione CheckOrarioOccupato
                    $orario_libero = checkOrarioOccupato($riga['id_dipendente'], $data_settimana, $ora_formattata);
                    
                    if ((!$orario_libero) && $data_settimana>$data_odierna) {
                        //l'orario viene salvato nell'array $orari_disponibili, se l'orario è libero ed è successiva alla data odierna 
                        $orari_disponibili[] = date("H:i", $ora_inizio);
                    }else{
                        //altrimenti viene salvato in orari_occupati
                        $orari_occupati[] = date("H:i", $ora_inizio);
                    }
                    //l'orario aumenta ad ogni ciclo di 30 minuti
                    $ora_inizio = strtotime("+30 minutes", $ora_inizio); 
                }
            }
        }
        //definisce un array che unisce sia gli orari disponibili che occupati
        $orari_totali = array_merge($orari_disponibili, $orari_occupati);

        //ordina tutti gli orari
        sort($orari_totali);

        //array_map è una funzione che permette di creare un array salvando risultati di operazioni di ogni elemento dall'array orari_totali
        //$orario è una variabile che rappresenta singolarmente ciascun elemento di $orari_totali
        $pulsanti = array_map(function($orario) use ($data_settimana, $riga, $orari_disponibili) {
            //nel nuovo array vengono salvati i pulsanti con tutti gli orari e se disponibili sono di colore verde altrimenti rossi
            $classe_pulsante = in_array($orario, $orari_disponibili) ? 'bg-gradient-primary' : 'bg-gradient-danger';
            return '<a href="#" class="btn btn-sm btn-prenota ' . $classe_pulsante . '" data-dipendente="'. $riga['id_dipendente'].'" data-data="'. $data_settimana. '" data-id="' . $orario . '" style="padding: 0.20rem 2rem;">' . $orario . '</a>';
        }, $orari_totali);

        //Aggiungiamo i pulsanti al subarray
        $sub_array[] = '<div>' . implode('</div><div>', $pulsanti) . '</div>';
    }

    $data[] = $sub_array;
}
//funzione per controllare se l'orario è disponibile o meno
function checkOrarioOccupato($id_dipendente, $data, $ora) {
    include('config.php');

    //Verifica una visita con le stesse infomarzioni sia stata prenotata
    $data_odierna = date('Y-m-d');
    $data_formattata = date("Y-m-d", strtotime($data));
    $sql_controllo = "SELECT * FROM visita WHERE id_dipendente = '$id_dipendente' AND ora_visita = '$ora' AND data_visita='$data_formattata' AND stato='corso'";
    $result = mysqli_query($con, $sql_controllo);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
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
