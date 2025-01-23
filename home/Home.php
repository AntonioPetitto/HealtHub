<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo.svg">
    <link rel="icon" type="image/ico" href="../assets/img/logo.ico">
    <title>HealtHub | Home</title>
    <style>
        
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            width:100%;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/img/medici.jpeg');
            background-size: cover;
            color:#7BAE37;
            font-family: 'Roboto',sans-serif;
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            border-radius: 10px;
        }

        .navigation-container {
            position: fixed;
            left: 70%;
            width: 40%;
            transform: translateX(-50%);
            background-color: rgba(255, 255, 255, 0.7); 
            padding: 80px 40px;
            border-radius:20px;
            z-index: 998; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
            height:120px;
            top:230px;
            align-content:center;
        }

        .navigation-container .content {
            text-align: center;
            margin-top: -80px;
            margin-bottom: 130px;
            margin:0 auto;
        }
        .navigation-text{
            text-align:center;
            margin-top:-45px;
            margin-bottom:-5px;
        }

        .navigation-container .content a {
            text-align: center;
            display: block; 
            margin-bottom: 20px; 
            padding: 10px 60px; 
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            width:50%;
            margin-left:15%;
            margin-top:10px;
            height: fit-content;
            background-color: #7BAE37;
            background-image: linear-gradient(310deg, #9EC963 0%, #7BAE37 100%);
            transition: background-color 0.3s ease;
            transition: transform 0.3s ease;
        }
        .navigation-container .content a:hover {
            background-image: linear-gradient(310deg, #7BAE37 100%,#9EC963 0%) !important;
            color: #fff;
            transform: scale(1.03);
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
        footer {
            background-color: #fff;
            color: #7BAE37;
            text-align: center;
            padding: 0px;
            position: fixed;
            bottom: -15px;
            width: 100%;
        }
        .navigation-container .content a:hover {
            background-color: #5c9633; 
            background-image: none; 
            color: #fff; 
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>Benvenuto su HealtHub</h1>
        <div class="navbar">
            <a class="nav-link <?php echo ($currentPageFile === 'Home.php') ? 'active' : ''; ?>" href="Home.php">Home</a>
            <a class="nav-link <?php echo ($currentPageFile === 'ChiSiamo.php') ? 'active' : ''; ?>" href="ChiSiamo.php">Chi Siamo</a>
            <a class="nav-link <?php echo ($currentPageFile === 'Ambulatori.php') ? 'active' : ''; ?>" href="Ambulatori.php">Ambulatori</a>
            <img src="../assets/img/logo.svg" alt="HealthHub Logo" height="40">
        </div>
    </div>
    <div class="navigation-container">
        <div class="navigation-text">
            <h1>Usufruisci dei nostri servizi<h1>
        </div>
        <div class="content">
            <a href="login_paziente.php">Area Pazienti</a>
            <a href="login_dipendente.php">Area Dipendenti</a>
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
    <footer>
        <p>&copy; 2024 Poliambulatorio HealtHub</p>
    </footer>
</body>
</html>
