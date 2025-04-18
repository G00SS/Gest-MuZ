<?php ##########################################################################
# @Name : perso-add.php
# @Description : Script de modification de la personnalisation de la structure
# @Call : param-perso.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// connection à la BDD
require '../inc/db.php';

if (isset($_POST['indivpay'])) {
	$indivpay = 1;
} else {
	$indivpay = 0;
}

if (isset($_POST['indivgui'])) {
	$indivgui = 1;
} else {
	$indivgui = 0;
}

if (isset($_POST['grppay'])) {
	$grppay = 1;
} else {
	$grppay = 0;
}

if (isset($_POST['grpgui'])) {
	$grpgui = 1;
} else {
	$grpgui = 0;
}

// Mise à jour des informations sur la nouvelle personnalisation de la structure à l'aide d'une requête préparée
$req = $dbh->prepare('UPDATE tconf_param SET tconf_param.structure = ?, tconf_param.resident = ?, tconf_param.collectivite = ?, tconf_param.d_dept = ?, tconf_param.d_pays = ?, tconf_param.infos = ?, tconf_param.indivpay = ?, tconf_param.indivgui = ?, tconf_param.grppay = ?, tconf_param.grpgui = ? WHERE tconf_param.id = 1');
$req->execute(array($_POST['struct'], $_POST['resi'], $_POST['coll'], $_POST['dept'], $_POST['pays'], $_POST['infos'],$indivpay,$indivgui,$grppay,$grpgui));


// On récupère tout le contenu de la table tconf_days
$reponse = $dbh->query('SELECT * FROM tconf_days');
// On affiche chaque entrée une à une

$daysnull = [];
while ($donnees = $reponse->fetch()) {
	$daysnull[$donnees['id']]=0;
}
// Termine le traitement de la requête
$reponse->closeCursor();

foreach ($_POST['work'] as $key => $valeur) {
   $daysnull[$key] = $valeur;
}
// Mise à jour des jours ouvrés à l'aide d'une requête préparée
foreach ($daysnull as $key => $valeur) {
	$req = $dbh->prepare('UPDATE tconf_days SET tconf_days.work = ? WHERE tconf_days.id = ?');
	$req->execute(array($valeur, $key));
}

// Mise à jour des heures d'ouverture à l'aide d'une requête préparée
foreach ($_POST['open'] as $key => $valeur) {
	$req = $dbh->prepare('UPDATE tconf_days SET tconf_days.open = ? WHERE tconf_days.id = ?');
	$req->execute(array($valeur, $key));
}

// Mise à jour des heures de fermetures à l'aide d'une requête préparée
foreach ($_POST['close'] as $key => $valeur) {
	$req = $dbh->prepare('UPDATE tconf_days SET tconf_days.close = ? WHERE tconf_days.id = ?');
	$req->execute(array($valeur, $key));
}

// Mise à jour de l'amplitude horaire de la structure à l'aide d'une requête préparée
$req = $dbh->prepare('SELECT MIN(TIME_FORMAT(tconf_days.open, "%H:%i")) AS minH, MAX(TIME_FORMAT(tconf_days.close, "%H:%i")) AS maxH FROM `tconf_days` WHERE tconf_days.work = 1');
$req->execute();
$donnees = $req->fetch();

$req = $dbh->prepare('UPDATE tconf_param SET tconf_param.ouverture = ?, tconf_param.fermeture = ? WHERE tconf_param.id = 1');
$req->execute(array($donnees[0], $donnees[1]));

//echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
