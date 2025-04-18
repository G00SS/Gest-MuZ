<?php ##########################################################################
# @Name : grp-del.php
# @Description : Script de suppression d'un groupe
# @Call : rec-grp.php
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
    $grp_id = $_GET['id'];
    $req = $dbh->prepare('DELETE FROM tgrp WHERE tgrp.id='.$grp_id);
    $req->execute();

    // Redirection du visiteur vers la page de création des réseau
    header('Location: ../index.php?page=rec&subpage=grp');
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Redirection du visiteur vers la page de création des réseau
    header('Location: ../index.php?page=rec&subpage=grp');
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>