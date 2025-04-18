<?php ##########################################################################
# @Name : param-conf.php
# @Description : Page de configuration des champs des tables principales
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<div class="row justify-content-center m-5">
  <div class="col-xs-auto col-sm-11 col-md-11">
    <div class="alert alert-danger" role="alert">
      <h4 class="alert-heading text-center"><strong>ATTENTION !</strong></h4>
      <h5 class="text-center"><strong>Les Informations saisies ici ne sont pas supprimables !</strong></h5>
      <hr>
      <p class="mb-0 text-center">Ces informations sont potentiellement utilisées de façon <strong>définitive</strong> dans vos enregistrements existants et font partie intégrante du fonctionnement du logiciel.</br>Vous avez la possibilité d'<strong>ajouter des informations manquantes</strong> ou de <strong>modifier celles existantes</strong> afin d'adapter le fonctionnement du logiciel à vos attentes.</p>
      <p class="mb-0 text-center"><strong>Réfléchissez bien à vos modifications avant de vous lancer !</strong></p>
    </div>
  </div>
</div>

<div class="row justify-content-center">

  <div class="col-xs-auto col-sm-6 col-md-6">

    <div class="row justify-content-center">

      <div class="col-xs-auto col-md-6">
        <!-- Personnalisation des Secteurs -->
        <div class="card shadow mb-3">
          <div class="card-header text-white bg-primary">
            <div class="row">
              <div class="col-9">
                <h3 class="card-title fw-bold text-center">Les Secteurs du <?php echo($structure);?></h3>
              </div>
              <div class="col-3">
                <a  class="btn btn-warning float-right" title="Ajouter un Secteur" data-bs-toggle="modal" data-bs-target="#ModalADDsecteur"><i class="bi bi-plus-square"></i></a>
              </div>
            </div>
          </div>
          <?php
          $req = $dbh->prepare('SELECT tconf_secteurs.id as "ID", tconf_secteurs.name as "Secteurs", tconf_secteurs.class as "Classe CSS" FROM `tconf_secteurs` ORDER BY tconf_secteurs.name ASC');
          $req->execute();
          ?>
          <div class="card-body">
            <table id="secteurs" class="table table-striped dt-responsive nowrap" style="width:100%">
            <?php
              // Affichage de la requête sous forme de tableau
              echo ("<thead>");
              // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
              echo "<tr>";
              // Affichage des noms d'attributs de chacune des colonnes
              echo "<th></th>\n";
              for ($i = 0; $i < $req->columnCount(); $i++) {
                      $col = $req->getColumnMeta($i);
                      $legend = $col['name'];
                      echo "<th>" .$legend. "</th>\n";
              }
              echo "</tr>\n";
              echo ("</thead>");
              echo ("<tbody class='table-border-bottom-0'>");
              // Création des lignes du tableau
              while($row = $req->fetch()) {
                if ($row[0]!=1) {
                // on affiche les valeurs de chaque attributs
                    echo ("<tr>");
                    echo ("<td><a href='javascript:void(0)' class='link-success detail-secteur' title='Modifier ce secteur' data-bs-toggle='modal' data-bs-target='#ModalUPDATEsecteur' data-id='".$row[0]."'><i class='bi bi-pencil-square'></i></a></td>");

                    for ($i=0; $i < $req->columnCount(); $i++) {
                            // si le champs est vide
                            if (empty($row[$i])) $row[$i] = "";
                            echo "<td>" . $row[$i] . "</td>";
                    }
                    echo "</tr>\n";
                }
              }
              echo ("</tbody>");
            ?>
            </table>
          </div>
          <?php $req->closeCursor(); ?>

          <!-- Modal Ajout secteur -->
          <div class="modal fade" id="ModalADDsecteur" tabindex="-1" aria-labelledby="ModalADDsecteurLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header text-white bg-danger">
                  <h4 class="modal-title fw-bold text-center" id="ModalADDsecteurLabel">Ajouter un Secteur</h4>
                  <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" action ="./php/sect-add.php">
                  <div class="row justify-content-evenly">
                    <!-- Secteur -->
                    <div class="col-xs-auto col-sm-12">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="name">Désignation</span>
                        <input type="text" class="form-control" name="name" value="" placeholder="Nom du Secteur" aria-describedby="name" autocomplete="off" required>
                      </div>
                    </div>
                    <!-- Classe CSS -->
                    <div class="col-xs-auto col-sm-12">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="classecss">Classe CSS</span>
                        <input type="texte" class="form-control"  name="classecss" value="" placeholder="Un mot nécessaire pour le programme" aria-describedby="classecss" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer justify-content-evenly">
                    <input type="submit" value="AJOUTER" class="btn btn-success"/>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler l'ajout'">ANNULER</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Modif Intéret -->
          <div class="modal fade" id="ModalUPDATEsecteur" tabindex="-1" aria-labelledby="ModalUPDATEsecteurLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header text-black bg-warning">
                  <h4 class="modal-title fw-bold text-center" id="ModalUPDATEsecteurLabel">Modifier un Secteur</h4>
                  <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body secteurdetail">
                  <!-- Remplacé par get_SECTdetails.php via script table-param-secteurs.js -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xs-auto col-md-6">
        <!-- Personnalisation les Motivations -->
        <div class="card shadow mb-3">
          <div class="card-header text-white bg-primary">
            <div class="row">
              <div class="col-9">
                <h3 class="card-title fw-bold text-center">Les Motivations</h3>
              </div>
              <div class="col-3">
                <a  class="btn btn-warning float-right" title="Ajouter une motivation" data-bs-toggle="modal" data-bs-target="#ModalADDmotiv"><i class="bi bi-plus-square"></i></a>
              </div>
            </div>
          </div>
          <?php
          $req = $dbh->prepare('SELECT tsoci_motiv.id as "ID", tsoci_motiv.name as "Motivation" FROM `tsoci_motiv` ORDER BY tsoci_motiv.id ASC');
          $req->execute();
          ?>
          <div class="card-body">
            <table id="motiv" class="table table-striped dt-responsive nowrap" style="width:100%">
            <?php
              // Affichage de la requête sous forme de tableau
              echo ("<thead>");
              // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
              echo "<tr>";
              // Affichage des noms d'attributs de chacune des colonnes
              echo "<th></th>\n";
              for ($i = 0; $i < $req->columnCount(); $i++) {
                      $col = $req->getColumnMeta($i);
                      $legend = $col['name'];
                      echo "<th>" .$legend. "</th>\n";
              }
              echo "</tr>\n";
              echo ("</thead>");
              echo ("<tbody class='table-border-bottom-0'>");
              // Création des lignes du tableau
              while($row = $req->fetch()) {
                if ($row[0]!=1) {
                // on affiche les valeurs de chaque attributs
                    echo ("<tr>");
                    echo ("<td><a href='javascript:void(0)' class='link-success detail-motiv' title='Modifier cette motivation' data-bs-toggle='modal' data-bs-target='#ModalUPDATEmotiv' data-id='".$row[0]."'><i class='bi bi-pencil-square'></i></a></td>");

                    for ($i=0; $i < $req->columnCount(); $i++) {
                            // si le champs est vide
                            if (empty($row[$i])) $row[$i] = "";
                            echo "<td>" . $row[$i] . "</td>";
                    }
                    echo "</tr>\n";
                }
              }
              echo ("</tbody>");
            ?>
            </table>
          </div>
          <?php $req->closeCursor(); ?>
          <!-- Modal Ajout Motivation -->
          <div class="modal fade" id="ModalADDmotiv" tabindex="-1" aria-labelledby="ModalADDmotivLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header text-white bg-danger">
                  <h4 class="modal-title fw-bold text-center" id="ModalADDmotivLabel">Ajouter une Motivation</h4>
                  <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" action ="./php/motiv-add.php">
                  <div class="row justify-content-center">
                    <!-- Désignation de la Motivation -->
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="name">Motivation</span>
                      <input type="text" class="form-control" name="name" value="" placeholder="Nom du type de Motivation" aria-describedby="name_motiv" autocomplete="off" required>
                    </div>
                  </div>

                  <div class="modal-footer justify-content-evenly">
                    <input type="submit" value="AJOUTER" class="btn btn-success"/>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler l'ajout'">ANNULER</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Modif Motivation -->
          <div class="modal fade" id="ModalUPDATEmotiv" tabindex="-1" aria-labelledby="ModalUPDATEmotivLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header text-black bg-warning">
                  <h4 class="modal-title fw-bold text-center" id="ModalUPDATEmotivLabel">Modifier une Motivation</h4>
                  <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body motivdetail">
                  <!-- Remplacé par get_MOTIdetails.php via script table-param-socimotiv.js -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="col-xs-auto col-sm-6 col-md-4">

    <!-- Personnalisation les Groupes -->
    <div class="card shadow mb-3">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Les Types de Groupes</h3>
          </div>
          <div class="col-3">
            <a  class="btn btn-warning float-right" title="Ajouter un Groupe" data-bs-toggle="modal" data-bs-target="#ModalADDgrp"><i class="bi bi-plus-square"></i></a>
          </div>
        </div>
      </div>
      <?php
      $req = $dbh->prepare('SELECT tconf_grp_typ.id as "ID", tconf_grp_typ.type as "Groupe", tconf_grp_typ.scol as "" FROM `tconf_grp_typ` ORDER BY tconf_grp_typ.type ASC');
      $req->execute();
      ?>
      <div class="card-body">
        <table id="grp" class="table table-striped dt-responsive nowrap" style="width:100%">
        <?php
          // Affichage de la requête sous forme de tableau
          echo ("<thead>");
          // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
          echo "<tr>";
          // Affichage des noms d'attributs de chacune des colonnes
          echo "<th></th>\n";
          for ($i = 0; $i < $req->columnCount(); $i++) {
                  $col = $req->getColumnMeta($i);
                  $legend = $col['name'];
                  echo "<th>" .$legend. "</th>\n";
          }
          echo "</tr>\n";
          echo ("</thead>");
          echo ("<tbody class='table-border-bottom-0'>");
          // Création des lignes du tableau
          while($row = $req->fetch()) {
          // on affiche les valeurs de chaque attributs
              echo ("<tr>");
              echo ("<td><a href='javascript:void(0)' class='link-success detail-grp' title='Modifier ce groupe' data-bs-toggle='modal' data-bs-target='#ModalUPDATEgrp' data-id='".$row[0]."'><i class='bi bi-pencil-square'></i></a></td>");

              for ($i=0; $i < $req->columnCount(); $i++) {
                      // si le champs est vide
                      if (empty($row[$i])) $row[$i] = "";
                      if ($row[$i] == 1) {
                        if ($i == 2) {
                          $row[$i] = '<i class="link-primary bi bi-hospital-fill"></i>';
                        }
                      };
                      echo "<td>" . $row[$i] . "</td>";
              }
              echo "</tr>\n";
          }
          echo ("</tbody>");
        ?>
        </table>
      </div>
      <?php $req->closeCursor(); ?>
      <!-- Modal Ajout Groupe -->
      <div class="modal fade" id="ModalADDgrp" tabindex="-1" aria-labelledby="ModalADDgrpLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header text-white bg-danger">
              <h4 class="modal-title fw-bold text-center" id="ModalADDgrpLabel">Ajouter un Groupe</h4>
              <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action ="./php/grptyp-add.php">
              <div class="row justify-content-center">
                <!-- Nom du type de Groupe -->
                <div class="input-group mb-3">
                  <span class="input-group-text" id="name">Groupe</span>
                  <input type="text" class="form-control" name="name" value="" placeholder="Nom du type de groupe" aria-describedby="name_grp" autocomplete="off" required>
                </div>

                <!-- Scolaire -->
                <div class="col-4">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="scol" name="scol" value="1">
                      <label class="form-check-label" for="scol">Scolaire</label>
                    </div>
                </div>
              </div>

              <div class="modal-footer justify-content-evenly">
                <input type="submit" value="AJOUTER" class="btn btn-success"/>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler l'ajout'">ANNULER</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Modif Groupe -->
      <div class="modal fade" id="ModalUPDATEgrp" tabindex="-1" aria-labelledby="ModalUPDATEgrpLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header text-black bg-warning">
              <h4 class="modal-title fw-bold text-center" id="ModalUPDATEgrpLabel">Modifier un Type de Groupe</h4>
              <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body grpdetail">
              <!-- Remplacé par get_GRPdetails.php via script table-param-grp.js -->
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row justify-content-center">

    <div class="col-xs-auto col-sm-5 col-md-4">
      <!-- Personnalisation des Classes d'âges -->
      <div class="card shadow mb-3">
        <div class="card-header text-white bg-primary">
          <div class="row">
            <div class="col-9">
              <h3 class="card-title fw-bold text-center">Les Classes d'âges</h3>
            </div>
            <div class="col-3">
              <a  class="btn btn-warning float-right" title="Ajouter une classe d'âges" data-bs-toggle="modal" data-bs-target="#ModalADDsociage"><i class="bi bi-plus-square"></i></a>
            </div>
          </div>
        </div>
        <?php
        $req = $dbh->prepare('SELECT tsoci_ages.id as "ID", tsoci_ages.age as "Ages", tsoci_ages.name as "Désignation" FROM `tsoci_ages` ORDER BY tsoci_ages.id ASC');
        $req->execute();
        ?>
        <div class="card-body">
          <table id="soci_ages" class="table table-striped dt-responsive nowrap" style="width:100%">
          <?php
            // Affichage de la requête sous forme de tableau
            echo ("<thead>");
            // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
            echo "<tr>";
            // Affichage des noms d'attributs de chacune des colonnes
            echo "<th></th>\n";
            for ($i = 0; $i < $req->columnCount(); $i++) {
                    $col = $req->getColumnMeta($i);
                    $legend = $col['name'];
                    echo "<th>" .$legend. "</th>\n";
            }
            echo "</tr>\n";
            echo ("</thead>");
            echo ("<tbody class='table-border-bottom-0'>");
            // Création des lignes du tableau
            while($row = $req->fetch()) {
              if ($row[0]!=1) {
              // on affiche les valeurs de chaque attributs
                  echo ("<tr>");
                  echo ("<td><a href='javascript:void(0)' class='link-success detail-sociage' title='Modifier cette tranche d'âges' data-bs-toggle='modal' data-bs-target='#ModalUPDATEsociage' data-id='".$row[0]."'><i class='bi bi-pencil-square'></i></a></td>");

                  for ($i=0; $i < $req->columnCount(); $i++) {
                          // si le champs est vide
                          if (empty($row[$i])) $row[$i] = "";
                          echo "<td>" . $row[$i] . "</td>";
                  }
                  echo "</tr>\n";
              }
            }
            echo ("</tbody>");
          ?>
          </table>
        </div>
        <?php $req->closeCursor(); ?>
        <!-- Modal Ajout Groupe -->
        <div class="modal fade" id="ModalADDsociage" tabindex="-1" aria-labelledby="ModalADDsociageLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header text-white bg-danger">
                <h4 class="modal-title fw-bold text-center" id="ModalADDsociageLabel">Ajouter une Classe d'âges</h4>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action ="./php/age-add.php">
                <div class="row justify-content-evenly">
                  <!-- Classe d'âges -->
                  <div class="col-xs-auto col-sm-12">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="ages">Classe d'âges</span>
                      <input type="text" class="form-control" name="ages" value="" placeholder="7 - 77 ans" aria-describedby="ages" autocomplete="off" required>
                    </div>
                  </div>
                  <!-- Désignation -->
                  <div class="col-xs-auto col-sm-12">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="sociagenom">Désignation</span>
                      <input type="texte" class="form-control"  name="sociagenom" value="" placeholder="Adultes" aria-describedby="sociagenom" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="modal-footer justify-content-evenly">
                  <input type="submit" value="AJOUTER" class="btn btn-success"/>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler l'ajout'">ANNULER</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Modif Groupe -->
        <div class="modal fade" id="ModalUPDATEsociage" tabindex="-1" aria-labelledby="ModalUPDATEsociageLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header text-black bg-warning">
                <h4 class="modal-title fw-bold text-center" id="ModalUPDATEsociageLabel">Modifier une Classe d'âges</h4>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body sociagedetail">
                <!-- Remplacé par get_SOCIAGEdetails.php via script table-param-sociage.js -->
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-xs-auto col-sm-6">

      <!-- Personnalisation des Publics des ateliers -->
      <div class="card shadow mb-3">
        <div class="card-header text-white bg-primary">
          <div class="row">
            <div class="col-9">
              <h3 class="card-title fw-bold text-center">Les Publics des Ateliers</h3>
            </div>
            <div class="col-3">
              <a  class="btn btn-warning float-right" title="Ajouter un Public" data-bs-toggle="modal" data-bs-target="#ModalADDpublic"><i class="bi bi-plus-square"></i></a>
            </div>
          </div>
        </div>
        <?php
        $req = $dbh->prepare('SELECT tconf_publics.id as "ID", tconf_publics.name as "Catégorie", tsoci_ages.name as "Classe âges", tconf_publics.scol as "" FROM `tconf_publics` LEFT JOIN tsoci_ages ON tsoci_ages.id=tconf_publics.age ORDER BY tconf_publics.id ASC');
        $req->execute();
        ?>
        <div class="card-body">
          <table id="publics" class="table table-striped dt-responsive nowrap" style="width:100%">
          <?php
            // Affichage de la requête sous forme de tableau
            echo ("<thead>");
            // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
            echo "<tr>";
            // Affichage des noms d'attributs de chacune des colonnes
            echo "<th></th>\n";
            for ($i = 0; $i < $req->columnCount(); $i++) {
                    $col = $req->getColumnMeta($i);
                    $legend = $col['name'];
                    echo "<th>" .$legend. "</th>\n";
            }
            echo "</tr>\n";
            echo ("</thead>");
            echo ("<tbody class='table-border-bottom-0'>");
            // Création des lignes du tableau
            while($row = $req->fetch()) {
              if ($row[0]!=1) {
              // on affiche les valeurs de chaque attributs
                  echo ("<tr>");
                  echo ("<td><a href='javascript:void(0)' class='link-success detail-public' title='Modifier ce groupe' data-bs-toggle='modal' data-bs-target='#ModalUPDATEpublic' data-id='".$row[0]."'><i class='bi bi-pencil-square'></i></a></td>");

                  for ($i=0; $i < $req->columnCount(); $i++) {
                          // si le champs est vide
                          if (empty($row[$i])) $row[$i] = "";
                          if ($row[$i] == 1) {
                            if ($i == 3) {
                              $row[$i] = '<i class="link-primary bi bi-hospital-fill"></i>';
                            }
                          };
                          echo "<td>" . $row[$i] . "</td>";
                  }
                }
                echo "</tr>\n";
            }
            echo ("</tbody>");
          ?>
          </table>
        </div>
        <?php $req->closeCursor(); ?>
        <!-- Modal Ajout Public -->
        <div class="modal fade" id="ModalADDpublic" tabindex="-1" aria-labelledby="ModalADDpublicLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header text-white bg-danger">
                <h4 class="modal-title fw-bold text-center" id="ModalADDpublicLabel">Ajouter un Public</h4>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action ="./php/public-add.php">
                <div class="row justify-content-center">
                  <!-- Nom du Public -->
                  <div class="col-8">
                    <div class="input-group mb-3">
                      <span class="input-group-text" id="name">Public</span>
                      <input type="text" class="form-control" name="name" value="" placeholder="Nom du Public" aria-describedby="name_public" autocomplete="off" required>
                    </div>
                  </div>

                  <!-- Scolaire -->
                  <div class="col-3">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="scol" name="scol" value="1">
                        <label class="form-check-label" for="scol">Scolaire</label>
                      </div>
                  </div>
                </div>
                <div class="row justify-content-center">
                  <!-- Selection de la classe d'âges -->
                  <div class="col-auto">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="grpages">Classe d'âges</label>
                      <select class="form-select" id="grpages" name="grpages">
                      <?php
                      // On récupère tout le contenu de la table grpage
                      $reponse = $dbh->query('SELECT * FROM tsoci_ages');
                      // On affiche chaque entrée une à une
                      while ($donnees = $reponse->fetch())
                      { ?>
                        <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == 1) {echo "selected='selected'"; }?>><?php echo $donnees['age']; ?></option>
                      <?php }
                      $reponse->closeCursor(); // Termine le traitement de la requête
                      ?>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="modal-footer justify-content-evenly">
                  <input type="submit" value="AJOUTER" class="btn btn-success"/>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler l'ajout'">ANNULER</button>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Modif Public -->
        <div class="modal fade" id="ModalUPDATEpublic" tabindex="-1" aria-labelledby="ModalUPDATEpublicLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header text-black bg-warning">
                <h4 class="modal-title fw-bold text-center" id="ModalUPDATEpublicLabel">Modifier un Public</h4>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body publicdetail">
                <!-- Remplacé par get_PUBdetails.php via script table-param-public.js -->
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
