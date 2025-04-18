<?php ##########################################################################
# @Name : rec-grp.php
# @Description : Page de modification des enregistrements des visites de groupes
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<div class="row justify-content-center">
<!-- Enregistrement des Groupes -->
  <div class="col-xs-auto" style="margin-bottom: 1em;">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Modifier des Enregistrements Visites de Groupes</h3>
          </div>
          <div class="col-3">
            <form>
              <input id="myCustomSearchBox" class="form-control" type="text" placeholder="Rechercher" aria-label="Rechercher" autocomplete="off">
            </form>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php
        $req = $dbh->prepare('SELECT tgrp.id as "ID" ,tgrp.create_date as "Date",tgrp.create_time as "Heure",tgrp.nb as "Nombre", tconf_grp_typ.scol as "", tconf_grp_typ.type as "Catégorie", tgrp.resi as ?, tgrp.col as ?, tconf_atel.name as "Atelier", tconf_secteurs.name as "Secteur", tloc_depts.name as "Département",tloc_pays.name as "Pays" FROM `tgrp` INNER JOIN tconf_grp_typ ON tgrp.typ_id=tconf_grp_typ.id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_secteurs ON tconf_secteurs.id = tconf_atel.sect_id INNER JOIN tloc_depts ON tgrp.depts_id=tloc_depts.id INNER JOIN tloc_pays ON tgrp.pays_id=tloc_pays.id ORDER BY `id` DESC LIMIT 1000');
        $req->execute(array($resident,$collectivite));
        ?>

        <table id="grp-table" class="table table-striped nowrap" style="width:100%">
        <?php
          // Affichage de la requête sous forme de tableau
          echo ("<thead>");
          // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
          echo "<tr>";
          // Affichage des noms d'attributs de chacune des colonnes
          for ($i = 0; $i < $req->columnCount(); $i++) {
                  $col = $req->getColumnMeta($i);
                  $legend = $col['name'];
                  echo "<th>" .$legend. "</th>\n";
          }
          echo "<th></th>\n";
          echo "</tr>\n";
          echo ("</thead>");
          echo ("<tbody class='table-border-bottom-0'>");
          // Création des lignes du tableau
          while($row = $req->fetch()) {
          // on affiche les valeurs de chaque attributs
                  echo ("<tr>");
                  for ($i=0; $i < $req->columnCount(); $i++) {
                          // si le champs est vide
                          if (empty($row[$i])) $row[$i] = "";
                          if ($row[$i] == 1) {
                            if ($i == 4) {
                              $row[$i] = '<i class="link-primary bi bi-hospital-fill"></i>';
                            } elseif ($i == 6) {
                              $row[$i] = '<i class="link-primary bi bi-person-check-fill"></i>';
                            } elseif ($i == 7) {
                              $row[$i] = '<i class="bi bi-geo-alt-fill"></i>';
                            }
                          };
                          echo "<td>" . $row[$i] . "</td>";

                  }

                  echo "<td>    <a class='link-success' title='Modifier la visite' href='index.php?page=edit&subpage=grp&id=" . $row[0] . "'><i class='bi bi-pencil-square'></i></a></td>";
                  echo "</tr>\n";
          }
          echo ("</tbody>");
        ?>
        </table>
        <?php $req->closeCursor();?>

      </div>
    </div>
  </div>
</div>
