Ubuntu 20.04

## Actualización de paquetes Ubuntu
    sudo apt-get update
    sudo apt-get upgrade
    sudo apt-get update

## Apache2
    sudo apt-get install apache2

## PHP 7.4
    sudo apt install php php-cli php-fpm php-json php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath

## Composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    
    sudo mv composer.phar /usr/local/bin/composer

## Modo reescritura Apache2
    sudo a2enmod rewrite
    sudo service apache2 restart

### En caso de algun problema corre estos comando para reinstalar el apache:
    sudo apt-get purge apache2
    sudo apt autoremove apache2
    sudo apt-get purge apache2
    sudo apt-get purge apache2*
    sudo apt-get install apache2
    sudo service apache2 start

## Configuración Apache2
    sudo nano /etc/apache2/apache2.conf

##### Busca user y Group, comentalos y agrega esto: 
        User ubuntu
        Group ubuntu
##### Pega esto mas abajo en las seccion de Directorios:
 
        <Directory /home/ubuntu/>
            Options Indexes FollowSymLinks 
            AllowOverride All 
            Require all granted 
        </Directory>

## Sitio por defecto Apache2
    sudo nano /etc/apache2/sites-enabled/000-default.conf

## Configuración php.ini
    //sudo nano /etc/php/7.4/apache2/php.ini
    sudo nano /etc/php/7.4/fpm/php.ini
##### Busca estas variables y cambiales el tamaño:
    memory_limit = 2048M
    post_max_size = 2048M
    upload_max_filesize = 2048M

## Reinicio del servidor Apache2
    sudo service apache2 restart

## Instalación proyecto Laravel 8
    composer create-project laravel/laravel nombre_proyecto

## Instalar Node
    sudo apt update
    sudo apt install nodejs 
    nodejs -v
    sudo apt install npm

## Instalar git
    sudo apt install git
    git --version
