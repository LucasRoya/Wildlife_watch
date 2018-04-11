<?php
   try {
    // connection to the database.
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host=mysql.info.unicaen.fr;dbname=21400116_bd;port=3306;charset=utf8mb4','21400116','Osei2mie3AGhaequ');

    // Execute SQL request on the database.
    $request = 'SELECT * FROM ANIMALS';
    $stmt = $bdd->prepare($request);
    $stmt->execute();
    $res = $stmt->fetchAll();
    } 
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

// Print JSON encode of the array.
echo(json_encode($res));
?>