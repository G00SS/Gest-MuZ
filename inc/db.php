<?php ##########################################################################
# @Name : db.php
# @Description : paramètres de connexion à la base de donnée
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<?php
// Connexion à la base de données
try {

	$dbh = new PDO('mysql:host=localhost;dbname=bmus;charset=utf8', 'gestmuz', 'Xray@36sc');
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}
?>

