<?php ##########################################################################
# @Name : public-add.php
# @Description : Script de modification ou d'ajout d'un type de public
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

if (isset($_POST['id_public']) and (!empty($_POST['id_public']))) {
	// Mise à jour des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tconf_publics SET tconf_publics.name = ?, tconf_publics.age = ?, tconf_publics.scol = ? WHERE tconf_publics.id = ' . $_POST['id_public']);
    $req->execute(array($_POST['name'], $_POST['grpages'], $_POST['scol']));
} else {
	// Insertion des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tconf_publics (name,age,scol) VALUES(?, ?, ?)');
	$req->execute(array($_POST['name'], $_POST['grpages'], $_POST['scol']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
