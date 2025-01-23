<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo.svg">
    <link rel="icon" type="image/ico" href="../assets/img/logo.ico">
    <title>HealtHub | Ambulatori</title>
    <style>

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            width:100%;
            color:#7BAE37;
            font-family: 'Roboto',sans-serif;
            overflow-y: auto;
            overflow-x: hidden;
            background-repeat: no-repeat;
            background-color:#fff;
            background-size: cover;        
            background-attachment: fixed;
        }

        .top-bar {
            background-color: rgba(255, 255, 255, 0.8);
            width: 100%;
            height: 60px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .top-bar h1 {
            margin-right: 30px;
        }

        .top-bar img {
            margin-right: 40px; 
        }

        .content {
            margin-top: 150px; 
            text-align: center;  
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            position: absolute;
            top: 0;
            padding: 0px;
        }

        .header img {
            height: 45px;
            margin-top:1%;
            margin-right:2%;
        }

        .content {
            text-align: center;
        }

        .content a {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #7BAE37;
            border-radius: 10px;
        } 
        
        .navbar {
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: #7BAE37;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar a:hover {
            color: #82d616;
            text-decoration: underline;
        }

        .navbar a.active {
            color: #82d616; 
            text-decoration:underline; 
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        main {
            padding: 20px;
            color: #fff;
        }

        .ambulatorio {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            color: #fff;
            margin-top: 50px;
            font-size:20px;
            text-align: justify;
            background-color: rgba(123, 174, 55);
            border-radius: 15px;
        }

        .immagine {
            display: flex;
        }

        .immagine img {
            max-width: 100%;
            width:100%;
            height: auto;
            border-radius: 1%;
        }

        .ambulatorio h3 {
            margin-top: 0;
            color: #fff;
            font-size:22px;
            margin-top:15px;
        }

        footer {
            background-color: #fff;
            color: #7BAE37;
            text-align: center;
            padding: 5px; 
            width: 100%;
            position: relative;
        }

        .hidden {
            display: none !important;
        }

        #orariContainer {
            position: absolute; 
            top: 100%;
            right: 50%;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            width: 500px;
            z-index: 1000; 
            display: none;
        }

        .top-bar button {
            padding: 10px 20px;
            margin-right: auto;
            background-color: #7BAE37;
            color: #ffffff; 
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .top-bar button:hover {
            background-color: #82d616; 
        }

        #orariBtn.active + #orariContainer {
            display: block;
        }
    </style>
</head>
<body>
    <main>
        <section id="ambulatori">
            <div class="ambulatorio">
                <div class="immagine">
                    <img src="../assets/img/cardiologia.jpg" alt="Immagine cardiologia">
                </div>
                <h3>Cardiologia</h3>
                <p>
                    Il reparto di cardiologia è un'unità specializzata nella diagnosi, trattamento e gestione delle malattie cardiovascolari, che coinvolgono il cuore e i vasi sanguigni. Questo reparto è composto da un team multidisciplinare di cardiologi, infermieri, tecnici e altri professionisti della salute, tutti addestrati specificamente per gestire le condizioni cardiache.

                    I pazienti che vengono trattati nel reparto di cardiologia possono presentare una vasta gamma di condizioni, tra cui malattie coronariche, insufficienza cardiaca, aritmie, ipertensione e malattie congenite del cuore. Il reparto offre una serie di servizi, tra cui test diagnostici come elettrocardiogrammi (ECG), ecocardiogrammi, angiografie coronariche e monitoraggio cardiaco continuo.

                    Il trattamento fornito nel reparto di cardiologia varia a seconda della condizione del paziente e può includere terapie farmacologiche, interventi chirurgici come bypass coronarico, angioplastica e impianto di pacemaker o defibrillatore cardiaco. Inoltre, il reparto offre programmi di riabilitazione cardiaca per aiutare i pazienti a recuperare dopo eventi cardiaci o interventi chirurgici e per migliorare la loro salute cardiovascolare complessiva.
                </p>
            </div>
            <div class="ambulatorio">
                <div class="immagine">
                    <img src="../assets/img/chirurgia.jpg" alt="Immagine chirurgia">
                </div>
                <h3>Chirurgia</h3>
                <p>
                    Il reparto di chirurgia è un'unità dedicata alla diagnosi e al trattamento di una vasta gamma di condizioni chirurgiche. Questo reparto è gestito da un team multidisciplinare di chirurghi, infermieri chirurgici e altri professionisti della salute, che collaborano per fornire cure chirurgiche sicure ed efficaci.

                    I pazienti che vengono trattati nel reparto di chirurgia possono presentare condizioni che richiedono interventi chirurgici programmabili o urgenti. Queste condizioni possono includere malattie gastrointestinali, tumori, traumi, fratture ossee, malattie vascolari, patologie ortopediche e molte altre.

                    Il reparto offre una vasta gamma di servizi chirurgici, compresi interventi laparoscopici, interventi aperti, chirurgia mini-invasiva e chirurgia robotica. Prima dell'intervento chirurgico, ai pazienti vengono spiegati i dettagli del procedimento e vengono fornite istruzioni preoperatorie.

                    Durante l'intervento chirurgico, il paziente viene monitorato attentamente e riceve anestesia per garantire comfort e sicurezza. Dopo l'intervento, i pazienti possono essere trasferiti in unità di terapia intensiva o di degenza, a seconda della gravità della procedura e del loro stato di salute complessivo.

                    Il reparto di chirurgia si impegna anche nella gestione del dolore postoperatorio e nel supporto alla riabilitazione post-chirurgica, per garantire un recupero ottimale e una buona qualità di vita per i pazienti.
                </p>
            </div>
            <div class="ambulatorio">
                <div class="immagine">
                    <img src="../assets/img/endocrinologia.jpg" alt="Immagine Endocrinologia">
                </div>
                <h3>Endocrinologia</h3>
                <p>
                    Il reparto di endocrinologia è un'unità specializzata all'interno di un ospedale o di un poliambulatorio che si occupa della diagnosi e del trattamento delle malattie legate al sistema endocrino. Questo sistema comprende ghiandole endocrine come la tiroide, le ghiandole surrenali, l'ipofisi, il pancreas e altre, che producono e rilasciano ormoni nell'organismo per regolare molte funzioni vitali.

                    Nel reparto di endocrinologia, i medici specialisti, noti come endocrinologi, gestiscono una vasta gamma di condizioni, tra cui diabete mellito (tipo 1 e tipo 2), disturbi della tiroide (come ipotiroidismo e ipertiroidismo), malattie delle ghiandole surrenali, ipogonadismo, osteoporosi, sindromi ormonali e molto altro.

                    La diagnosi delle malattie endocrine può richiedere una serie di test di laboratorio, esami di imaging e valutazioni cliniche dettagliate per identificare la causa sottostante dei sintomi del paziente. Una volta diagnosticata la condizione, gli endocrinologi sviluppano piani di trattamento personalizzati che possono includere terapie farmacologiche, terapie ormonali, interventi chirurgici o modifiche dello stile di vita.

                    Il reparto di endocrinologia svolge anche un ruolo importante nella gestione delle complicazioni a lungo termine associate alle malattie endocrine, fornendo supporto continuo e follow-up per garantire una gestione efficace e il monitoraggio delle condizioni dei pazienti nel tempo.

                    Inoltre, l'endocrinologia è spesso coinvolta nella ricerca e nello sviluppo di nuove terapie e approcci per il trattamento delle malattie endocrine, contribuendo così al progresso nella cura di queste condizioni mediche complesse.
                </p>
            </div>
            <div class="ambulatorio">
                <div class="immagine">
                    <img src="../assets/img/Neurologia.jpg" alt="Immagine neurologia">
                </div>
                <h3>Neurologia</h3>
                <p>
                    Il reparto di neurologia si concentra sulla diagnosi e sul trattamento delle malattie del sistema nervoso, che comprende il cervello, il midollo spinale, i nervi periferici e il sistema nervoso autonomo. Questo reparto gestisce una vasta gamma di condizioni neurologiche, tra cui ictus, epilessia, malattia di Parkinson, sclerosi multipla, emicrania, neuropatie periferiche, traumi cranici e molto altro. Gli specialisti in neurologia utilizzano una combinazione di esami clinici, imaging cerebrali, elettroencefalogrammi (EEG) e altri test diagnostici per valutare e trattare le condizioni neurologiche. Il trattamento può includere terapie farmacologiche, interventi chirurgici, terapie fisiche e riabilitazione, oltre a un'attenzione particolare alla gestione dei sintomi e al miglioramento della qualità della vita dei pazienti.
                </p>
            </div>
            <div class="ambulatorio">
                <div class="immagine">
                    <img src="../assets/img/ortopedia.jpg" alt="Immagine ortopedia">
                </div>
                <h3>Ortopedia</h3>
                <p>
                    Il reparto di ortopedia è specializzato nella diagnosi e nel trattamento delle malattie e delle lesioni che coinvolgono il sistema muscolo-scheletrico. Questo comprende ossa, articolazioni, muscoli, tendini e legamenti. Gli ortopedici si occupano di una vasta gamma di condizioni, tra cui fratture ossee, lesioni sportive, artrosi, deformità congenite o acquisite, malattie degenerative delle articolazioni e molto altro. Il reparto offre servizi che vanno dalla gestione conservativa delle lesioni ortopediche tramite terapie fisiche e riabilitazione, fino a interventi chirurgici complessi per riparare o sostituire articolazioni danneggiate.
                </p>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Poliambulatorio HealtHub</p>
    </footer>
    <div class="top-bar">
        <h1>I nostri ambulatori</h1>
        <button id="orariBtn">Orari</button>
        <div id="orariContainer" class="hidden">
            <h2>Gli orari dei nostri ambulatori:</h2>
            <div class="ambulatorio">
                <p class="orario">Da Lunedì a Venerdì: 8:00 - 13:00 e 15:00 - 20:00</p>
                <p class="orario">Sabato e Domenica: 8:00 - 13:00</p>
            </div>
        </div>
        <script src="script.js"></script>
        <div class="navbar">
            <a class="nav-link <?php echo ($currentPageFile === 'Home.php') ? 'active' : ''; ?>" href="Home.php">Home</a>
            <a class="nav-link <?php echo ($currentPageFile === 'ChiSiamo.php') ? 'active' : ''; ?>" href="ChiSiamo.php">Chi Siamo</a>
            <a class="nav-link <?php echo ($currentPageFile === 'Ambulatori.php') ? 'active' : ''; ?>" href="Ambulatori.php">Ambulatori</a>
            <img src="../assets/img/logo.svg" alt="HealthHub Logo" height="40">
        </div>
    </div> 
    <script>
        var currentPageFile = window.location.pathname.split('/').pop();
        var navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            var linkPath = link.getAttribute('href').split('/').pop();
            if (currentPageFile === linkPath) {
                link.classList.add('active');
            }
        });
    </script>
    <script>
        const orariBtn = document.getElementById('orariBtn');
        const orariContainer = document.getElementById('orariContainer');

        orariBtn.addEventListener('click', () => {
            orariContainer.classList.toggle('hidden');
            orariBtn.classList.toggle('active');
        });

        window.addEventListener('scroll', function() {
            // Controlla se il container degli orari è visibile
            if (!orariContainer.classList.contains('hidden')) {
                // Nasconde il container degli orari
                orariContainer.classList.add('hidden');
                // Rimuove la classe 'active' dal pulsante degli orari
                orariBtn.classList.remove('active');
            }
        });
    </script>
</body>
</html>