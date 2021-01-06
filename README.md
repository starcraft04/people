This tool will help on people management

Install
_______
Those are the steps used on a Debian 10
1) Install apache, php and mysql
```
    sudo apt-get update
    sudo apt-get install apache2 php7.3 mariadb-server-10.3 libapache2-mod-php7.3 php7.3-mysql
```
2) Install PHPmyadmin (optionnal if you need to work on the database)
```
    sudo apt-get install phpmyadmin
```
3) Install Git
```
    sudo apt-get install git
```
4) Install the application (go in the appropriate directory first, eg: /var/www/html)
```
    sudo git clone https://github.com/starcraft04/people/ .
```
5) Install composer (attention, go to the composer website and install from there don't use apt as it doesn't install latest version)
```
    https://getcomposer.org/download/
    When you have composer.phar, rename to composer and move to /usr/bin/composer
```
6) Changed owner and group of www with
```
    sudo chgrp -R <user> /var/www/html/
    sudo chown -R <user> /var/www/html/
    sudo chmod a+w -R /var/www/html/bootstrap/cache/
    sudo chmod a+w -R /var/www/html/storage/
```
7) Execute composer to install necessary applications for Laravel 5
```
    sudo composer update
```
   if you are missing some php packages, it could be:
```
    sudo apt-get install php7.3-xml
    sudo apt-get install php7.3-gd
    sudo apt-get install php7.3-zip
```
8) Rename .env.example into .env with
```
    mv .env.example .env
```
9) Install composer dependencies
```
    composer install --prefer-dist
```
10) Create an application key
```
    sudo php artisan key:generate
```
11) Go in phpmyadmin and create a database name "people"
12) Edit .env
    > Update Application key eg: "base64:26pmIRt/R7deEbuTNjlIlugejU++DpXLfKKLuAAAAAA="
    > Enter information about MySQL database credentials 
13) Restart apache
```
    sudo service apache2 restart
```
14) Edit /etc/apache2/apache2.conf
    > change from
    ```
    <Directory /var/www/>
            Options Indexes FollowSymLinks
            AllowOverride None
            Require all granted
    </Directory>
    ```
    > to
    ```
    <Directory /var/www/>
            Options FollowSymLinks
            AllowOverride All
            Allow from all
            Require all granted
    </Directory>
    ```
    Then run
    ```
    a2enmod rewrite
    ```
    then restart apache by:
    ```
    sudo service apache2 restart
    ```
15) Go to .../public/niceartisan/

  >  do migrate
  >  do db seed
  ```
    php artisan migrate --seed
  ```
  > If reset is not working, do
```
    php composer dump-autoload
```
16) Modify your php.ini file (for php 7, located at: /etc/php/7.0/apache2/php.ini)
```
    Upload_max_filesize  - 15 M
    Max_input_time  - 600
    Memory_limit    - 128M
    Max_execution_time -  600
    Post_max_size - 15 M
```
17) Install zip support for the Excel file module to work
```
    sudo apt-get install php7.0-zip
    sudo service apache2 restart
```
18) In order to make sure that the git update button works, please enter the following
```
    sudo visudo
```
  > Add the line: git ALL=(www-data) /usr/bin/git pull
19) run mysqldump --version to make sure it is installed or install it if not already done
```
    sudo apt-get install mysql-client
```
20) if you are going to use the automatic backup function, then you need to enter this in your cron
```
    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
21) if you need to change the frequency of automatic backups, edit app/console/kernel.php
22) the backups will be stored in storage/app/backup/ and you need to make sure to modify the access to 2 folders:
```
    sudo chmod a+rwx /var/www/html/storage/app/backup
    sudo chmod a+rwx /var/www/html/storage/laravel-backups
```
