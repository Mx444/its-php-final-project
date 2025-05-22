<?php
include_once '../config/database.php';

/**
 * La classe UserModel gestisce le operazioni relative agli utenti
 * nel database. Questo include la creazione di nuovi utenti, la
 * ricerca di utenti esistenti e l'aggiornamento dei dati degli utenti.
 */
class UserModel
{
    private PDO $pdo;

    /**
     * Crea una nuova istanza del modello utente.
     * @param PDO $pdo La connessione al database.
     */
    public function __construct()
    {
        $this->pdo = DatabasePDO::getConnection();
        $this->createDatabase();
    }

    /**
     * Crea il database e la tabella degli utenti se non esistono già.
     */
    private function createDatabase(): void
    {
        try {
            $this->pdo->exec('CREATE DATABASE IF NOT EXISTS scuola');
            $this->pdo->exec('USE scuola');
            $this->pdo->exec('CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                email VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT "user"
            )');
            $this->pdo->exec('ALTER TABLE users ADD COLUMN IF NOT EXISTS role VARCHAR(50) NOT NULL DEFAULT "user"');
        } catch (PDOException $e) {
            throw new Exception('Errore durante la creazione del database: ' . $e->getMessage());
        }
    }
    /**
     * Crea un nuovo utente nel database con il nome utente, l'email e la password specificati.
     * @param string $username Il nome utente dell'utente.
     * @param string $email L'email dell'utente.
     * @param string $password hashata La password dell'utente.
     * @throws Exception Se si verifica un errore durante la creazione dell'utente.
     */
    public function create(string $username, string $email, string $password, string $role): ?int
    {
        try {
            $query = 'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role
            ]);
            return $this->pdo->lastInsertId() ?: null;
        } catch (PDOException $e) {
            throw new Exception('Errore durante la creazione dell\'utente: ' . $e->getMessage());
        }
    }

    /**
     * Trova un utente nel database con il nome utente specificato.
     * @param string $username Il nome utente dell'utente da cercare.
     * @return array|null I dettagli dell'utente se trovato, altrimenti null.
     * @throws Exception Se si verifica un errore durante la ricerca dell'utente.
     */
    public function findOne(string $username)
    {
        try {
            $query = 'SELECT * FROM users WHERE username = :username';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Errore durante la ricerca dell\'utente: ' . $e->getMessage());
        }
    }

    /**
     * Trova tutti gli utenti nel database e restituisce un array di utenti.
     * @return array Un array di utenti con i loro dettagli.
     * @throws Exception Se si verifica un errore durante la ricerca degli utenti.
     */
    public function findMany(): array
    {
        try {
            $query = 'SELECT * FROM users';
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Errore durante la ricerca degli utenti: ' . $e->getMessage());
        }
    }

    /**
     * Aggiorna il nome utente di un utente esistente nel database.
     * @param int $id L'ID dell'utente da aggiornare.
     * @param string $newUsername Il nuovo nome utente da assegnare.
     * @throws Exception Se si verifica un errore durante l'aggiornamento dell'utente.
     */
    public function update(int $id, string $newUsername): bool
    {
        try {
            $query = 'UPDATE users SET username = :username WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
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
    public function delete(int $id): bool
    {
        try {
            $query = 'DELETE FROM users WHERE id = :id';
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception('Errore durante l\'eliminazione dell\'utente: ' . $e->getMessage());
        }
    }
}
