<?php ##########################################################################
# @Name : evt-add.php
# @Description : Script de modification ou d'ajout d'un evenement
# @Call : param-evt.php
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
	// Mise à jour des informations sur le nouvel événement à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_evts SET tconf_evts.name = ?, tconf_evts.deb = ?, tconf_evts.fin = ? WHERE tconf_evts.id = ' . $_GET['id']);
    $req->execute(array($_POST['name'], $_POST['dateFrom'], $_POST['dateTo']));
} else {
	// Insertion des informations sur la nouvelle evtssition à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_evts (name, deb, fin) VALUES(?, ?, ?)');
	$req->execute(array($_POST['name'], $_POST['dateFrom'], $_POST['dateTo']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
