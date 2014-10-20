sudo apt-get update

sudo apt-get -y install build-essential

#instalar php5
sudo apt-get -y install python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get upgrade
sudo apt-get -y install php5


sudo apt-get install -y apache2
sudo apt-get install -y libapache2-mod-php5
sudo a2enmod rewrite

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
sudo apt-get -y install mysql-server
sudo apt-get install mysql-client

sudo apt-get install -y mysql-server

#php extensions
sudo apt-get install -y php5-mysql

sudo rm -rf /var/www
sudo ln -fs /vagrant/public /var/www

sudo cp /vagrant/vagrant/000-default /etc/apache2/sites-enabled/000-default

sudo /etc/init.d/apache2 restart

sudo debconf-set-selections <<< "postfix postfix/mailname string localhost"
sudo debconf-set-selections <<< "postfix postfix/main_mailer_type string 'Internet Site'"
sudo apt-get install -y postfix

mysql -uroot -proot -e "CREATE SCHEMA laddfwk DEFAULT CHARACTER SET utf8;"

mysql -uroot -proot -e "CREATE TABLE laddfwk.addresses (  id int(11) NOT NULL AUTO_INCREMENT,  name varchar(45) DEFAULT NULL,  phone_number varchar(45) NOT NULL,  address varchar(255) DEFAULT NULL,  PRIMARY KEY (id)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"

sudo cp /vagrant/tests/phpunit.phar /usr/local/bin/phpunit

sudo chmod +x /usr/local/bin/phpunit