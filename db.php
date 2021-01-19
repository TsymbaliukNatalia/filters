<?php
$pdo = new PDO('mysql:host=localhost;dbname=dz_1_clothes;charset=utf8', 'root', '');

$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES=>false];
?>