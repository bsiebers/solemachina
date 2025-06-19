FROM php:8.1-apache

# Activeer mod_rewrite en staat include toe
RUN a2enmod rewrite include

# Basis tools en dev-libs
RUN apt-get update && apt-get install -y \
    gnupg2 \
    curl \
    apt-transport-https \
    ca-certificates \
    lsb-release \
    unzip \
    gcc \
    g++ \
    make \
    autoconf \
    libc-dev

# VERWIJDER de conflicterende ODBC libs (uit Debian 12)
RUN apt-get remove -y libodbc2 libodbcinst2 unixodbc-common || true

# Voeg Microsoft repo toe
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - && \
    curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list

# Update en installeer ODBC-driver en headers
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y \
    msodbcsql17 \
    unixodbc-dev

# Installeer PHP-extensie via PECL
RUN pecl install pdo_sqlsrv && docker-php-ext-enable pdo_sqlsrv

# Laat Apache .htaccess gebruiken in /var/www/html/pages + activeer SSI
RUN echo '<Directory "/var/www/html/pages">\n\
    AllowOverride All\n\
    Options +Includes\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/pages-ssi.conf \
 && a2enconf pages-ssi

# Zet rechten
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

COPY . /var/www/html/

