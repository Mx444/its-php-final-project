<?php
session_start();
include_once '../controller/UserController.php';

$isAuthenticated = isset($_SESSION['user']);
$isAdmin = $_SESSION['user']['role'] === 'admin';
$userController = new UserController();

/*
* Se l'utente non è autenticato, reindirizzalo alla pagina di login.
*/
if (!$isAuthenticated) {
    header("Location: ./login.php");
    exit();
}

/*
* Se l'utente ha effettuato il logout, distruggi la sessione e reindirizzalo alla pagina di login.
*/
if (isset($_POST['logout'])) {
    $userController->logout();
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
    <p>Questa è la tua dashboard personale.</p>
    <p>Il tuo ruolo è: <?= $_SESSION['user']['role'] ?></p>
    <?php if ($isAdmin) : ?>
        <a href="./gestione_utenti.php" class="btn btn-primary">Gestione Utenti</a>
    <?php endif; ?>

    </button>
    <form method="post">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>

</html>