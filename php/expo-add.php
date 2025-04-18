<?php ##########################################################################
# @Name : expo-add.php
# @Description : Script de modification ou d'ajout d'une exposition
# @Call : param-expo.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// connection à la BDD
require '../inc/db.php';

if (isset($_GET['id']) and (!empty($_GET['id']))) {
	// Mise à jour des informations de l'exposition à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_expo SET tconf_expo.name = ?, tconf_expo.sect_id = ?, tconf_expo.deb = ?, tconf_expo.fin = ? WHERE tconf_expo.id = ' . $_GET['id']);
    $req->execute(array($_POST['name'], $_POST['secteur'], $_POST['dateFrom'], $_POST['dateTo']));
} else {
	// Insertion des informations sur la nouvelle exposition à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_expo (name, sect_id, deb, fin) VALUES(?, ?, ?, ?)');
	$req->execute(array($_POST['name'], $_POST['secteur'], $_POST['dateFrom'], $_POST['dateTo']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
