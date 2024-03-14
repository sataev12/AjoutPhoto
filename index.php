<?php


require './bdd.php';



if(isset($_FILES['file'])) {
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $type = $_FILES['file']['type'];

    $tabExtention = explode('.', $name);
    $extention = strtolower(end($tabExtention));

    //Tableau des extensions qu'on autorise
    $extentionsAutorisees = ['jpg', 'jpeg', 'gif', 'png'];
    $tailleMax = 40000000;

   
 
    if(in_array($extention, $extentionsAutorisees) && $size <= $tailleMax && $error == 0) {


        $uniqueName = uniqid('', true);
        $fileName = $uniqueName.'.'.$extention;

        var_dump($fileName);

        move_uploaded_file($tmpName, './upload/'.$fileName);

        $req = $db->prepare('INSERT INTO file (name) VALUES (?)');
        $req->execute([
            $fileName
        ]);

        echo 'Image enregistrée';
    }
    else{
        echo 'Mauvaise extention ou taille trop important ou erreur';
    }

    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <label for="file">Fichier</label>
        <input type="file" name="file">
        <button type="submit">Enregistrer</button>
    </form>   
    
    <h2>Mes images</h2>

    <?php
        $req = $db->query('SELECT * from file');

        while ($data = $req->fetch()) {
            echo '<img src="./upload/'.$data['name'].'">';
        }

    ?>


</body>
</html>