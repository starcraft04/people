This tool will help on people management

Install
_______
Those are the steps used on a Debian 10
1) Install apache, php and mysql
```
    sudo apt-get update
    sudo apt-get install apache2 php7.3 mariadb-server-10.3 libapache2-mod-php7.3 php7.3-mysql
```
   If you need to setup your DB for the first time, use
```
   sudo mysql_secure_installation
```
2) Configure the database to have a db for the tool and a user pass to access it
```
    sudo mysql
    CREATE DATABASE <db_name>;
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
    make sure it is installed like this to have it available globally: sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    When you have composer.phar, rename to composer and move to /usr/bin/composer
```
6) Changed owner and group of www with
```
    sudo chown -R <user> /var/www/html/
```
    And for Laravel to be able to write temp files:
```
    sudo chmod a+w -R /var/www/html/bootstrap/cache/
    sudo chmod a+w -R /var/www/html/storage/
```
7) Execute composer to install necessary applications for Laravel 5
```
    composer install
```
   And also install the following php packages:
```
    sudo apt-get install php7.3-xml php7.3-gd php7.3-zip php7.3-mbstring
```
8) Rename .env.example into .env with
```
    mv .env.example .env
```
9) Create an application key
```
    php artisan key:generate
```
10) Edit .env
    > Enter information about MySQL database credentials
    > Enter location of mysqldump executable (usually in /usr/bin/)
11) Restart apache
```
    sudo service apache2 restart
```
12) Edit /etc/apache2/apache2.conf
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
    
13) Upgrade DB and use the seeds to create a user admin with the basic rights (admin@orange.com // Welcome1)
    ```
    php artisan migrate
    php artisan db:seed --class=DatabaseSeeder
    ```
    If reset is not working, do
    ```
    php composer dump-autoload
    ```
14) Modify your php.ini file (for php 7, located at: /etc/php/7.3/apache2/php.ini)
```
    Upload_max_filesize  - 15 M
    Max_input_time  - 600
    Memory_limit    - 128M
    Max_execution_time -  600
    Post_max_size - 15 M
```
15) In order to make sure that the git update button works, please enter the following
```
    sudo visudo
```
  > Add the line: git ALL=(www-data) /usr/bin/git pull
16) if you are going to use the automatic backup function, then you need to enter this in your cron (crontab -e)
```
    * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
