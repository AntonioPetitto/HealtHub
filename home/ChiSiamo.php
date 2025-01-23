<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo.svg">
    <link rel="icon" type="image/ico" href="../assets/img/logo.ico">
    
    <title>HealtHub | Chi Siamo</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            width: 100%;
            color: #7BAE37;
            font-family: 'Roboto', sans-serif;
            overflow-y: auto;
            overflow-x: hidden;
            background-repeat: no-repeat;
            background-color: #fff;
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
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .top-bar h1 {
            margin-right: 0%;
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
            margin-top: 1%;
            margin-right: 2%;
        }

        .content a {
            text-align: center;
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
            text-decoration: underline;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            margin-bottom: 60px;
            min-height: calc(100vh - 60px);
        }

        .ChiSiamo {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            color: #fff;
            margin-top: 50px;
            font-size: 20px;
            text-align: justify;
            background-color: rgba(123, 174, 55);
            border-radius: 15px;
        }

        .immagine img {
            max-width: 100%;
            width: 100%;
            height: auto;
            border-radius: 1%;
        }

        .ChiSiamo h3 {
            margin-top: 0;
            color: #fff;
            font-size: 22px;
            margin-top: 15px;
        }

        .contact {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .contact-left {
            flex-grow: 1;
            text-align: left;
        }

        .contact-right {
            flex-grow: 1;
            text-align: right;
        }

        .contact p {
            margin: 5px 0;
            color: #7BAE37;
            font-weight: bold;
        }

        .Clinica {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            color: #fff;
            margin-top: 50px;
            font-size: 20px;
            text-align: justify;
            background-color: rgba(123, 174, 55);
            border-radius: 15px;
        }

        footer {
            background-color: #fff;
            color: #7BAE37;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            z-index: 999; 
        }


    </style>
</head>
<body>
<main>
    <section id="ChiSiamo">
        <div class="ChiSiamo">
            <div class="immagine">
                <img src="../assets/img/ChiSiamo.jpg" alt="Immagine ChiSiamo">
            </div>
            <p>
                HealtHub è una rete polifunzionale di ambulatori attivi sul territorio messinese. Con una vasta gamma
                di servizi medici e paramedici, ci impegniamo a fornire cure personalizzate che rispondano
                efficacemente alle esigenze del paziente. Il nostro team di professionisti esperti assiste il paziente
                durante tutta la sua permanenza all'interno delle nostre strutture ospedaliere, offrendo cure
                preventive, diagnostiche e terapeutiche avanzate. Presso il poliambulatorio HealtHub, il team si
                impegna a creare un ambiente accogliente e confortevole, dove la salute e il benessere del paziente
                siano sempre garantiti.
            </p>
        </div>

        <div class="Clinica">
            <div class="immagine">
                <img src="../assets/img/HealtHub.jpg" alt="Immagine clinica">
            </div>
        </div>
    </section>
</main>
<footer id="myFooter">
    <div class="contact">
        <div class="contact-left">
            <p>Contrada Papardo, 98158 Messina ME</p>
        </div>
        <div class="contact-right">
            <p>Telefono: 090 434 324</p>
            <p>Email: info@HealtHub.com</p>
        </div>
    </div>
</footer>
<div class="top-bar">
    <h1>Chi siamo e i nostri contatti</h1>
    <div class="navbar">
        <a class="nav-link <?php echo ($currentPageFile === 'Home.php') ? 'active' : ''; ?>" href="Home.php">Home</a>
        <a class="nav-link <?php echo ($currentPageFile === 'ChiSiamo.php') ? 'active' : ''; ?>" href="ChiSiamo.php">Chi Siamo</a>
        <a class="nav-link <?php echo ($currentPageFile === 'Ambulatori.php') ? 'active' : ''; ?>"
           href="Ambulatori.php">Ambulatori</a>
        <img src="../assets/img/logo.svg" alt="HealthHub Logo" height="40">
    </div>
</div>
<script>
    var currentPageFile = window.location.pathname.split('/').pop();
    var navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function (link) {
        var linkPath = link.getAttribute('href').split('/').pop();
        if (currentPageFile === linkPath) {
            link.classList.add('active');
        }
    });
</script>
<script>
    function checkFooterPosition() {
        var footer = document.getElementById('myFooter');
        var scrollPosition = window.scrollY;
        var windowHeight = window.innerHeight;
        var documentHeight = document.body.offsetHeight;
        if (scrollPosition + windowHeight >= documentHeight) {
            footer.style.bottom = '0';
        } else {
            footer.style.bottom = '-100px'; 
        }
    }

    window.addEventListener('load', checkFooterPosition); // Aggiunta dell'evento al caricamento della pagina
    window.addEventListener('scroll', checkFooterPosition); // Aggiunta dell'evento allo scorrimento della pagina
</script>

</body>
</html>