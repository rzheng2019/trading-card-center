<?php
    $dsn = 'mysql:host=localhost;dbname=card_db';
    $username = 'card_user';
    $password = 'card_pass';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }