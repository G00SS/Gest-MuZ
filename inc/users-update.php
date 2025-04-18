<?php ##########################################################################
# @Name : users-update.php
# @Description : Formulaire de modification / suppression des utilisateurs
# @Call : param-users.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// ### Récupération des infos de la table tconf_atel_them pour l'atelier qui nous intéresse ###
$req = $dbh->prepare('SELECT * FROM `tconf_users` WHERE tconf_users.id ='.$id_user);
$req->execute();
$donnees = $req->fetch();


if ($req->rowCount() > 0) {
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_user = $donnees[0];
  $name_user = $donnees[1];
  $role_user = $donnees[3];
  // Termine le traitement de la requête
  $req->closeCursor();
  ?>

  <form method="post" action ="./php/users-add.php?id=<?php echo($id_user); ?>">
    <div class="card h-100 shadow">
      <div class="card-header bg-warning">
        <h3 class="card-title fw-bold text-center">Modifier l'utilisateur :</h3>
        <h4 class="text-center">" <?php echo($name_user); ?> "</h4>
      </div>
      <div class="card-body">

        <div class="row justify-content-evenly">
           <?php  
           if(isset($_SESSION['errormodif']))  
           {  
                echo '<p class="text-danger text-center">'.$_SESSION['errormodif'].'</p>';
                unset($_SESSION['errormodif']); 
           }  
           ?>
           <?php  
           if(isset($_SESSION['modif']))  
           {  
                echo '<p class="text-success text-center">'.$_SESSION['modif'].'</p>';
                unset($_SESSION['modif']); 
           }  
           ?>
          <!-- Nom de l'utilisateur -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="username">Utilisateur</span>
              <input type="text" class="form-control" name="username" value="<?php echo($name_user); ?>" placeholder="Nom d'Utilisateur" aria-describedby="username" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Mot de passe -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="password">Mot de Passe</span>
              <input type="password" class="form-control" name="password" value="" placeholder="Nouveau Mot de Passe" aria-describedby="password" autocomplete="off">
            </div>
          </div>
          <!-- Confirmation -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="confirm">Confirmation</span>
              <input type="password" class="form-control" name="confirm" value="" placeholder="Confirmez le Mot de Passe" aria-describedby="confirm" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="d-grid gap-2 d-md-flex justify-content-evenly">
            <input type="radio" class="btn-check" name="role" id="option1add" value="1" <?php if ($role_user==1) echo "checked"; ?> autocomplete="off">
            <label class="btn btn-outline-secondary" for="option1add">Administrateur</label>

            <input type="radio" class="btn-check" name="role" id="option2add" value="2" <?php if ($role_user==2) echo "checked"; ?> autocomplete="off">
            <label class="btn btn-outline-secondary" for="option2add">Superviseur</label>

            <input type="radio" class="btn-check" name="role" id="option3add" value="3" <?php if ($role_user==3) echo "checked"; ?> autocomplete="off">
            <label class="btn btn-outline-secondary" for="option3add">Utilisateur</label>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-3 d-md-flex justify-content-evenly">
            <input type="submit" value="MODIFIER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=users" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
            <a  class="btn btn-danger" title="Supprimer l'utilisateur'" data-bs-toggle="modal" data-bs-target="#ModalConfirm">SUPPRIMER</a>
          </div>
        </div>
      </div>
    </div>
  </form>

<?php
}
?>

<!-- Modal Supression-->
<div class="modal fade" id="ModalConfirm" tabindex="-1" aria-labelledby="ModalConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white bg-danger">
        <h4 class="modal-title fw-bold text-center" id="ModalConfirmLabel">Voulez-vous Supprimer ?</h4>
        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="fw-bold text-center">&#10060    Cette action ne pourra plus être annulée.    &#10060</p>
      </div>
      <div class="modal-footer justify-content-evenly">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la Suppression">ANNULER</button>
        <a type="button" class="btn btn-danger" href="./php/users-del.php?id=<?php echo($id_user); ?>" id="userdel" title="Supprimer l'utilisateur">SUPPRIMER</a>
      </div>
    </div>
  </div>
</div>