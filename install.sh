#!/bin/sh

# Make sure the required packages are installed
echo About to start a sudo command, enter your password if required:
sudo apt-get install apache2 php5 mysql-server

# Enable mod_userdir
sudo a2enmod userdir
if [ ! -d ~/public_html ]
then
    mkdir ~/public_html
else
    echo You already have a public_html directory,
    echo we are in risk of replacing files!
fi

# Copy all web content
echo Installing web content to $HOME/public_html...
install -m644 web/* ~/public_html
sed 's/\$USER/'$USER'/g' web/.htaccess > ~/public_html/.htaccess
chmod 644 ~/public_html/.htaccess

# Set up the database
echo Setting up database...
echo About to start a mysql operation as root, enter
echo the password for 'root'@'localhost' if required:
mysql -u root -p < sql/create_db.sql

# Tune innodb a little
sudo install -m644 etc/mysql/innodb.cnf /etc/mysql/conf.d

# (re)start mysql and load the data
echo "(Re)starting MySql..."
sudo service mysql restart
echo Loading data...
time python data/gen-data-mysql.py

echo "(Re)starting Apache..."
sudo service apache2 restart

echo Done.
