<?php ##########################################################################
# @Name : users-del.php
# @Description : Script de suppression d'un utilisateur
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


if (isset($_GET['id'])) {
    $req = $dbh->prepare('DELETE FROM tconf_users WHERE tconf_users.id='.$_GET['id']);
    $req->execute();

    // Redirection du visiteur vers la page d'où il vient
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    // Redirection du visiteur vers la page d'où il vient
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>