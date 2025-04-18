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
$req = $dbh->prepare('SELECT * FROM `tconf_atel` WHERE tconf_atel.id ='.$id_atel);
$req->execute();
$donnees = $req->fetch();


if ($req->rowCount() > 0) {
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_atel = $donnees[0];
  $name_atel = $donnees[1];
  $sect_atel = $donnees[2];
  $expo_atel = $donnees[3];
  $public_atel = $donnees[4];
  $seance_atel = $donnees[5];
  $deb_atel = $donnees[6];
  $fin_atel = $donnees[7];
  // Termine le traitement de la requête
  $req->closeCursor();
  ?>

  <form method="post" action ="./php/atel-add.php?id=<?php echo($id_atel); ?>">
    <div class="card h-100 shadow">
      <div class="card-header bg-warning">
        <h3 class="card-title fw-bold text-center">Modifier l'Atelier :</h3>
        <h4 class="text-center">" <?php echo($name_atel); ?> "</h4>
      </div>
      <div class="card-body">
        <!-- Dates de l'atelier -->
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="input-group mb-3">
              <span class="input-group-text" id="dateFrom">Du :</span>
              <input type="date" name="dateFrom" value="<?php echo ($deb_atel); ?>" />
              <span class="input-group-text"> Au : </span>
              <input type="date" name="dateTo" value="<?php echo ($fin_atel); ?>" />
              <span class="input-group-text">  </span>
            </div>
          </div>
        </div>

        <div class="row justify-content-evenly">
          <!-- Nom de l'atelier -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="name">Nom</span>
              <input type="text" class="form-control" name="name" value="<?php echo ($name_atel);?>" placeholder="Nom de l'atelier" aria-describedby="name_atel" autocomplete="off">
            </div>
          </div>
          <!-- Nombre de séance -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-4">
            <div class="input-group mb-3">
              <span class="input-group-text" id="seance">Scéances</span>
              <input type="number" class="form-control" name="seance"value="<?php echo ($seance_atel);?>" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Public -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-6">
            <div class="input-group mb-3">
              <label class="input-group-text" for="public">Public</label>
              <select class="form-select" id="public" name="public">
              <?php
              // On récupère tout le contenu de la table tconf_publics
              $reponse = $dbh->query('SELECT * FROM tconf_publics');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              { ?>
                <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $public_atel) {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
              <?php }
              $reponse->closeCursor(); // Termine le traitement de la requête
              ?>
              </select>
            </div>
          </div>
          <!-- Secteur -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-6">
            <div class="input-group mb-3">
              <label class="input-group-text" for="sect">Secteur</label>
              <select class="form-select" id="sect" name="sect">
                <?php
                // On récupère tout le contenu de la table tconf_secteurs
                $reponse = $dbh->query('SELECT * FROM tconf_secteurs');
                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch())
                { ?>
                  <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $sect_atel) {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
                <?php }
                $reponse->closeCursor(); // Termine le traitement de la requête
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-3 d-md-flex justify-content-evenly">
            <input type="submit" value="MODIFIER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=atel" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
            <a  class="btn btn-danger" title="Supprimer l'atelier'" data-bs-toggle="modal" data-bs-target="#ModalConfirm">SUPPRIMER</a>
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
        <a type="button" class="btn btn-danger" href="./php/atel-del.php?id=<?php echo($id_atel); ?>" id="ateldel" title="Supprimer l'atelier">SUPPRIMER</a>
      </div>
    </div>
  </div>
</div>