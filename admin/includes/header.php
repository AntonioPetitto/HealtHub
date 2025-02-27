<?php
session_start();
if (!isset($_SESSION['id_utente'])) {
  header("Location: ../home/home.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo.svg">
  <link rel="icon" type="image/ico" href="../assets/img/logo.ico">
  <title>
    Healthub Admin
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />

  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css" rel="stylesheet" />

</head>

<body class="g-sidenav-show  bg-gray-100">

  <?php include('sidebar.php') ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

      <?php include('navbar.php') ?>

        <div class="container-fluid py-4 ">
                  
</div>  
</body>

            