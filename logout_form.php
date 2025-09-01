<?php
    require 'db_connect.php';
    if ($_SESSION['user_type'] == 'organiser'){
    
        addLog('Logout (Organiser)', $_SESSION['organiser_username'] . ' logged out');

    } else if ($_SESSION['user_type'] == 'volunteer') {

        addLog('Logout (Volunteer)', $_SESSION['volunteer_email'] . ' logged out');
    }
    session_start(); //intialises the session
    session_destroy(); //destroys session
    header('Location: login_form.php');
?>