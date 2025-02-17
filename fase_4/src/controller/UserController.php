<?php

include_once '../model/UserModel.php';

/**
 * La classe UserController gestisce le richieste relative agli utenti.
 * Questo include la creazione di nuovi utenti e la ricerca di utenti esistenti.
 */
class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Restituisce un array di tutti gli utenti nel database.
     * @return array Un array di tutti gli utenti nel database.
     */
    public function getUsers(): array
    {
        return $this->userModel->findMany();
    }

    /**
     * Crea un nuovo utente con i dati specificati.
     * @param array $dto I dati del nuovo utente.
     * @return int L'ID del nuovo utente.
     */
    public function createUser(array $dto)
    {
        try {
            $this->userModel->create($dto['username'], $dto['email'], $dto['password'], $dto['role']);
            header('Location: ./dashboard.php');
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            header('Location: ./dashboard.php');
            exit();
        }
    }

    /**
     * Esegue il login dell'utente con i dati specificati.
     * @param array $dto I dati dell'utente che sta effettuando il login.
     */
    public function login(array $dto)
    {
        try {
            $user = $this->userModel->findOne($dto['username']);
            if ($user && password_verify($dto['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: ./dashboard.php');
                exit();
            } else {
                header('Location: ./login.php');
                exit();
            }
        } catch (Exception $e) {
            header('Location: ./login.php');
            exit();
        }
    }
    /**
     * Aggiorna l'utente con l'ID specificato con il nuovo nome utente.
     * @param array $dto I dati dell'utente da aggiornare.
     */
    public function updateUser(array $dto)
    {
        try {
            $this->userModel->update($dto['id'], $dto['newUsername']);
            header('Location: ./gestione_utenti.php');
            exit();
        } catch (Exception $e) {
            http_response_code(500);
            header('Location: ./gestione_utenti.php');
            exit();
        }
    }

    /**
     * Elimina l'utente con l'ID specificato.
     * @param array $dto I dati dell'utente da eliminare.
     */
    public function deleteUser(array $dto)
    {
        try {
            $this->userModel->delete($dto['id']);
            header('Location: ./gestione_utenti.php');
            exit();
        } catch (Exception $e) {
            header('Location: ./gestione_utenti.php');
            exit();
        }
    }

    /**
     * Esegue il logout dell'utente.
     */
    public function logout()
    {
        session_destroy();
        header('Location: ./login.php');
        exit();
    }
}
