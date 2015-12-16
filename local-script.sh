#!/usr/bin/env bash
#https://wiki.archlinux.org/index.php/Color_Bash_Prompt
echo "" >> /home/vagrant/.bashrc
echo "PS1='\[\e[1;31m\][\u@\h \W]\$\[\e[0m\] '" >> /home/vagrant/.bashrc

mkdir -p /etc/apache2/sites-enabled/
cp /vagrantyii1/config/etc/apache2/sites-enabled/* /etc/apache2/sites-enabled/

echo "Installing PHP5"

apt-get install libapache2-mod-php5
apt-get install php5-cli
apt-get install php5-curl
apt-get install php5-gd
apt-get install php5-geoip
apt-get install php5-imagick
apt-get install php5-intl
apt-get install php5-json
apt-get install php5-mcrypt
apt-get install php5-mysql
apt-get install php5-tidy
apt-get install php5-xsl
apt-get install php5-xmlrpc

echo "Restarting Apache2"

service apache2 restart

apt-get install htop

echo "Creating databases"

mysql -u root -proot -e "create database vagrantyii1;";

echo "Importing databases"

mysql -u root -proot vagrantyii1 < /vagrantyii1/config/db/db.sql

echo "Enabling mod-rewrite"

a2enmod rewrite

echo "Installing node.js"

apt-get update
apt-get install -y  python g++ make
add-apt-repository -y ppa:chris-lea/node.js
apt-get update
apt-get install -y  nodejs
ln -s "$(which nodejs)" /usr/bin/node

echo "App Settings"

mkdir /vagrantyii1/app/assets
mkdir /vagrantyii1/app/protected/runtime
mkdir /vagrantyii1/app/images
mkdir /vagrantyii1/app/images/avatars
chmod 777 /vagrantyii1/app/images/avatars
chmod  777 /vagrantyii1/app/protected/runtime
chmod  777 /vagrantyii1/app/assets
