<?php ##########################################################################
# @Name : age-add.php
# @Description : Script de modification ou d'ajout d'une classe d'âges
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

if (isset($_POST['id_sociage']) and (!empty($_POST['id_sociage']))) {
	// Mise à jour des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('UPDATE tsoci_ages SET tsoci_ages.age = ?, tsoci_ages.name = ? WHERE tsoci_ages.id = ' . $_POST['id_sociage']);
    $req->execute(array($_POST['ages'],$_POST['sociagenom']));
} else {
	// Insertion des informations sur la nouvelle motivation à l'aide d'une requête préparée
	$req = $dbh->prepare('INSERT INTO tsoci_ages (age,name) VALUES(?, ?)');
	$req->execute(array($_POST['ages'], $_POST['sociagenom']));
}

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
