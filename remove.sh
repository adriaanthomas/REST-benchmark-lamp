#!/bin/sh

echo About to start a sudo command, enter your password if required:
sudo a2dismod userdir

echo Removing website...
rm -fr ~/public_html

# Remove the database
echo About to start a mysql operation as root, enter
echo the password for 'root'@'localhost' if required:
mysql -u root -p < sql/remove_db.sql

sudo rm /etc/mysql/conf.d/innodb.cnf

echo Restarting services....
sudo service mysql restart
sudo service apache2 restart

echo Done.
