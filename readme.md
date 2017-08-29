# Iaffiliate

A Hard working Pinoys Services  project. 

## Installation
run this first
``` bash
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1
```
1. Run the commands below after cloning the repository to install all dependencies:
```bash
composer install 
```
2. Setup your .env file, make sure you choose `log` as the mail driver for development systems.
3. Allow write permissions in cache etc
```bash
chmod -R 777 bootstrap/cache storage/
```
4. On every deployment run the following TWICE: 
```bash
composer dump-autoload -o  && php artisan view:clear && php artisan cache:clear
``` 
5. Don't forget to add ZERO PARK and Voluum creds in the `.env` file.
6. When all done, run migrations `php artisan migrate`
7. you can seed the DB via `php artisan db:seed`
8. For development set the MAIL_DRIVER to "log"
9. add cron jobs. reference https://laravel.com/docs/5.4/scheduling
to create jobs using bash
https://www.cyberciti.biz/faq/how-do-i-add-jobs-to-cron-under-linux-or-unix-oses/
```bash
crontab -e
```
then paste * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1


# Install apache2 and mysqlserver to your server

1. https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04


# Create Database to your server use ssh access
1. mysql -u {username} -p press enter
2. CREATE DATABASE {databasename};


# Clone Project 
1. go to cd /var/www/html
2. git clone this project


# Setup your database on .env
1. set database on DB_DATABASE={databasename}
2. set database password on DB_PASSWORD={databasepassword}
3. set database username on DB_USERNAME={databaseusername}

# Setup site
1. sudo vim /etc/apache2/sites-available/iaffiliate.conf
2. paste this code

```bash
   
   <VirtualHost *:80>
	    ServerName {urlname}
	    ServerAlias {you ip address}

	    DocumentRoot /var/www/html/iaffiliate/public
	    <Directory /var/www/html/iaffiliate/public>
	        # Don't show directory index
	        Options -Indexes +FollowSymLinks +MultiViews

	        # Allow .htaccess files
	        AllowOverride All

	        # Allow web access to this directory
	        Require all granted
	    </Directory>

	    # Error and access logs
	    ErrorLog ${APACHE_LOG_DIR}/my-site.error.log
	    # Possible values include: debug, info, notice, warn, error, crit,
	    # alert, emerg.
	    LogLevel warn
	    CustomLog ${APACHE_LOG_DIR}/my-site.access.log combined
	</VirtualHost>
```
3. sudo a2ensite iaffiliate
4. sudo service apache2 reload


# Install Composer
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-16-04
