<?php ##########################################################################
# @Name : indiv-del.php
# @Description : Script de suppression d'une visite individuelle
# @Call : rec-indiv.php
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
    $indiv_id = $_GET['id'];
    $req = $dbh->prepare('DELETE FROM tindiv WHERE tindiv.id='.$indiv_id);
    $req->execute();

    // Redirection du visiteur vers la page de création des réseau
    header('Location: ../index.php?page=rec&subpage=indiv');
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Redirection du visiteur vers la page de création des réseau
    header('Location: ../index.php?page=rec&subpage=indiv');
    //header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>