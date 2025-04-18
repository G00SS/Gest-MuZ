<?php ##########################################################################
# @Name : sect-add.php
# @Description : Script de modification ou d'ajout d'un secteur
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

if (isset($_POST['id_sect']) and (!empty($_POST['id_sect']))) {
	// Mise à jour des informations sur la nouvelle exposition à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_secteurs SET tconf_secteurs.name = ?, tconf_secteurs.class = ?  WHERE tconf_secteurs.id = ' . $_POST['id_sect']);
    $req->execute(array($_POST['name'], $_POST['classecss']));
} else {
	// Insertion des informations sur la nouvelle exposition à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_secteurs (name, class) VALUES(?, ?)');
	$req->execute(array($_POST['name'], $_POST['classecss']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
