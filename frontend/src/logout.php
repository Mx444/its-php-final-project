<?php
function logout()
{
    session_destroy();
    header('Location: ./login.php');
    exit();
}
