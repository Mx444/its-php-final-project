<?php

/**
 * La classe DatabaseService gestisce la connessione al database MySQL
 * utilizzando il pattern Singleton, in modo che la connessione venga 
 * stabilita una sola volta e riutilizzata per tutte le query.
 */
class DatabasePDO
{
    /**
     * Variabile statica che memorizza la connessione PDO.
     * Viene inizializzata solo una volta e riutilizzata per tutte le query.
     * @var PDO|null
     */
    private static $connection = null;

    /**
     * Ottiene la connessione al database.
     * Se la connessione non esiste ancora, viene creata una nuova connessione.
     * @return PDO La connessione PDO al database.
     */
    public static function getConnection(): PDO
    {
        // Se la connessione non è già stata creata, creala.
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }

        // Restituisce la connessione esistente.
        return self::$connection;
    }

    /**
     * Crea una nuova connessione al database MySQL.
     * Usa i dettagli di connessione come host, nome utente, password e nome del database.
     * Utilizza anche le opzioni PDO per gestire gli errori e le modalità di fetch.
     * @return PDO La connessione PDO al database.
     * @throws PDOException Se la connessione non può essere stabilita.
     */
    private static function createConnection(): PDO
    {
        // Dettagli di connessione al database.
        $host = "localhost";          // Host del database (in questo caso localhost).
        $username = "mors";           // Nome utente per il database.
        $password = "serfrancesco";   // Password per l'utente del database.
        $dbname = "scuola";             // Nome del database a cui connettersi.


        // DSN (Data Source Name) per la connessione al database.
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            // Crea una nuova connessione PDO con le opzioni specificate.
            $pdo = new PDO(dsn: $dsn, username: $username, password: $password, options: [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Gestisce gli errori con eccezioni.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Imposta il fetch mode a "associativo".
                PDO::ATTR_PERSISTENT => true                         // Connessione persistente.
            ]);

            // Restituisce la connessione PDO creata.
            return $pdo;
        } catch (PDOException $error) {
            // In caso di errore nella connessione, termina l'esecuzione e mostra il messaggio di errore.
            die("Connection failed: " . $error->getMessage());
        }
    }

    // Impedisce la clonazione dell'istanza (non può essere duplicata)
    private function __clone() {}

    // Impedisce l'uso di unserialize per evitare la duplicazione
    public function __wakeup() {}
}
