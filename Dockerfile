FROM php:8.2-apache

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar projeto
COPY . /var/www/html/

# Ajustar permissões (evita erro 403)
RUN chown -R www-data:www-data /var/www/html

# Expor porta para o Render
EXPOSE 80
