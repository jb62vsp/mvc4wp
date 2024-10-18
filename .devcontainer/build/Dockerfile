FROM composer:2.2 as composer
FROM node:20 as node

FROM wordpress:6.6-php8.1-apache

# apt
RUN apt update \
 && apt install -y libfreetype6-dev zlib1g git \
 && apt -y clean \
 && rm -rf /var/lib/apt/lists/*

# php-extention
RUN pecl install xdebug \
 #&& docker-php-ext-install pdo_mysql \
 && docker-php-ext-install mysqli \
 && docker-php-ext-enable mysqli \
 && docker-php-ext-configure gd --with-freetype \ 
 && docker-php-ext-install gd \
 && docker-php-ext-enable xdebug

# apache
RUN sed -i '/<VirtualHost \*:80>/,/<\/VirtualHost>/ s/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/wordpress/' /etc/apache2/sites-available/000-default.conf
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# UID, GID
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# copy from composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# copy from node
COPY --from=node /usr/local/bin /usr/local/bin
COPY --from=node /usr/local/lib/node_modules/npm /usr/local/lib/node_modules/npm
COPY --from=node /opt/yarn-* /opt/yarn
RUN rm -f /opt/yarn/bin/yarn && ln -fs /opt/yarn/bin/yarn /usr/local/bin/yarn \
 && rm -f /opt/yarn/bin/yarnpkg && ln -fs /opt/yarn/bin/yarnpkg /usr/local/bin/yarnpkg
