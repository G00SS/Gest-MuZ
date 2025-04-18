# Gest'MuZ
Une application web (PHP/MySQL) pour générer des statistiques de fréquentation d'un musée ou d'un établissement touristique...</br>

![Gest'Muz dashboard screenshot](/img/gestmuz.png)

Cette application web permet d'enregistrer des informations sur les visiteurs d'un musée ou tout autre établissement touristique, qu'il s'agisse de visites individuelles ou de groupes, scolaires ou non.
Il suffit de remplir un court formulaire pour chaque visite afin de générer automatiquement des statistiques sur la fréquentation, la provenance, les centres d'intérêt des visiteurs, etc.</br>

![Gest'Muz dashboard screenshot](/img/gestmuz4.png)

## Pré-Requis
Écrite principalement en HTML et PHP, cette application web nécessite un serveur web opérationnel avec une version minimale de PHP 7.0 et un accès à un serveur MySQL. Elle peut donc fonctionner sur une instance XAMP, une machine virtuelle Linux, un Raspberry Pi ou tout autre ordinateur répondant à ces exigences.</br>

Les instructions d'installation et d'utilisation suivantes sont basées sur une nouvelle installation de Debian avec Nginx comme serveur Web et MariaDB comme serveur MySQL.</br>

## Installation sur un Systeme Vierge

* Se connecter sur le serveur et y installer le serveur Web Nginx, PHP, et MariaDB (MySQL) ainsi que git pour récupérer facilement les fichiers depuis ce github :</br>  
```
apt install nginx mariadb-server mariadb-client php php-fpm php-mysql php-common git
```

* Récupérer le dossier du site web :</br>
```
git clone https://github.com/G00SS/Gest-MuZ.git gestmuz
```

* Copier les fichiers du site Web à la racine du serveur Web :</br>
```
mv gestmuz/* /var/www/html/
```

* Créer une base de données et son utilisateur (remplacez le mot de passe par le votre) pour l'application :</br>
```
mysql -u root -p
```
```
CREATE USER 'gestmuz'@'localhost' IDENTIFIED BY 'PUT-YOUR-PASSWORD-HERE';
CREATE DATABASE IF NOT EXISTS `bmus`;
GRANT ALL PRIVILEGES ON `bmus`.* TO 'gestmuz'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
FLUSH PRIVILEGES;
QUIT;
```

* Importer la structure de la base de données :</br> 
```
mysql -u gestmuz -p bmus < /var/www/html/bdd/bmus.sql
```

* Editer le fichier gestmuz/inc/bd.php afin qu'il corresponde à votre base de données en modifiant la ligne 17 :</br>
```
$dbh = new PDO('mysql:host=localhost;dbname=bmus;charset=utf8', 'gestmuz', 'PUT-YOUR-PASSWORD-HERE');
```

* Configurer le Virtual Host d'Nginx en editant le fichier /etc/nginx/site-available/default et en vérifiant que ces lignes existes :</br> 
```
root /var/www/html/;
index index.php index.html index.htm index.nginx-debian.html;
```

   Et que le php-fpm (correspondant à votre version) soit activé avec l'existence de ces lignes (dé-commentées) :</br>
```
 location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
  }
```

* Redémarrer le serveur Web et php (correspondant à votre version) pour prendre en compte les modifications :</br> 
```
systemctl enable php8.2-fpm --now
systemctl reload nginx
```

## Utiliser l'Application Web
### Première connexion
* Se connecter avec un navigateur web à l'addresse IP du serveur</br>
<p align="center">
<img src="/img/gestmuz5.png" width="30%" />
</p>

* Entrer les identifiants par défaut :
  * **admin / admin** pour le compte administrateur
  * **superviseur / super** pour le compte superviseur
  * **user / user** pour un compte utilisateur standard.</br>

Vous pouvez aussi créer un compte standard (sans droit d'administration sur le paramétrage de l'application) directement via le formulaire d'inscription.


### Configuration de l'établissement
* Commencez par aller dans le menu Utilisateurs *(Paramètres>Utilisateurs)* pour modifier les comptes par défaut ou en créer de nouveaux</br>

* Continuez en personnalisant votre structure *(Paramètres>Personnalisations)* afin de renseigner son nom, ses horaires d'ouverture...</br>

* Découvrez la configuration de votre structure et adaptez-la en fonction de vos besoins *(Paramètres>Configuration)*</br>
    > Ces 3 menus ne sont accessibles qu'aux administrateurs du logiciel


### Paramétrage des prestations & activités
* Renseignez les activités de votre structure (les **Expositions** programmées, les **Ateliers** prévus, les **Evènements** ponctuels à venir...)</br>
    > Ces 3 menus ne sont pas accessibles aux simples utilisateurs du logiciel

</br>
<h2 align="center"><strong>Vous pouvez dès à présent commencer à enregistrer vos visites !</strong></h2>

### Conseils et Informations
* Seul le nombre des visiteurs est obligatoire pour valider un enregistrement. Le reste des informations se rempli automatiquement ou reste simplement non renseigné .</br>

* Renseigner le code postal des visiteurs suffit à en déduire leur provenance (les menus déroulants associés sont alors désactivés).</br>

* Je vous conseil de cocher les informations sur la visite en commençant par les secteurs visités (ou tout le parcours de visite) puis de décocher les expositions non vues (le cas échéant) pour minimiser le nombre de cliques. Je vous laisse découvrir le mécanisme de séléction "en cascade" des expositions.</br>

* Chaque enregistrement peut être modifié (et même supprimé) pour y apporter des précisions à postériori de la visite.</br>

* L'horodatage des enregistrements ne peut pas être modifié. Il est généré automatiquement lors de l'enregistrement.</br>

* Plus vous donnerez d'informations au logiciel (plannification des expositions, listing des ateliers et catégorie de public pour chacun d'entre eux,...) plus facile sera la gestion des enregistrements.</br>

* Plus vous remplirez d'informations plus vos statistiques seront fins et représentatifs de l'activité du musée (jours et heures de fréquentations, classes d'âge, types de groupes ou catégorie de public pour les ateliers...).</br>

