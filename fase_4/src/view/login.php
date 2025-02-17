<?php

include_once '../controller/UserController.php';

session_start();
/**
 * Controllo se l'utente è autenticato
 */
$isAuthenticated = isset($_SESSION['user']);
if ($isAuthenticated) {
    header("Location: ./dashboard.php");
    exit();
}

/**
 * Controllo se la richiesta è di tipo POST
 * Se sì, eseguo il login dell'utente
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController();
    $data = [
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];
    $userController->login($data);
}

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Login</h1>
        <form action="./login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>