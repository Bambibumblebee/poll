<?php
require('config/config.php');
try {
    $connection = new PDO("mysql:host=".HOST, USERNAME, PASSWORD, $options);
    $connection->exec("SET NAMES utf8"); // SQL lause et täpitähed jääks mõistlikuks
    $sql = file_get_contents('config/questions.sql'); //sisu lugemine 
    $connection->exec($sql); //teeb andmebaasi, tabeli ja lisab kirjed

    echo '<p>Andmebaas ja tabel on loodud edukalt.</p>';
    echo '<a href="index.php">Avalehele</a>';

} catch (PDOException $error) {
    echo $error->getMessage(); 
}
?>