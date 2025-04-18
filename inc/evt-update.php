<?php ##########################################################################
# @Name : evt-update.php
# @Description : Formulaire de modification / suppression des evenements
# @Call : param-evt.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
// ### Récupération des infos de la table tconf_evts pour l'événement qui nous intéresse ###
$req = $dbh->prepare('SELECT tconf_evts.id as "ID", tconf_evts.name as "Nom", tconf_evts.deb as "Début", tconf_evts.fin as "Fin" FROM `tconf_evts` WHERE tconf_evts.id ='.$id_evt);
$req->execute();
$donnees = $req->fetch();


if ($req->rowCount() > 0) {
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_evt = $donnees[0];
  $name_evt = $donnees[1];
  $deb_evt = $donnees[2];
  $fin_evt = $donnees[3];
  // Termine le traitement de la requête
  $req->closeCursor();
  ?>

  <form method="post" action ="./php/evt-add.php?id=<?php echo($id_evt); ?>">
    <div class="card h-100 shadow">
      <div class="card-header bg-warning">
        <h3 class="card-title fw-bold text-center">Modifier l'Événement :</h3>
        <h4 class="text-center">" <?php echo($name_evt); ?> "</h4>
      </div>
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="input-group mb-3">
              <span class="input-group-text" id="dateFrom">Depuis le :</span>
              <input type="date" name="dateFrom" value="<?php echo ($deb_evt); ?>" />
              <span class="input-group-text"> jusqu'au : </span>
              <input type="date" name="dateTo" value="<?php echo ($fin_evt); ?>" />
              <span class="input-group-text">  </span>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="input-group mb-3">
            <span class="input-group-text" id="name">Nom</span>
            <input type="text" class="form-control" name="name" value="<?php echo ($name_evt);?>" placeholder="Nom de l'événement" aria-describedby="name_evt" autocomplete="off">
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-3 d-md-flex justify-content-evenly">
            <input type="submit" value="MODIFIER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=evt" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
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
        <a type="button" class="btn btn-danger" href="./php/evt-del.php?id=<?php echo($id_evt); ?>" id="evtdel" title="Supprimer l'événement">SUPPRIMER</a>
      </div>
    </div>
  </div>
</div>