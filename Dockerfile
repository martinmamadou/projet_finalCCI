FROM php:8.2-apache as BASE

SHELL ["/bin/bash", "-c"]

# Install composer 
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Install symfony cli
RUN apt-get update && \
    apt-get install -y git wget curl && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony 

RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip



WORKDIR /app

COPY . .

# Install node and yarn
RUN apt-get update && \
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash && \
    source ~/.bashrc && \
    nvm install 20 && \
    npm install -g yarn && \
    yarn install

RUN composer install

RUN php bin/console about

RUN symfony check:requirements

CMD ["sh", "-c", "symfony console make:migration ; symfony console doctrine:migrations:migrate ; symfony server:start"]
