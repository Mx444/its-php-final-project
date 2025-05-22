<?php
include_once './config/database.php';
/*
    * Questo script permette di effettuare il login
    * 
    * Se l'utente è già autenticato, viene reindirizzato alla dashboard
    * 
    * Se l'utente ha inviato il form di login, viene effettuato il login
    * e reindirizzato alla dashboard
    */
session_start();
$isAuthenticated = isset($_SESSION['user']);
if ($isAuthenticated) {
    header("Location: ./dashboard.php");
    exit();
}

/**
 * Effettua il login
 */
function login(string $username, string $password)
{
    $pdo = createConnection();
    $query = 'SELECT * FROM users WHERE username = :username';
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login($username, $password)) {
        header('Location: ./dashboard.php');
        exit();
    }
    $error = 'Username o password non validi';
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