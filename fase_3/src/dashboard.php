<?php
include_once './logout.php';

/**
 * Questo script permette di visualizzare la dashboard
 * 
 * Se l'utente non è autenticato, viene reindirizzato al login
 * 
 * Se l'utente ha inviato il form di logout, viene effettuato il logout
 */
session_start();
$isAuthenticated = isset($_SESSION['user']);
if (!$isAuthenticated) {
    header("Location: ./login.php");
    exit();
}

if (isset($_POST['logout'])) {
    logout();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <h1 class="my-4">Dashboard</h1>
    <h2>Benvenuto, <?= $_SESSION['user']['username'] ?></h2>
    <form method="post">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>

</html>