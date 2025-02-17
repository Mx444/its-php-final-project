<?php

function createConnection(): PDO
{
    // Dettagli di connessione al database.
    $host = "localhost";          // Host del database (in questo caso localhost).
    $username = "mors";           // Nome utente per il database.
    $password = "serfrancesco";   // Password per l'utente del database.
    $dbname = "";             // Nome del database a cui connettersi.

    // DSN (Data Source Name) per la connessione al database.
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    try {
        // Crea una nuova connessione PDO con le opzioni specificate.
        $pdo = new PDO(dsn: $dsn, username: $username, password: $password, options: [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Gestisce gli errori con eccezioni.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Imposta il fetch mode a "associativo".
            PDO::ATTR_PERSISTENT => true                       // Connessione persistente.
        ]);

        // Restituisce la connessione PDO creata.
        return $pdo;
    } catch (PDOException $error) {
        // In caso di errore nella connessione, termina l'esecuzione e mostra il messaggio di errore.
        die("Connection failed: " . $error->getMessage());
    }
}

/*
* Crea la tabella "users" nel database "scuola" se non esiste già.
*/
function createTable()
{
    $pdo = createConnection();
    $pdo->exec('CREATE DATABASE IF NOT EXISTS scuola');
    $pdo->exec('USE scuola');
    $pdo->exec('CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )');
}

createTable();
