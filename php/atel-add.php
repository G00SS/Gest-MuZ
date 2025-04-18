<?php ##########################################################################
# @Name : users-add.php
# @Description : Script de modification ou d'ajout d'un utilisateur
# @Call : param-users.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// connection à la BDD
require '../inc/db.php';

if (isset($_POST['seance']) and empty($_POST['seance'])) {
	$_POST['seance'] = 1;
}

//echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';

if (isset($_GET['id']) and (!empty($_GET['id']))) {
	// Mise à jour des informations de l'atelier à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_atel SET tconf_atel.name = ?, tconf_atel.sect_id = ?, tconf_atel.public_id = ?, tconf_atel.seance = ?, tconf_atel.deb = ?, tconf_atel.fin = ? WHERE tconf_atel.id = ' . $_GET['id']);
    $req->execute(array($_POST['name'], $_POST['sect'], $_POST['public'], $_POST['seance'], $_POST['dateFrom'], $_POST['dateTo']));
} else {
	// Insertion des informations sur le nouvel atelier à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_atel (name, sect_id, public_id, seance, deb, fin) VALUES(?, ?, ?, ?, ?, ?)');
	$req->execute(array($_POST['name'], $_POST['sect'], $_POST['public'], $_POST['seance'], $_POST['dateFrom'], $_POST['dateTo']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
