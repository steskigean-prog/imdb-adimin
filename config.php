<?php
    $host = "localhost";
    $db = "mbr-admin"; 
    $user = "root"; 
    $pass = "";

try { 
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass); 
} catch (PDOException $e) {
     die("Erro na conexão: " . $e->getMessage()); 
}