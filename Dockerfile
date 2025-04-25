# Usa a imagem base do PHP 8.3 com FPM
FROM php:8.3-fpm

# Atualiza pacotes e instala dependências do sistema
RUN apt-get update && apt-get install -y \
    curl \
    libxml2-dev \
    git \
    unzip \
    zip \
    libzip-dev \
    gnupg \
    && docker-php-ext-install zip soap

# Adiciona o repositório do Microsoft SQL Server para o driver ODBC
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 unixodbc-dev \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copia os arquivos da aplicação para dentro do container
COPY --chown=www-data:www-data . .


# # Garante que o diretório do SQLite exista e tenha as permissões corretas
# RUN mkdir -p /var/www/html/database \
#     # Copiar database.sqlite para dentro do container
#     && cp /var/www/html/database.sqlite /var/www/html/database/database.sqlite \
#     && chown -R www-data:www-data /var/www/html/database \
#     && chmod -R 775 /var/www/html/database

# Copia o banco de dados existente para dentro do container
#COPY database/database.sqlite /var/www/html/database/database.sqlite   Não necessário ao usar SQLSERVER

# Instala as dependências do Composer após garantir que os arquivos foram copiados
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Define permissões adequadas para storage e cache do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expõe a porta 8000 (utilizada pelo Artisan Serve)
EXPOSE 8000

# Comando para rodar o servidor do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]