FROM eboraas/apache:stretch

# utilities
RUN apt-get update && apt-get -y install vim

# php
RUN apt-get update && apt-get -y install php7.0 php7.0-mysql libapache2-mod-php7.0 && apt-get clean && rm -r /var/lib/apt/lists/*
 #RUN /usr/sbin/a2dismod 'mpm_*' && /usr/sbin/a2enmod mpm_prefork

# php modules
RUN apt-get update && apt-get -y install \
git \
curl  \
php7.0-mcrypt \
php7.0-json \ 
php-curl \
php7.0-gd \
php7.0-xml \
php7.0-intl \
&& apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN /usr/sbin/a2enmod rewrite

ADD 000-laravel.conf /etc/apache2/sites-available/
ADD 001-laravel-ssl.conf /etc/apache2/sites-available/
RUN /usr/sbin/a2dissite '*' && /usr/sbin/a2ensite 000-laravel 001-laravel-ssl

RUN /usr/bin/curl -sS https://getcomposer.org/installer |/usr/bin/php
RUN /bin/mv composer.phar /usr/local/bin/composer
# RUN /usr/local/bin/composer create-project laravel/laravel /var/www/laravel --prefer-dist
RUN mkdir -p /var/www/laravel/storage && mkdir -p /var/www/laravel/bootstrap/cache 

# copy project into destination folder
COPY . /var/www/laravel


# set permissions
RUN /bin/chown -R www-data:www-data /var/www/laravel/storage /var/www/laravel/bootstrap/cache /var/www/laravel/storage/logs

# RUN /bin/chmod -R 777  /var/www/laravel/storage/*
RUN /bin/chown -R www-data:www-data /var/www/laravel
RUN find /var/www/laravel -type f -exec chmod 644 {} \;
RUN find /var/www/laravel -type d -exec chmod 755 {} \;

# post-installation 
WORKDIR /var/www/laravel
COPY .env.example .env
# RUN php artisan migrate
# RUN php artisan db:seed
RUN php artisan key:generate


EXPOSE 80
EXPOSE 443
EXPOSE 3306

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
