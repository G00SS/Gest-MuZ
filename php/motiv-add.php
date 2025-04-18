<?php ##########################################################################
# @Name : motiv-add.php
# @Description : Script de modification ou d'ajout d'une motivation
# @Call : param-conf.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// connection à la BDD
require '../inc/db.php';

if (isset($_POST['id_motiv']) and (!empty($_POST['id_motiv']))) {
	// Mise à jour des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tsoci_motiv SET tsoci_motiv.name = ? WHERE tsoci_motiv.id = ' . $_POST['id_motiv']);
    $req->execute(array($_POST['name']));
} else {
	// Insertion des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tsoci_motiv (name) VALUES(?)');
	$req->execute(array($_POST['name']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
