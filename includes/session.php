<?php

session_start();
$token_padrao = MD5(MD5('quaestum') . $_SESSION['email'] . date("dmy"));

if ($_SESSION['email']) {
    if ($_SESSION['token'] == $token_padrao) {
        if ($_SESSION["autenticacao"] == 1) {
        } else {
            header('Location: ./login.php');
        }
        
    } else {
        header('Location: ./login.php');
    }
} else {
    header('Location: ./login.php');
}
