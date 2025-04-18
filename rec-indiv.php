<?php ##########################################################################
# @Name : rec-indiv.php
# @Description : Page de modification des enregistrements des visites individuelles
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<div class="row justify-content-center">
<!-- Enragistrement des Entrées Individuelles -->
  <div class="col-xs-auto" style="margin-bottom: 1em;">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Modifier des Enregistrements Visites Individuelles</h3>
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
        $req = $dbh->prepare('SELECT tindiv.id as "ID" ,tindiv.create_date as "Date",tindiv.create_time as "Heure",tindiv.nb as "Nombre",tsoci_ages.name as "Catégorie",tindiv.primo as "Primovisiteur", tindiv.resi as ?, tindiv.col as ? ,tloc_depts.name as "Département",tloc_pays.name as "Pays" FROM `tindiv` INNER JOIN tsoci_ages ON tindiv.grpage_id=tsoci_ages.id INNER JOIN tloc_depts ON tindiv.depts_id=tloc_depts.id INNER JOIN tloc_pays ON tindiv.pays_id=tloc_pays.id ORDER BY `id` DESC LIMIT 1000');
        $req->execute(array($resident,$collectivite));
        ?>

        <table id="indiv-table" class="table table-striped nowrap" style="width:100%">
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
                            if ($i == 5) {
                              $row[$i] = '<i class="link-warning bi bi-trophy-fill"></i>';
                            } elseif ($i == 6) {
                              $row[$i] = '<i class="link-primary bi bi-person-check-fill"></i>';
                            } elseif ($i == 7) {
                              $row[$i] = '<i class="bi bi-geo-alt-fill"></i>';
                            }
                          };
                          echo "<td>" . $row[$i] . "</td>";

                  }

                  echo "<td>    <a class='link-success' title='Modifier la visite' href='index.php?page=edit&subpage=indiv&id=" . $row[0] . "'><i class='bi bi-pencil-square'></i></a></td>";
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
