# Gest'MuZ
Une application web (PHP/MySQL) pour générer des statistiques de fréquentation d'un musée ou d'un établissement touristique...</br>
*A Web App (PHP/MySQL) to generate statistics on visits to a museum/touristic establishment...*

Cette application web permet d'enregistrer des informations sur les visiteurs d'un musée ou tout autre établissement touristique, qu'il s'agisse de visites individuelles ou de groupes, scolaires ou non.
Il suffit de remplir un court formulaire pour chaque visite afin de générer automatiquement des statistiques sur la fréquentation, la provenance, les centres d'intérêt des visiteurs, etc.</br>
*This french web application allows you to record informations about visitors to an establishment, whether they are individual visits or groups, whether school-based or not.
Simply fill out a short form for each visit to automatically generate statistics on attendance, origin, interests, and more.*

## Pré-Requis / *Prerequisites*
Écrite principalement en HTML et PHP, cette application web nécessite uniquement un serveur web opérationnel avec une version minimale de PHP 7.0 et un accès à un serveur MySQL. Elle peut donc fonctionner sur une instance XAMP, une machine virtuelle Linux, un Raspberry Pi ou tout autre ordinateur répondant à ces exigences.</br>
*Written primarily in HTML and PHP, this web application requires only a working web server with a minimum version of PHP 7.0 and access to a MySQL server. This application can therefore run on a XAMP instance, a Linux VM, a Raspberry Pi, or any other computer that meets these requirements.*

Les instructions d'installation et d'utilisation suivantes sont basées sur une nouvelle installation de Debian avec Nginx comme serveur Web et MariaDB comme serveur MySQL.</br>
*The following installation and usage instructions are based on a Debian's fresh install with Nginx as web server and MariaDB as MySQL server.*

## Comment Installer depuis un Systeme Vierge / *How to Install from Scratch*

* Se connecter sur le serveur et y installer le serveur Web Nginx, PHP, et MariaDB (MySQL) :</br>  
<code># apt install nginx mariadb-server mariadb-client php php-fpm php-mysql php-common</code>

* Récupérer le dossier du site web :</br>
```
# wget https://github.com/G00SS/Gest-MuZ.git
```

* Copier les fichiers du site Web à la racine du serveur Web :</br>
<code># mv gestmuz/* /var/www/html/</code>

* Créer une base de données et son utilisateur pour l'application :</br>
<code># mysql -u root -p</code></br>
<code>mysql> CREATE USER 'gestmuz'@'localhost' IDENTIFIED BY 'PUT-YOUR-PASSWORD-HERE';</code></br>
<code>mysql> CREATE DATABASE IF NOT EXISTS `bmus`;</code></br>
<code>mysql> GRANT ALL PRIVILEGES ON `bmus`.* TO 'gestmuz'@'localhost' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;</code></br>
<code>mysql> FLUSH PRIVILEGES;</code></br>
<code>mysql> QUIT;</code>

* Importer la structure de la base de données</br> 
<code># mysql -u gestmuz -p bmus < /var/www/html/bdd/bmus.sql</code>

* Editer le fichier gestmuz/inc/bd.php afin qu'il corresponde à votre base de données en modifiant la ligne 5 :</br>
<code>$dbh = new PDO('mysql:host=localhost;dbname=bmus;charset=utf8', 'gestmuz', 'PUT-YOUR-PASSWORD-HERE');</code>

* Configurer le Virtual Host d'Nginx en editant le fichier /etc/nginx/site-available/default et en vérifiant que ces lignes existes :</br> 
<code>root /var/www/html/;</code></br>
<code>index index.php index.html index.htm index.nginx-debian.html;</code></br>

   Et que le php-fpm (correspondant à votre version) soit activé avec l'existence de ces lignes (dé-commentées) :</br>
   <code> location ~ \.php$ {</code></br>
   <code>    include snippets/fastcgi-php.conf;</code></br>
   <code>    fastcgi_pass unix:/run/php/php8.2-fpm.sock;</code></br>
   <code>  }</code></br>

* Redémarrer le serveur Web et php (correspondant à votre version) pour prendre en compte les modifications :</br> 
<code># systemctl enable php8.2-fpm --now</code></br>
<code># systemctl reload nginx</code></br>

## Utiliser la Web Application / *Using the WebAPP*

* Se connecter avec un navigateur web à l'addresse IP du serveur</br>

* Entrer les identifiants par défaut : **admin / admin**</br>

* Commencez par aller dans le menu Utilisateurs *(Paramètres>Utilisateurs)* pour modifier les comptes par défaut ou en créer de nouveaux</br>

* Continuez en personnalisant votre structure *(Paramètres>Personnalisations)* afin de renseigner son nom, ses horaires d'ouverture...</br>

* Découvrez la configuration de votre structure et adaptez-la en fonction de vos besoins *(Paramètres>Configuration)* </br>
> Ces 3 menus ne sont accessibles qu'aux administrateurs du logiciel

* Renseignez les activités de votre structure (les expositions programmées, les ateliers prévus, les évènements ponctuels à venir...) </br>
> Ces 3 menus ne sont pas accessibles aux simples utilisateurs du logiciel

**Vous pouvez dès à présent commencer à enregistrer vos visites !**
