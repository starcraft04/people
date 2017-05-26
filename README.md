This tool will help on people management

Install
_______
For Linux Ubuntu
1) Install LAMP with
    sudo apt-get update
    sudo apt-get install apache2 php5 mysql-server libapache2-mod-php5 php5-mysql
2) Install PHPmyadmin
    sudo apt-get install phpmyadmin
3) Changed owner and group of www with
    sudo chgrp -R <user> www
    sudo chown -R <user> www
4) Install Git
    sudo apt-get install git
5) Install the application
    git clone https://github.com/starcraft04/people/
6) Install composer
    sudo apt-get install composer
7) Execute composer to install necessary applications for Laravel 5
    sudo composer update

