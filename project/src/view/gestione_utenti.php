<?php
include_once '../controller/UserController.php';
session_start();
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
if (!$isAdmin) {
    header('Location: ./dashboard.php');
    exit();
}

$userController = new UserController();
$users = $userController->getUsers();

/**
 * Questo array definisce le azioni che possono essere eseguite
 * sulla base dei dati inviati dal form.
 */
$actions = [
    'createUser' => ['username', 'email', 'password'],
    'updateUser' => ['id', 'newUsername'],
    'deleteUser' => ['id']
];

/**
 * Esegue l'azione appropriata in base ai dati inviati dal form.
 */
foreach ($actions as $action => $fields) {
    if (isset($_POST[$action])) {
        $dto = [];
        foreach ($fields as $field) {
            $dto[$field] = $_POST[$field];
        }
        $userController->$action($dto);
    }
}

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Gestione Utenti</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <h1 class="my-4">Gestione Utenti</h1>
    <h2>Utenti</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="text" name="newUsername" placeholder="Nuovo username" class="form-control mb-2">
                            <button type="submit" name="updateUser" class="btn btn-primary btn-sm">Aggiorna</button>
                        </form>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button type="submit" name="deleteUser" class="btn btn-danger btn-sm">Elimina</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Crea Utente</h2>
    <form method="post" class="mb-4">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" class="form-control">
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password" class="form-control">
        </div>
        <button type="submit" name="createUser" class="btn btn-success">Crea</button>
    </form>
</body>

</html>