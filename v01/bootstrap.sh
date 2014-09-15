#!/usr/bin/env bash

if [ ! -f ~/provisioned ]
then

# set timezone
sudo ln -sf /usr/share/zoneinfo/Europe/Zurich /etc/localtime

# update packages
sudo apt-get update

# could not select device at grub upgrade
#sudo apt-get upgrade

# mysql settings
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'

# phpmyadmin settings
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password root'

#install apache2
sudo apt-get install -y apache2

#install mysql
sudo apt-get install -y mysql-server libapache2-mod-auth-mysql php5-mysql
sudo mysql_install_db

#install php
sudo apt-get install -y php5 libapache2-mod-php5 php5-mcrypt

# show php errors
sudo sed -i '/display_errors = Off/c display_errors = On' /etc/php5/apache2/php.ini

#create phpinfo
rm /var/www/index.html
echo "<?php phpinfo(); ?>" > /var/www/index.php

# php5-cgi - server-side, HTML-embedded scripting language (CGI binary)
# php5-cli - command-line interpreter for the php5 scripting language
# php5-common - Common files for packages built from the php5 source
# php5-curl - CURL module for php5
# php5-dbg - Debug symbols for PHP5
# php5-dev - Files for PHP5 module development
# php5-gd - GD module for php5
# php5-gmp - GMP module for php5
# php5-ldap - LDAP module for php5
# php5-mysql - MySQL module for php5
# php5-odbc - ODBC module for php5
# php5-pgsql - PostgreSQL module for php5
# php5-pspell - pspell module for php5
# php5-recode - recode module for php5
# php5-snmp - SNMP module for php5
# php5-sqlite - SQLite module for php5
# php5-tidy - tidy module for php5
# php5-xmlrpc - XML-RPC module for php5
# php5-xsl - XSL module for php5
# php5-adodb - Extension optimising the ADOdb database abstraction library
# php5-auth-pam - A PHP5 extension for PAM authentication

#install phpmyadmin
sudo apt-get install -y phpmyadmin
cd /var/www
echo 'Include /etc/phpmyadmin/apache.conf' | sudo tee -a /etc/apache2/apache2.conf

# restart apache
sudo service apache2 restart

#install xdebug
sudo apt-get install -y php5-dev php-pear
sudo apt-get install make
sudo pecl install xdebug
echo 'zend_extension="/usr/lib/php5/20060613/xdebug.so"' | sudo tee -a /etc/php5/apache2/php.ini


touch ~/provisioned
fi