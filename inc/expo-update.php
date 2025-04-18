<?php ##########################################################################
# @Name : expo-update.php
# @Description : Formulaire de modification / suppression des expositions
# @Call : param-expo.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// ### Récupération des infos de la table tconf_expo pour l'exposition qui nous intéresse ###
$req = $dbh->prepare('SELECT tconf_expo.id as "ID", tconf_expo.name as "Nom", tconf_expo.sect_id AS "Secteur", tconf_expo.deb as "Début", tconf_expo.fin as "Fin" FROM `tconf_expo` WHERE tconf_expo.id ='.$id_expo);
$req->execute();
$donnees = $req->fetch();


if ($req->rowCount() > 0) {
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_expo = $donnees[0];
  $name_expo = $donnees[1];
  $sect_expo = $donnees[2];
  $deb_expo = $donnees[3];
  $fin_expo = $donnees[4];
  // Termine le traitement de la requête
  $req->closeCursor();
  ?>

  <form method="post" action ="./php/expo-add.php?id=<?php echo($id_expo); ?>">
    <div class="card h-100 shadow">
      <div class="card-header bg-warning">
        <h3 class="card-title fw-bold text-center">Modifier l'Exposition :</h3>
        <h4 class="text-center">" <?php echo($name_expo); ?> "</h4>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="input-group mb-3">
              <span class="input-group-text" id="dateFrom">Depuis le :</span>
              <input type="date" name="dateFrom" value="<?php echo ($deb_expo); ?>" />
              <span class="input-group-text"> jusqu'au : </span>
              <input type="date" name="dateTo" value="<?php echo ($fin_expo); ?>" />
              <span class="input-group-text">  </span>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="input-group mb-3">
            <span class="input-group-text" id="name">Nom</span>
            <input type="text" class="form-control" name="name" value="<?php echo ($name_expo);?>" placeholder="Nom de l'exposition" aria-describedby="name_expo" autocomplete="off">
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="input-group mb-3">
            <label class="input-group-text" for="secteur">Secteur</label>
            <select class="form-select" name="secteur" id="secteur">
              <!-- On créer un menu déroulant pour les Secteurs -->
              <?php
              // On récupère tout le contenu de la table tconf_secteurs
              $reponse = $dbh->query('SELECT * FROM tconf_secteurs');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              {
              ?>
              <option value=<?php echo $donnees['id']; ?> <?php if ($donnees['id'] == $sect_expo) {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
              <?php
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-3 d-md-flex justify-content-evenly">
            <input type="submit" value="MODIFIER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=expo" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
            <a  class="btn btn-danger" title="Supprimer le réseau" data-bs-toggle="modal" data-bs-target="#ModalConfirm">SUPPRIMER</a>
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
        <a type="button" class="btn btn-danger" href="./php/expo-del.php?id=<?php echo($id_expo); ?>" id="expodel" title="Supprimer l'exposition">SUPPRIMER</a>
      </div>
    </div>
  </div>
</div>