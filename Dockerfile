FROM eboraas/apache:stretch

RUN apt-get update && apt-get -y install php7.0 php7.0-mysql libapache2-mod-php7.0 unzip && apt-get clean && rm -r /var/lib/apt/lists/*
 #RUN /usr/sbin/a2dismod 'mpm_*' && /usr/sbin/a2enmod mpm_prefork

RUN apt-get update && apt-get -y install git curl php7.0-mcrypt php7.0-json php7.0-mbstring php-xml php7.0-zip php7.0-cli php7.0-curl php7.0-pdo && apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/*

# restart apache
RUN /etc/init.d/apache2 restart

RUN /usr/sbin/a2enmod rewrite

ADD 000-laravel.conf /etc/apache2/sites-available/
ADD 001-laravel-ssl.conf /etc/apache2/sites-available/
RUN /usr/sbin/a2dissite '*' && /usr/sbin/a2ensite 000-laravel 001-laravel-ssl

RUN /usr/bin/curl -sS https://getcomposer.org/installer |/usr/bin/php
RUN /bin/mv composer.phar /usr/local/bin/composer
RUN /usr/local/bin/composer create-project "laravel/laravel:5.5.*" /var/www/laravel --prefer-dist
RUN mkdir -p /var/www/laravel/storage && mkdir -p /var/www/laravel/bootstrap/cache 

# copy project into destination folder
COPY . /var/www/laravel

# set permissions
RUN /bin/chown -R www-data:www-data /var/www/laravel/storage /var/www/laravel/bootstrap/cache /var/www/laravel/storage/logs

RUN /bin/chmod -R 755  /var/www/laravel/storage/*
# RUN /bin/chmod 644  /var/www/laravel/storage/logs/laravel.log
# RUN /bin/chown -R www-data:www-data /var/www/laravel
# RUN find /var/www/laravel -type f -exec chmod 644 {} \;
# RUN find /var/www/laravel -type d -exec chmod 755 {} \;

RUN cd /var/www/laravel && php artisan migrate

EXPOSE 80
EXPOSE 443
# EXPOSE 3306


# migrations
# RUN cd /var/www/laravel && php artisan migrate # connection refused

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]


