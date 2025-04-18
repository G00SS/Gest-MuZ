<?php ##########################################################################
# @Name : stat-indiv.php
# @Description : Page de statistiques pour les visites Individuelles
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<form method="post">
  <div class="row justify-content-center">
    <div class="col-xs-auto col-sm-12 col-md-6 col-xl-4">
      <div class="card shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Période ciblée</h3>
        </div>
        <div class="card-body">
          <form method="post">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="input-group d-flex justify-content-center mb-3">
                <span class="input-group-text" id="dateFrom">Du :</span>
                <input type="date" name="dateFrom" value="<?php echo date('Y-m-d', strtotime("-1 months")); ?>" />
                <span class="input-group-text"> Au : </span>
                <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
                <span class="input-group-text">  </span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="d-grid gap-2 d-flex justify-content-evenly">
              <input type="submit" value="EXTRAIRE" class="btn btn-success" title="Extraire les statistiques"/>
              <a href="./index.php" class="btn btn-secondary" title="Revenir au Dashboard">RETOUR</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php if (isset($_POST['dateFrom']) and ($_POST['dateTo']))
{?>

<!-- FORMULAIRE DATE -->
<div class="row justify-content-center my-5">
  <div class="col text-center">
    <?php
    $dateFrom = strtotime($_POST['dateFrom']);
    $dateTo = strtotime($_POST['dateTo']);
    ?>
    <h2>Statistiques des visites individuelles effectuées entre <br>le <strong><?php echo date('d M Y', $dateFrom);?></strong> et le <strong><?php echo date('d M Y', $dateTo); ?></strong></h2>
    <?php
      $req = $dbh->prepare('SELECT SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ?');
      $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
      while($row=$req->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $Tot= $Effectif;
      }
      $req->closeCursor();
    ?>
    <h2 class="text-danger"><strong><?php echo $Tot;?></strong> Visiteurs au total</h2>
  </div>
</div>

<!-- REPRESENTATION GLOBALE DES VISITES INDIVIDUELLES -->
<div class="row justify-content-center mb-4">
  <div class="col">
    <div class="card h-100 shadow mb-3">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Représentation Globale des Visites Individuelles</h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-center mb-2">
          <?php
          $IndivLabel = [];
          $IndivTot = [0,0,0];
          $IndivPrim = [];
          $IndivExp = [];
          $IndivPay = [];
          $IndivFree = [];
          $IndivGui = [];
          $IndivAut = [];

          $req = $dbh->prepare('SELECT (tindiv.resi+tindiv.col) AS Provenance, REQT.Effectif AS Total, COALESCE(REQP.Effectif,0) AS Primo, COALESCE(REQH.Effectif,0) AS Habitués, COALESCE(REQF.Effectif,0) AS Gratuites, COALESCE(REQPa.Effectif,0) AS Payantes, COALESCE(REQA.Effectif,0) AS Autonomes, COALESCE(REQG.Effectif,0) AS Guidées FROM tindiv LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY (tindiv.resi+tindiv.col)) AS REQT ON REQT.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.primo=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQP ON REQP.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.primo=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQH ON REQH.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.payant=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQF ON REQF.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.payant=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQPa ON REQPa.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.guide=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQA ON REQA.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.guide=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQG ON REQG.public=(tindiv.resi+tindiv.col) WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY (tindiv.resi+tindiv.col) ORDER BY (tindiv.resi+tindiv.col) DESC');
          $req->execute([$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo']]);
          while($row = $req->fetch()) {
            if ($row[0] == 2){
              $row[0] = $resident;
              $IndivTot[0]= $row[1];
            } elseif ($row[0] == 1) {
              $row[0] = $collectivite;
              $IndivTot[1]= $row[1];
            } else {
              $row[0] = "Extérieurs";
              $IndivTot[2]= $row[1];
            }

            array_push($IndivLabel,$row[0]);
            array_push($IndivPrim,$row[2]);
            array_push($IndivExp,$row[3]);
            array_push($IndivFree,$row[4]);
            array_push($IndivPay,$row[5]);
            array_push($IndivAut,$row[6]);
            array_push($IndivGui,$row[7]);

          }
          $req->closeCursor();
          ?>
          <!-- DOUGHNUT PROVENANCE & PRIMO -->
          <div class="col-xs-auto col-sm-7 col-xl-4 mb-3">
                <?php
                  $IndivDetail1= [0,0,0,0,0,0];
                  foreach ($IndivLabel as $i => $x) {
                    if ($IndivLabel[$i]==$resident) {
                      $IndivDetail1[0]= $IndivPrim[$i];
                      $IndivDetail1[1]= $IndivExp[$i];
                    } elseif ($IndivLabel[$i]==$collectivite) {
                      $IndivDetail1[2]= $IndivPrim[$i];
                      $IndivDetail1[3]= $IndivExp[$i];
                    } else {
                      $IndivDetail1[4]= $IndivPrim[$i];
                      $IndivDetail1[5]= $IndivExp[$i];
                    }
                  }
                ?>
                  <canvas id="GraphDoughIPP"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & PAYANT -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-3">
                  <?php
                  $IndivDetail2= [0,0,0,0,0,0];
                  foreach ($IndivLabel as $i => $x) {
                    if ($IndivLabel[$i]==$resident) {
                      $IndivDetail2[0]= $IndivFree[$i];
                      $IndivDetail2[1]= $IndivPay[$i];
                    } elseif ($IndivLabel[$i]==$collectivite) {
                      $IndivDetail2[2]= $IndivFree[$i];
                      $IndivDetail2[3]= $IndivPay[$i];
                    } else {
                      $IndivDetail2[4]= $IndivFree[$i];
                      $IndivDetail2[5]= $IndivPay[$i];
                    }
                  }
                  ?>
                  <canvas id="GraphDoughIPF"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & GUIDEE -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-3">
                  <?php
                  $IndivDetail3= [0,0,0,0,0,0];
                  foreach ($IndivLabel as $i => $x) {
                    if ($IndivLabel[$i]==$resident) {
                      $IndivDetail3[0]= $IndivAut[$i];
                      $IndivDetail3[1]= $IndivGui[$i];
                    } elseif ($IndivLabel[$i]==$collectivite) {
                      $IndivDetail3[2]= $IndivAut[$i];
                      $IndivDetail3[3]= $IndivGui[$i];
                    } else {
                      $IndivDetail3[4]= $IndivAut[$i];
                      $IndivDetail3[5]= $IndivGui[$i];
                    }
                  }
                  ?>
                  <canvas id="GraphDoughIPG"></canvas>
          </div>
        </div>
      </div>

      <div class="row justify-content-center mb-2">
        <!-- TABLEAU PROVENANCE PRIMO GUIDEE PAYANT -->
        <div class="col-xs-11 col-sm-11 col-xl-10 mb-3">
          <div class="card h-100 shadow">
            <div class="card-header text-white bg-primary">
              <div class="row">
                <h3 class="card-title fw-bold text-center">Tableau Récapitulatif</h3>
              </div>
            </div>
            <div class="card-body">
              <?php
              $req = $dbh->prepare('SELECT (tindiv.resi+tindiv.col) AS Provenance, REQT.Effectif AS Total, COALESCE(REQP.Effectif,0) AS Primo, COALESCE(REQH.Effectif,0) AS Habitués, COALESCE(REQF.Effectif,0) AS Gratuites, COALESCE(REQPa.Effectif,0) AS Payantes, COALESCE(REQA.Effectif,0) AS Autonomes, COALESCE(REQG.Effectif,0) AS Guidées FROM tindiv LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY (tindiv.resi+tindiv.col)) AS REQT ON REQT.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.primo=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQP ON REQP.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.primo=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQH ON REQH.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.payant=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQF ON REQF.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.payant=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQPa ON REQPa.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.guide=0 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY tindiv.resi, tindiv.col) AS REQA ON REQA.public=(tindiv.resi+tindiv.col) LEFT JOIN (SELECT (tindiv.resi+tindiv.col) AS Public, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE (tindiv.guide=1 AND (tindiv.create_date BETWEEN ? AND ?)) GROUP BY (tindiv.resi+tindiv.col)) AS REQG ON REQG.public=(tindiv.resi+tindiv.col) WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY (tindiv.resi+tindiv.col) ORDER BY (tindiv.resi+tindiv.col) DESC');
          $req->execute([$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo'],$_POST['dateFrom'],$_POST['dateTo']]);
              ?>
              <div class="card-body">
                <table id="indivPGP" class="table table-striped dt-responsive nowrap" style="width:100%">
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
                  echo "</tr>\n";
                  echo ("</thead>");
                  echo ("<tbody class='table-border-bottom-0'>");
                  // Création des lignes du tableau
                  while($row = $req->fetch()) {
                  // on affiche les valeurs de chaque attributs
                      echo ("<tr>");
                      for ($i=0; $i < $req->columnCount(); $i++) {
                        if ($i == 0) {
                          if ($row[$i] == 2) {
                            $row[$i] = $resident;
                          } elseif ($row[$i] == 1) {
                            $row[$i] = $collectivite;
                          } else {
                            $row[$i] = "Extérieurs";
                          }
                        }
                        // si le champs est vide
                        if (empty($row[$i])) $row[$i] = 0;
                        echo "<td>" . $row[$i] . "</td>";
                      }
                      echo "</tr>\n";
                  }
                  echo ("</tbody>");
                ?>
                </table>
              </div>
              <?php $req->closeCursor(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FREQUENTATION DU MUSEE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Fréquentation du <?php echo ($structure); ?></h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-center mb-2">
          <!-- FREQUENTATION JOURNALIERE MOYENNE -->
          <div class="col-xs-auto col-md-4 col-lg-2 align-middle fw-bolder mb-3">
            <?php
              // Compter les jours
              $startDate = strtotime($_POST['dateFrom']);
              $endDate = strtotime($_POST['dateTo']);
              $datediff = $endDate - $startDate;
              $datediff = round($datediff / (60 * 60 * 24));

              // Nombre de jours ouvrés par semaine
              $req = $dbh->prepare('SELECT COUNT(tconf_days.id) AS NB FROM tconf_days WHERE tconf_days.work=1');
                $req->execute();
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $workingdays = $NB;
                }
                $req->closeCursor();

              // Effectif total
              $req = $dbh->prepare('SELECT SUM(tindiv.nb) AS NB FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ?');
                $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $Effectif = $NB;
                }
                $req->closeCursor();

              $moyD = round($Effectif / round(($datediff/7)*$workingdays));
            ?>
            <p class="text-center fw-bold" style="font-family:Segoe UI, Helvetica Neue, Arial; font-size: 10em"><?php echo ($moyD); ?></p>

            <p class="text-center" style="font-family:Segoe UI, Helvetica Neue, Arial; font-size: 15px">Fréquentation moyenne journalière</p>

          </div>
          <!-- FREQUENTATION MOYENNE PAR JOUR -->
          <div class="col-xs-auto col-md-5 col-lg-5 mb-3">
            <!-- COMPTAGE DES NOMBRES DE JOURS PAR JOUR ENTRE 2 DATES-->
            <?php
              // input start and end date
              $startDate = $_POST['dateFrom'];
              $endDate = $_POST['dateTo'];
              
              $countDays = array('Monday' => 0,
              'Tuesday' => 0,
              'Wednesday' => 0,
              'Thursday' => 0,
              'Friday' => 0,
              'Saturday' => 0,
              'Sunday' => 0);

              // change string to date time object
              $startDate = new DateTime($startDate);
              $endDate = new DateTime($endDate);

              // iterate over start to end date
              while($startDate <= $endDate ){
                // find the timestamp value of start date
                $timestamp = strtotime($startDate->format('d-m-Y'));

                // find out the day for timestamp and increase particular day
                $weekDay = date('l', $timestamp);
                $countDays[$weekDay] = $countDays[$weekDay] + 1;

                // increase startDate by 1
                $startDate->modify('+1 day');
              }

              // print the result
              //print_r($countDays);
              //echo "</br>";
            ?>
            <!-- EFFECTIFS PAR JOUR ENTRE 2 DATES-->
            <?php
              // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par jour
              $req = $dbh->prepare('SELECT tconf_days.EN AS EN, tconf_days.FR AS FR FROM `tconf_days` ORDER BY tconf_days.id ASC');
              $req->execute();
              $days = [];
              $qtenull = [];

              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $days[$FR] = $FR;
                $qtenull[$EN] = Null;
              }
              $req->closeCursor();
              // Reset des keys de l'array
              $days = array_values($days);


              // Récupération des moyennes de fréquentation des individuels par jour sur le mois
              $req = $dbh->prepare('SELECT DAYNAME(tindiv.create_date) AS joursemaine, SUM(tindiv.nb) AS "Frequ" FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY joursemaine');
              $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

              $freqIndD = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqIndD[$joursemaine]= $Frequ;
              }
              $req->closeCursor();
              
              //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';

              foreach ($freqIndD as $x => $y) {
                $freqIndD[$x] = floor($freqIndD[$x]/$countDays[$x]);
              }

              $freqIndD = array_values($freqIndD);
              foreach ($freqIndD as $x => $y) {
                if ($freqIndD[$x]==0) {
                  $freqIndD[$x]=Null;
                }
              }
            ?>
              <canvas id="GraphID" height="150"></canvas>
          </div>
          <!-- FREQUENTATION MOYENNE PAR HEURES -->
          <div class="col-xs-auto col-md-9  col-lg-5 mb-3">
            <!-- CREATION D'UNE LISTE DES HEURES OUVREES -->
            <?php
            $period = new DatePeriod(
                new DateTime($open),
                new DateInterval('PT1H'),
                new DateTime($close)
            );

            $hours = [];
            $hoursnull = [];
            foreach ($period as $date) {
                //echo $date->format("H:i\n");
                $hours[] = $date->format("H:i");
                $hoursnull[$date->format("H")] = ' ';
            }

            // COMBIEN DE JOURS OUVRES SUR LA PERIODE
              // Compter les jours
              $startDate = strtotime($_POST['dateFrom']);
              $endDate = strtotime($_POST['dateTo']);
              $datediff = $endDate - $startDate;
              $datediff = round($datediff / (60 * 60 * 24));

              // Nombre de jours ouvrés par semaine
              $req = $dbh->prepare('SELECT COUNT(tconf_days.id) AS NB FROM tconf_days WHERE tconf_days.work=1');
                $req->execute();
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $workingdays = $NB;
                }
                $req->closeCursor();

            // Récupération de la somme des fréquentations par heure sur la période pour les individuels
            $req = $dbh->prepare('SELECT HOUR(tindiv.create_time) AS horaire, SUM(tindiv.nb) AS Frequ FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY horaire');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

            $freqIndH = $hoursnull;
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$freqIndH)) {
                $freqIndH[sprintf('%02d', $horaire)] = floor($Frequ/(round(($datediff/7)*$workingdays)));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $freqIndH = array_values($freqIndH);
            foreach ($freqIndH as $x => $y) {
              if ($freqIndH[$x]==0) {
                $freqIndH[$x]=Null;
              }
            }
            ?>
              <canvas id="GraphIH" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ACTIVITE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Activités au <?php echo ($structure); ?></h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/SECTEUR -->
          <div class="col-xs-auto col-md-5 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par secteurs et primo
            $req = $dbh->prepare('SELECT tconf_secteurs.id AS ID, tconf_secteurs.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_sect ON tindiv_sect.indiv_id=tindiv.id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tindiv_sect.sect_id WHERE tindiv.create_date BETWEEN ? AND ?  GROUP BY tconf_secteurs.id, tindiv.primo ORDER BY tconf_secteurs.name, tindiv.primo ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelSECT=[];
            $effSECT=[];
            $effSECTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelSECT[$ID] = $name;
                if ($PRIMO == 0) {
                  $effSECT[$ID] = $Effectif;
                } else {
                  $effSECTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelSECT as $i => $x) {
              if (array_key_exists($i,$effSECT)) {
                // code...
              } else {
                $effSECT[$i]=Null;
              }
              if (array_key_exists($i,$effSECTP)) {
                // code...
              } else {
                $effSECTP[$i]=Null;
              }
            }
            ksort($effSECT);
            ksort($effSECTP);

            // Reset des keys de l'array
            $LabelSECT = array_values($LabelSECT);
            $effSECTP = array_values($effSECTP);
            $effSECT = array_values($effSECT);
            ?>
            <canvas id="GraphSECT"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/EXPOSITIONS -->
          <div class="col-xs-auto col-md-7 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par exposition et primo
            $req = $dbh->prepare('SELECT tconf_expo.id AS ID, tconf_expo.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_expo ON tindiv_expo.indiv_id=tindiv.id INNER JOIN tconf_expo ON tconf_expo.id=tindiv_expo.expo_id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_expo.sect_id WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tconf_expo.id, tindiv.primo ORDER BY tconf_secteurs.name,tconf_expo.name, tindiv.primo ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelEXPO=[];
            $effEXPO=[];
            $effEXPOP=[];

            // Insertion des effectifs en fonction de l'ID des expositions et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelEXPO[$ID] = $name;
                if ($PRIMO == 0) {
                  $effEXPO[$ID] = $Effectif;
                } else {
                  $effEXPOP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelEXPO as $i => $x) {
              if (array_key_exists($i,$effEXPO)) {
                // code...
              } else {
                $effEXPO[$i]=Null;
              }
              if (array_key_exists($i,$effEXPOP)) {
                // code...
              } else {
                $effEXPOP[$i]=Null;
              }
            }
            ksort($effEXPO);
            ksort($effEXPOP);

            // Reset des keys de l'array
            $LabelEXPO = array_values($LabelEXPO);
            $effEXPOP = array_values($effEXPOP);
            $effEXPO = array_values($effEXPO);
            ?>
            <canvas id="GraphEXPO"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/EVENEMENT -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par exposition et primo
            $req = $dbh->prepare('SELECT tconf_evts.id AS ID, tconf_evts.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_evts ON tindiv_evts.indiv_id=tindiv.id INNER JOIN tconf_evts ON tconf_evts.id=tindiv_evts.evt_id WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tconf_evts.id, tindiv.primo ORDER BY tconf_evts.name, tindiv.primo ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelEVT=[];
            $effEVT=[];
            $effEVTP=[];

            // Insertion des effectifs en fonction de l'ID des expositions et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelEVT[$ID] = $name;
                if ($PRIMO == 0) {
                  $effEVT[$ID] = $Effectif;
                } else {
                  $effEVTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelEVT as $i => $x) {
              if (array_key_exists($i,$effEVT)) {
                // code...
              } else {
                $effEVT[$i]=Null;
              }
              if (array_key_exists($i,$effEVTP)) {
                // code...
              } else {
                $effEVTP[$i]=Null;
              }
            }
            ksort($effEVT);
            ksort($effEVTP);

            // Reset des keys de l'array
            $LabelEVT = array_values($LabelEVT);
            $effEVTP = array_values($effEVTP);
            $effEVT = array_values($effEVT);
            ?>
            <canvas id="GraphEVT"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SOCIOLOGIE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Répartitions Sociologiques des Visiteurs</h3>
        </div>
          <?php
          // On récupère le nom du département par défaut 
          $req = $dbh->prepare('SELECT tloc_depts.name AS dept FROM `tloc_depts` WHERE tloc_depts.id=?;');
          $req->execute([$default_dept]);

          // On affiche chaque entrée une à une
          while ($row=$req->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $default_deptname = $dept;
          }
          // Termine le traitement de la requête
          $reponse->closeCursor();
          
          // On récupère le nom de la région du département par défaut
          $req = $dbh->prepare('SELECT tloc_depts.reg_id AS reg, tloc_regions.name as regn FROM `tloc_depts` INNER JOIN tloc_regions ON tloc_regions.id=tloc_depts.reg_id WHERE tloc_depts.id=?;');
          $req->execute([$default_dept]);

          // On affiche chaque entrée une à une
          while ($row=$req->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $default_regid = $reg;
            $default_regname = $regn;
          }
          // Termine le traitement de la requête
          $reponse->closeCursor();
          ?>
      </div>
      <div class="card-body">
        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/MOTIVATION -->
          <div class="col-xs-auto col-md-6 col-lg-4 mb-2">
            <?php
            // Récupération des effectifs par motivation et primo
            $req = $dbh->prepare('SELECT tsoci_motiv.id AS ID, tsoci_motiv.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tsoci_motiv ON tsoci_motiv.id = tindiv.motiv_id WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tindiv.primo,tsoci_motiv.id ORDER BY tindiv.primo,tsoci_motiv.id ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $motiv=[];
            $effIndM=[];
            $effIndMP=[];

            // Insertion des effectif en fonction de l'ID des régions globales et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $motiv[$ID] = $name;
                if ($PRIMO == 0) {
                  $effIndM[$ID] = $Effectif;
                } else {
                  $effIndMP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($motiv as $i => $x) {
              if (array_key_exists($i,$effIndM)) {
                // code...
              } else {
                $effIndM[$i]=Null;
              }
              if (array_key_exists($i,$effIndMP)) {
                // code...
              } else {
                $effIndMP[$i]=Null;
              }
            }
            ksort($effIndM);
            ksort($effIndMP);

            // Reset des keys de l'array
            $motiv = array_values($motiv);
            $effIndMP = array_values($effIndMP);
            $effIndM = array_values($effIndM);

            ?>
            <canvas id="GraphM"></canvas>
          </div>

          <!-- GRAPHIQUE REPARTITION EFFECTIFS/CLASSES D'AGES -->
          <div class="col-xs-auto col-md-6 col-lg-4 mb-2">
            <?php
            // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, tsoci_ages.name AS Categorie FROM `tsoci_ages` ORDER BY tsoci_ages.age ASC');
            $req->execute();
            $ages = [];
            $cat = [];
            $qtenull = [];

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                  $ages[$ID] = $Classe;
                  $cat[$ID] = $Categorie;
                  $qtenull[$ID] = Null;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $ages = array_values($ages);

            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif, tsoci_ages.name AS Catégorie FROM `tindiv` INNER JOIN tsoci_ages ON tsoci_ages.id = tindiv.grpage_id WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tindiv.primo,tsoci_ages.id ORDER BY tindiv.primo,tsoci_ages.age ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

            $effIndEC = $qtenull;
            $effIndECP = $qtenull;

            // Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                if ($PRIMO==1) {
                 $effIndECP[$ID]= $Effectif;
                } else
                 $effIndEC[$ID]= $Effectif;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $effIndECP = array_values($effIndECP);
            $effIndEC = array_values($effIndEC);
            ?>
            <canvas id="GraphEC"></canvas>
          </div>

          <!-- DOUGHNUT EFFECTIFS VISITES FAMILIALES -->
          <div class="col-xs-auto col-md-6 col-lg-3 mb-2">
            <?php
            $req = $dbh->prepare('SELECT tindiv.famille AS famille, SUM(tindiv.nb) AS Effectif FROM `tindiv` WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tindiv.famille ORDER BY tindiv.famille ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $labelFamille =[];
            $nbVisites=0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);

              if ($row['famille']==0) {
                array_push($labelFamille,"Visiteurs");
              } else{
                array_push($labelFamille,"Visites familiales");

              }
                $effFam[]= (int)$Effectif;
                $nbVisites += $Effectif;
              }
            $req->closeCursor();
            ?>
            <canvas id="visitesFAM"></canvas>
          </div>
        </div>

        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE EFFECTIFS FRANCAIS -->
          <div class="col-xs-auto col-md-6 col-lg-2 mb-2 d-none d-lg-block">
            <?php
            $req = $dbh->prepare('SELECT tloc_pays.id AS ID, tloc_pays.name AS "Pays", tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tloc_pays ON tloc_pays.id = tindiv.pays_id WHERE tloc_pays.id=62 AND tindiv.create_date BETWEEN ? AND ? GROUP BY tindiv.primo ORDER BY tindiv.primo ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $primo[]= (int)$PRIMO;
              $effFR[]= (int)$Effectif;
            }
            $req->closeCursor();

            if (isset($primo[0])) {
              if ($primo[0]==0) {
                if (isset($primo[1])) {
                  //do nothing
                } else {
                  $effFR[1] = Null;
                }
              } else {
                $effFR[1] = $effFR[0];
                $effFR[0] = Null;
              }
            } else {
              $effFR[0] = Null;
              $effFR[1] = Null;
            }
            $primo=[];
            ?>
            <canvas id="GraphFR"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION REGIONNALE DES EFFECTIFS -->
          <div class="col-xs-auto col-md-6 col-lg-5 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_depts.id AS ID, tloc_depts.name AS "name", tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tloc_depts ON tloc_depts.id = tindiv.depts_id WHERE tloc_depts.reg_id=? AND tindiv.create_date BETWEEN ? AND ? GROUP BY tloc_depts.nb,tindiv.primo ORDER BY tloc_depts.id,tindiv.primo ASC');
            $req->execute([$default_regid,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelREG=[];
            $LabelREGP=[];
            $LabelREGTP=[];
            $effREG=[];
            $effREGP=[];
            $effREGT=[];
            $effREGTP=[];
            $REGT=0;
            //count($LabelREGP)

            // Insertion des effectif en fonction de l'ID des départements et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelREG[$ID] = $name;
                if ($PRIMO == 0) {
                  $effREG[$ID] = $Effectif;
                } else {
                  $effREGP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            foreach ($LabelREG as $i => $x) {
              if (array_key_exists($i,$effREG)) {
                // code...
              } else {
                $effREG[$i]=Null;
              }
              if (array_key_exists($i,$effREGP)) {
                // code...
              } else {
                $effREGP[$i]=Null;
              }
            }
            ksort($effREG);
            ksort($effREGP);

            // Reset des keys de l'array
            $LabelREG = array_values($LabelREG);
            $effREGP = array_values($effREGP);
            $effREG = array_values($effREG);

            foreach ($LabelREG as $i => $x) {
              $effREGT[$i] = $effREG[$i]+$effREGP[$i];
              array_push($effREGTP,$effREGP[$i],$effREG[$i]);
              array_push($LabelREGP,"Primo-Visiteurs-".$x,"Habitués-".$x);
            }
            $LabelREGTP=$LabelREGP;

            foreach ($LabelREG as $i => $x) {
              array_push($LabelREGTP,$x);
              $REGT=$REGT+$effREGT[$i];
            }


            ?>

            <canvas id="GraphDoughREG"></canvas>
          </div>

          <!-- GRAPHIQUE REPARTITION EFFECTIFS/DEPARTEMENTS -->
          <div class="col-xs-auto col-md-6 col-lg-5 col-xl-6 mb-2">
            <?php
            // Récupération des effectifs par départements et primo
            $req = $dbh->prepare('SELECT tloc_depts.id AS ID, tloc_depts.name AS "name", tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tloc_depts ON tloc_depts.id = tindiv.depts_id WHERE tloc_depts.reg_id<>? AND tindiv.create_date BETWEEN ? AND ? GROUP BY tloc_depts.nb,tindiv.primo ORDER BY tloc_depts.id,tindiv.primo ASC');
            $req->execute([$default_regid,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelDEP=[];
            $effDEP=[];
            $effDEPP=[];

            // Insertion des effectif en fonction de l'ID des départements et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                if ($ID != (int)$default_dept) {
                  $LabelDEP[$ID] = $name;
                  if ($PRIMO == 0) {
                    $effDEP[$ID] = $Effectif;
                  } else {
                    $effDEPP[$ID] = $Effectif;
                  }
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelDEP as $i => $x) {
              if (array_key_exists($i,$effDEP)) {
                // code...
              } else {
                $effDEP[$i]=Null;
              }
              if (array_key_exists($i,$effDEPP)) {
                // code...
              } else {
                $effDEPP[$i]=Null;
              }
            }
            ksort($effDEP);
            ksort($effDEPP);

            // Reset des keys de l'array
            $LabelDEP = array_values($LabelDEP);
            $effDEPP = array_values($effDEPP);
            $effDEP = array_values($effDEP);
            ?>
            <canvas id="GraphDEP"></canvas>
          </div>
        </div>

        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/PAYS -->
          <div class="col-xs-auto col-md-6 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_pays.id AS ID, tloc_pays.name AS "Pays", tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tloc_pays ON tloc_pays.id = tindiv.pays_id WHERE tindiv.create_date BETWEEN ? AND ? GROUP BY tloc_pays.id,tindiv.primo ORDER BY tloc_pays.id,tindiv.primo ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelPIP=[];
            $effIPI=[];
            $effIPIP=[];

            // Insertion des effectif en fonction de l'ID des pays et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
                if ($ID != 199) {
                  if($ID != $default_pays) {
                  $LabelPIP[$ID] = $Pays;
                  if ($PRIMO == 0) {
                    $effIPI[$ID] = $Effectif;
                  } else {
                    $effIPIP[$ID] = $Effectif;
                  }
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelPIP as $i => $x) {
              if (array_key_exists($i,$effIPI)) {
                // code...
              } else {
                $effIPI[$i]=Null;
              }
              if (array_key_exists($i,$effIPIP)) {
                // code...
              } else {
                $effIPIP[$i]=Null;
              }
            }
            ksort($effIPI);
            ksort($effIPIP);

            // Reset des keys de l'array
            $LabelPIP = array_values($LabelPIP);
            $effIPIP = array_values($effIPIP);
            $effIPI = array_values($effIPI);
            ?>
            <canvas id="GraphIPI"></canvas>
          </div>
        
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/REGIONGLOBE -->
          <div class="col-xs-auto col-md-6 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_globreg.id AS ID, tloc_globreg.name AS "name", tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tloc_pays ON tloc_pays.id = tindiv.pays_id INNER JOIN tloc_globreg ON tloc_globreg.id = tloc_pays.globreg_id WHERE  tloc_pays.id <> ? AND tindiv.create_date BETWEEN ? AND ? GROUP BY tloc_globreg.id,tindiv.primo ORDER BY tloc_globreg.id,tindiv.primo ASC');
            $req->execute([$default_pays,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelGRP=[];
            $effIGR=[];
            $effIGRP=[];

            // Insertion des effectif en fonction de l'ID des régions globales et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 18) {
                $LabelGRP[$ID] = $name;
                if ($PRIMO == 0) {
                  $effIGR[$ID] = $Effectif;
                } else {
                  $effIGRP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelGRP as $i => $x) {
              if (array_key_exists($i,$effIGR)) {
                // code...
              } else {
                $effIGR[$i]=Null;
              }
              if (array_key_exists($i,$effIGRP)) {
                // code...
              } else {
                $effIGRP[$i]=Null;
              }
            }
            ksort($effIGR);
            ksort($effIGRP);

            // Reset des keys de l'array
            $LabelGRP = array_values($LabelGRP);
            $effIGRP = array_values($effIGRP);
            $effIGR = array_values($effIGR);
            ?>
            <canvas id="GraphIRG"></canvas>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>

<?php } ?>

