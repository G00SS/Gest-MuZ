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
session_start();
// connection à la BDD
require '../inc/db.php';


if (isset($_GET['id']) and (!empty($_GET['id']))) {
	if (isset($_POST['password']) AND ($_POST['password']!="")) {
		// Insertion des informations du nouvel utilisateur à l'aide d'une requête préparée
		$userid = $_GET['id'];
	    $username = htmlspecialchars(trim($_POST['username']));
	    $password = htmlspecialchars($_POST['password']);
	    $confirm = htmlspecialchars($_POST['confirm']);
	    $role = $_POST['role'];
	    // Validation simple
	    if ($password !== $confirm) {
	        $_SESSION['errormodif'] = "Les mots de passe ne correspondent pas.";
	    } else {
	        // Vérifie si l'utilisateur existe déjà
	        $check = $dbh->prepare("SELECT * FROM tconf_users WHERE username = ? AND id <> ?");
	        $check->execute([$username, $userid]);

	        if ($check->rowCount() > 0) {
	            $_SESSION['errormodif'] = "Nom d'utilisateur déjà utilisé.";
	        } else {
	            // Hash du mot de passe
	            $hashed = password_hash($password, PASSWORD_DEFAULT);

	            // Insertion
	            $stmt = $dbh->prepare("UPDATE tconf_users SET tconf_users.username = ?, tconf_users.password = ?, tconf_users.role = ? WHERE tconf_users.id = ?");
	            $stmt->execute([$username, $hashed, $role, $userid]);

	            $_SESSION['modif'] = "Modification effectuée";
	            header('Location: ' . $_SERVER['HTTP_REFERER']);
	            exit;
	        }
	    }
	} else {
		// Insertion des informations du nouvel utilisateur à l'aide d'une requête préparée
		$userid = $_GET['id'];
	    $username = htmlspecialchars(trim($_POST['username']));
	    $role = $_POST['role'];
        // Vérifie si l'utilisateur existe déjà
        $check = $dbh->prepare("SELECT * FROM tconf_users WHERE username = ? AND id <> ?");
        $check->execute([$username, $userid]);

        if ($check->rowCount() > 0) {
            $_SESSION['errormodif'] = "Nom d'utilisateur déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertion
            $stmt = $dbh->prepare("UPDATE tconf_users SET tconf_users.username = ?, tconf_users.role = ? WHERE tconf_users.id = ?");
            $stmt->execute([$username, $role, $userid]);

            $_SESSION['modif'] = "Modification effectuée";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
	}

} else {
	// Insertion des informations du nouvel utilisateur à l'aide d'une requête préparée
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    $confirm = htmlspecialchars($_POST['confirm']);
    $role = $_POST['role'];

    // Validation simple
    if ($password !== $confirm) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'utilisateur existe déjà
        $check = $dbh->prepare("SELECT * FROM tconf_users WHERE username = ?");
        $check->execute([$username]);

        if ($check->rowCount() > 0) {
            $_SESSION['error'] = "Nom d'utilisateur déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertion
            $stmt = $dbh->prepare("INSERT INTO tconf_users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashed, $role]);

            $_SESSION['success'] = "Inscription réussie. L'utilsateur peut maintenant se connecter.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}

//echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';

// Redirection du visiteur vers la page d'où il vient
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
