<?php

try{
    $db = new PDO('mysql:host=localhost;dbname=upload_file', 'root', 'root');
}
catch(PDOException $e){
    die('Erreur sur la base des données : '.$e->getMessage());
}