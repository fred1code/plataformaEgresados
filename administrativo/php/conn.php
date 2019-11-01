<?php 
    $dsn = 'mysql:dbname=egresados;host=127.0.0.1';
    $user = 'root';
    $password = '';

    
    try {
        $pdo = new PDO ($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8");
    } catch (PDOException $e) {
	   echo 'Error al conectarnos'. $e -> getMessage();
    }
?>