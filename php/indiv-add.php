<?php ##########################################################################
# @Name : indiv-add.php
# @Description : Script de modification ou d'ajout d'une visite individuelle
# @Call : vis-indiv.php ou edit-indiv.php
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

	$nb=$_POST['nb'];

	if (isset($_POST['primo'])) {
		$primo=1;
	} else {
		$primo=0;
	}

	$dept=$_POST['dept'];

	$pays=$_POST['pays'];
	if ($_POST['pays']!=62) {
		// On met le département sur Etrangers
		$dept=1;
	}

	if (!empty($_POST['zip']) AND (strlen((string)$_POST['zip'])==5)) {
		// On remplace les valeures de $pays et de $dept en fonction
		if (substr($_POST['zip'], 0, 2)==97) {
			$deptnb=substr($_POST['zip'], 0, 3);
		} else {
			$deptnb=substr($_POST['zip'], 0, 2);
		}
		// On récupère l'ID du dépt en fonction de son numéro
	    $req = $dbh->prepare('SELECT id FROM tloc_depts WHERE tloc_depts.nb LIKE ?');
	    $req->execute(array($deptnb));
	    $deptprov = $req->fetch();
	    $dept = $deptprov[0];
		$pays=62;
	}

	if (isset($_POST['col'])) {
		$col=1;
	} else {
		$col=0;
	}

	if (isset($_POST['resi'])) {
		$resi=1;
	} else {
		$resi=0;
	}

	$age=$_POST['age'];

	if (isset($_POST['famille'])) {
		$famille=1;
	} else {
		$famille=0;
	}

	if (isset($_POST['guide'])) {
		$guide=1;
	} else {
		$guide=0;
	}

	if (isset($_POST['payant'])) {
		$payant=1;
	} else {
		$payant=0;
	}

	$motiv=$_POST['motiv'];


	// Insertion des informations à l'aide d'une requête préparée Des infos des visiteurs
	$req = $dbh->prepare('UPDATE tindiv SET nb=?, primo=?, pays_id=?, depts_id=?, col=?, resi=?, grpage_id=?, famille=?, guide=?, payant=?, motiv_id=? WHERE tindiv.id = ?');
	$req->execute(array($nb, $primo, $pays, $dept, $col, $resi, $age, $famille, $guide, $payant, $motiv,$_GET['id']));

	// ############ INFORMATIONS SUR LA VISITE ################

	// Les Intérets des visiteurs
	if(is_array($_POST['secteurs'])){
		// ### Récupération des infos de la table tindiv_sect pour l'enregistrement qui nous intéresse ###
		$req = $dbh->prepare('SELECT tindiv_sect.sect_id FROM `tindiv_sect` WHERE tindiv_sect.indiv_id ='.$_GET['id']);
		$req->execute();
		$secteurs_indiv = $req->fetchAll(PDO::FETCH_COLUMN, 0);
		// Termine le traitement de la requête
		$req->closeCursor();
		// Les intérets ajoutés
		$int_add = array_diff($_POST['secteurs'], $secteurs_indiv);
		foreach($int_add as $sect_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_sect VALUES(?, ?)');
			$query->execute([$_GET['id'], $sect_id]);
		}
		// Les intérets supprimés
		$int_del = array_diff($secteurs_indiv,$_POST['secteurs']);
		foreach($int_del as $sect_id) {
			$query = $dbh->prepare('DELETE FROM tindiv_sect WHERE tindiv_sect.indiv_id=? AND tindiv_sect.sect_id=?');
			$query->execute([$_GET['id'], $sect_id]);
		}
	} else {
		$req = $dbh->prepare('DELETE FROM tindiv_sect WHERE tindiv_sect.indiv_id='.$_GET['id']);
		$req->execute();
		// Termine le traitement de la requête
		$req->closeCursor();
	}


	// Les Expositions des visiteurs
	if(is_array($_POST['expos'])){
		// ### Récupération des infos de la table tindiv_expo pour l'enregistrement qui nous intéresse ###
		$req = $dbh->prepare('SELECT tindiv_expo.expo_id FROM `tindiv_expo` WHERE tindiv_expo.indiv_id ='.$_GET['id']);
		$req->execute();
		$expos_indiv = $req->fetchAll(PDO::FETCH_COLUMN, 0);
		// Termine le traitement de la requête
		$req->closeCursor();
		// Les expos ajoutés
		$expo_add = array_diff($_POST['expos'], $expos_indiv);
		foreach($expo_add as $expo_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_expo VALUES(?, ?)');
			$query->execute([$_GET['id'], $expo_id]);
		}
		// Les expos supprimés
		$expo_del = array_diff($expos_indiv,$_POST['expos']);
		foreach($expo_del as $expo_id) {
			$query = $dbh->prepare('DELETE FROM tindiv_expo WHERE tindiv_expo.indiv_id=? AND tindiv_expo.expo_id=?');
			$query->execute([$_GET['id'], $expo_id]);
		}
	} else {
		$req = $dbh->prepare('DELETE FROM tindiv_expo WHERE tindiv_expo.indiv_id='.$_GET['id']);
		$req->execute();
		// Termine le traitement de la requête
		$req->closeCursor();
	}

	// Les Evenements des visiteurs
	if(is_array($_POST['evts'])){
		// ### Récupération des infos de la table tindiv_evt pour l'enregistrement qui nous intéresse ###
		$req = $dbh->prepare('SELECT tindiv_evts.evt_id FROM `tindiv_evts` WHERE tindiv_evts.indiv_id ='.$_GET['id']);
		$req->execute();
		$evts_indiv = $req->fetchAll(PDO::FETCH_COLUMN, 0);
		// Termine le traitement de la requête
		$req->closeCursor();
		// Les evenements ajoutés
		$evt_add = array_diff($_POST['evts'], $evts_indiv);
		foreach($evt_add as $evt_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_evts VALUES(?, ?)');
			$query->execute([$_GET['id'], $evt_id]);
		}
		// Les evenements supprimés
		$evt_del = array_diff($evts_indiv,$_POST['evts']);
		foreach($evt_del as $evt_id) {
			$query = $dbh->prepare('DELETE FROM tindiv_evts WHERE tindiv_evts.indiv_id=? AND tindiv_evts.evt_id=?');
			$query->execute([$_GET['id'], $evt_id]);
		}
	} else {
		$req = $dbh->prepare('DELETE FROM tindiv_evts WHERE tindiv_evts.indiv_id='.$_GET['id']);
		$req->execute();
		// Termine le traitement de la requête
		$req->closeCursor();
	}


} else { // ##### Insertion d'un nouvel enregistrement #####
	// ################### INFORMATIONS SUR LES VISITEURS #####################
	$nb=$_POST['nb'];

	if (isset($_POST['primo'])) {
		$primo=1;
	} else {
		$primo=0;
	}

	$dept=$_POST['dept'];

	$pays=$_POST['pays'];
	if ($_POST['pays']!=62) {
		// On met le département sur Etrangers
		$dept=1;
	}

	if (!empty($_POST['zip']) AND (strlen((string)$_POST['zip'])==5)) {
		// On remplace les valeures de $pays et de $dept en fonction
		if (substr($_POST['zip'], 0, 2)==97) {
			$deptnb=substr($_POST['zip'], 0, 3);
		} else {
			$deptnb=substr($_POST['zip'], 0, 2);
		}
		// On récupère l'ID du dépt en fonction de son numéro
	    $req = $dbh->prepare('SELECT id FROM tloc_depts WHERE tloc_depts.nb LIKE ?');
	    $req->execute(array($deptnb));
	    $deptprov = $req->fetch();
	    $dept = $deptprov[0];
		$pays=62;
	}

	if (isset($_POST['col'])) {
		$col=1;
	} else {
		$col=0;
	}

	if (isset($_POST['resi'])) {
		$resi=1;
	} else {
		$resi=0;
	}

	$age=$_POST['age'];

	if (isset($_POST['famille'])) {
		$famille=1;
	} else {
		$famille=0;
	}

	if (isset($_POST['guide'])) {
		$guide=1;
	} else {
		$guide=0;
	}

	if (isset($_POST['payant'])) {
		$payant=1;
	} else {
		$payant=0;
	}

	$motiv=$_POST['motiv'];


	// Insertion des informations à l'aide d'une requête préparée Des infos des visiteurs
	$req = $dbh->prepare('INSERT INTO tindiv (nb, primo, pays_id, depts_id, col, resi, grpage_id, famille, guide, payant, motiv_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
	$req->execute(array($nb, $primo, $pays, $dept, $col, $resi, $age, $famille, $guide, $payant, $motiv));

	// ############ INFORMATIONS SUR LA VISITE ################

	// On récupère l'ID de l'enregistrement
	$indiv_id = $dbh->lastInsertId();

	// Les Intérets des visiteurs
	if(is_array($_POST['secteurs'])){
		foreach($_POST['secteurs'] as $sect_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_sect VALUES(?, ?)');
			$query->execute([$indiv_id, $sect_id]);
		}
	}

	// Les Expositions des visiteurs
	if(is_array($_POST['expos'])){
		foreach($_POST['expos'] as $expo_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_expo VALUES(?, ?)');
			$query->execute([$indiv_id, $expo_id]);
		}
	}

	// Les évenements des visiteurs
	if(is_array($_POST['evts'])){
		foreach($_POST['evts'] as $evt_id) {
			$query = $dbh->prepare('INSERT INTO tindiv_evts VALUES(?, ?)');
			$query->execute([$indiv_id, $evt_id]);
		}
	}
}
// Redirection du visiteur vers la page depuis laquelle la fonction a été appellée
    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>