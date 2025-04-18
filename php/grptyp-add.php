<?php ##########################################################################
# @Name : grptyp-add.php
# @Description : Script de modification ou d'ajout d'un type de groupe
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

if (isset($_POST['id_grp']) and (!empty($_POST['id_grp']))) {
	if (empty($_POST['scol'])) {
		$_POST['scol'] = 0;
	}
	// Mise à jour des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_grp_typ SET tconf_grp_typ.type = ?, tconf_grp_typ.scol = ? WHERE tconf_grp_typ.id = ' . $_POST['id_grp']);
    $req->execute(array($_POST['name'],$_POST['scol']));
} else {
	if (empty($_POST['scol'])) {
		$_POST['scol'] = 0;
	}
	// Insertion des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_grp_typ (type,scol) VALUES(?, ?)');
	$req->execute(array($_POST['name'], $_POST['scol']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
