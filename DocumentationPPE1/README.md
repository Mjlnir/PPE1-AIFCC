# Maison des ligues de Normandie


Projet personnel encadré dans le cadre du BTS SIO.


## Introduction

Ces instructions vous fourniront une copie du projet opérationnel pour un déploiement en production.

### Prérequis

Avant de procéder à l'installation, assurez vous d'avoir les élements suivants

```
Debian 9
Un accès super utilisateur
```

### Installation

Installation du serveur web Apache 2, MYSQL, PHP et les dépendances nécessaires.

```
sudo apt install apache2 php7.0 php7.0-cli php7.0-common php7.0-curl php7.0-gd php7.0-json php7.0-mbstring php7.0-mysql php7.0-xml libapache2-mod-php7.0 mysql-server composer zip
```

Configuration MYSQL

```
sudo mysql_secure_installation
> laisser vide
> set root password : Y
> Saisir le nouveau mot de passe root mysql
> laisser les autres champs vides

```

Création utilisateur MYSQL

```
mysql -u root -p
> saisir le motde passe créé plus haut
> GRANT ALL PRIVILEGES ON *.* TO 'symfony'@'localhost' IDENTIFIED BY 'symfony';
> \q
```

Téléchargement et configuration du projet

```
cd /var/www
sudo git clone https://gitlab.com/simon_ybert/maison-des-ligues-de-normandie.git
cd /var/www/maison-des-ligues-de-normandie
sudo chmod -R 777 .
composer install
> database_host : 127.0.0.1
> database_port : 3306
> database_name : m2n
> database_user : symfony
> database_password : symfony
> laisser les autres champs par défaut
php bin/console cache:clear
php bin/console doctrine:database:create
sudo mysql -u root -p m2n < /var/www/maison-des-ligues-de-normandie/database/m2n.sql
```

Configuration du serveur web

*Editer le fichier /etc/apache2/sites-available/000-default.conf*

```
<VirtualHost *:80>
    ServerName symfony.local
    DocumentRoot "/var/www/maison-des-ligues-de-normandie/web"

    <Directory "/var/www/maison-des-ligues-de-normandie/web">
        DirectoryIndex app.php
        Options -Indexes
        AllowOverride All
        Allow from All
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ app.php [QSA,L]
        AllowOverride All
        Allow from All
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ app.php [QSA,L]
    </Directory>
</VirtualHost>
```

Redémarrer le service Apache et mettre les droits sur le dossier du projet
```
sudo service apache2 restart
sudo chmod -R 777 /var/www/maison-des-ligues-de-normandie/
```


## Premier accès au projet

Pour accéder au projet, saisir l'adresse IP ou nom de domaine du serveur.
Les identifiants par défaut sont: 
Login : Admin
Password: admin 


## Built With

* [Symfony](https://symfony.com/) - Framework
* [Apache](https://httpd.apache.org/) - Serveur Web
* [MySQL](https://www.mysql.com/fr/) - Serveur SQL

## Author

* **Simon YBERT** - *Etudiant BTS SIO*


