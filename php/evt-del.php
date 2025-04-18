<?php ##########################################################################
# @Name : evt-del.php
# @Description : Script de suppression d'un évenement
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


if (isset($_GET['id'])) {
    $id_evt = $_GET['id'];
    $req = $dbh->prepare('DELETE FROM tconf_evts WHERE tconf_evts.id='.$id_evt);
    $req->execute();

    // Redirection du visiteur vers la page de création des réseau
    //header('Location: ../index.php?page=net&subpage=adm');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Redirection du visiteur vers la page de création des réseau
    //header('Location: ../index.php?page=net&subpage=adm');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>