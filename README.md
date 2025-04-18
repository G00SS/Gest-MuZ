# Gest'MuZ
Une application web (PHP/MySQL) pour générer des statistiques de fréquentation d'un musée ou d'un établissement touristique...
> A Web App (PHP/MySQL) to generate statistics on visits to a museum/touristic establishment...

Cette application web permet d'enregistrer des informations sur les visiteurs d'un musée ou tout autre établissement touristique, qu'il s'agisse de visites individuelles ou de groupes, scolaires ou non.
Il suffit de remplir un court formulaire pour chaque visite afin de générer automatiquement des statistiques sur la fréquentation, la provenance, les centres d'intérêt des visiteurs, etc.
> This french web application allows you to record informations about visitors to an establishment, whether they are individual visits or groups, whether school-based or not.
Simply fill out a short form for each visit to automatically generate statistics on attendance, origin, interests, and more.

## Pré-Requis / *Prerequisites*
Écrite principalement en HTML et PHP, cette application web nécessite uniquement un serveur web opérationnel avec une version minimale de PHP 7.0 et un accès à un serveur MySQL. Elle peut donc fonctionner sur une instance XAMP, une machine virtuelle Linux, un Raspberry Pi ou tout autre ordinateur répondant à ces exigences.
> Written primarily in HTML and PHP, this web application requires only a working web server with a minimum version of PHP 7.0 and access to a MySQL server. This application can therefore run on a XAMP instance, a Linux VM, a Raspberry Pi, or any other computer that meets these requirements.

Les instructions d'installation et d'utilisation suivantes sont basées sur une nouvelle installation de Debian avec Nginx comme serveur Web et MariaDB comme serveur MySQL.
> The following installation and usage instructions are based on a Debian's fresh install with Nginx as web server and MariaDB as MySQL server.

## Comment Essayer depuis un Systeme Vierge / *How to Try demo from Scratch*

* Se connecter sur le serveur et y installer le serveur web Nginx, PHP, et MariaDB (MySQL) :  
<code style="color : cyan">$ apt install nginx mariadb-server mariadb-client php php-fpm php-mbstring php-bcmath php-xml php-mysql php-common php-gd php-cli php-curl php-zip php-gd</code>


