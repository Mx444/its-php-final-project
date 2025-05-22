<?php

include_once "./functions.php";

$users = getUsers();

if (isset($_POST['createUser'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        createUser($username, $email, $password);
        header("Location: gestione_utenti.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if (isset($_POST['updateUser'])) {
    $id = $_POST['id'];
    $newUsername = $_POST['newUsername'];

    try {
        updateUser($id, $newUsername);
        header("Location: gestione_utenti.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

if (isset($_POST['deleteUser'])) {
    $id = $_POST['id'];

    try {
        deleteUser($id);
        header("Location: gestione_utenti.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="mb-4">Gestione Utenti</h1>

    <h2>Aggiungi Utente</h2>
    <form action="gestione_utenti.php" method="post" class="mb-4">
        <div class="form-group">
            <label for="username">Nome Utente:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="createUser" class="btn btn-primary">Aggiungi Utente</button>
    </form>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <h2>Utenti</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Utente</th>
                <th>Email</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <form action="gestione_utenti.php" method="post" class="form-inline">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="text" name="newUsername" placeholder="Nuovo Nome Utente" class="form-control mr-2" required>
                            <button type="submit" name="updateUser" class="btn btn-warning mr-2">Aggiorna</button>
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
</body>

</html>