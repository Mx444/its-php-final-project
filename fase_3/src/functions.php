<?php

include_once "./config/database.php";

/**
 * Crea un nuovo utente nel database con il nome utente, l'email e la password specificati.
 * @param string $username Il nome utente dell'utente.
 * @param string $email L'email dell'utente.
 * @param string $password hashata La password dell'utente.
 * @throws Exception Se si verifica un errore durante la creazione dell'utente.
 */
function createUser(string $username, string $email, string $password): ?int
{
    try {
        $pdo = createConnection();
        $query = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
        return $pdo->lastInsertId() ?: null;
    } catch (PDOException $e) {
        throw new Exception('Errore durante la creazione dell\'utente: ' . $e->getMessage());
    }
}

/**
 * Trova tutti gli utenti nel database e restituisce un array di utenti.
 * @return array Un array di utenti con i loro dettagli.
 * @throws Exception Se si verifica un errore durante la ricerca degli utenti.
 */
function getUsers(): array
{
    $pdo = createConnection();
    try {
        $query = 'SELECT * FROM users';
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Errore durante la ricerca degli utenti: ' . $e->getMessage());
    }
}

/* Aggiorna il nome utente di un utente esistente nel database.
* @param int $id L'ID dell'utente da aggiornare.
* @param string $newUsername Il nuovo nome utente da assegnare.
* @throws Exception Se si verifica un errore durante l'aggiornamento dell'utente.
*/
function updateUser(int $id, string $newUsername): bool
{
    try {
        $pdo = createConnection();
        $query = 'UPDATE users SET username = :username WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id, 'username' => $newUsername]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw new Exception('Errore durante l\'aggiornamento dell\'utente: ' . $e->getMessage());
    }
}

/**
 * Elimina un utente esistente dal database.
 * @param int $id L'ID dell'utente da eliminare.
 * @throws Exception Se si verifica un errore durante l'eliminazione dell'utente.
 */
function deleteUser(int $id): bool
{
    try {
        $pdo = createConnection();
        $query = 'DELETE FROM users WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw new Exception('Errore durante l\'eliminazione dell\'utente: ' . $e->getMessage());
    }
}
