# Usando a imagem base do PHP 8.3 FPM
FROM php:8.3-fpm

# Atualiza e instala pacotes necessários, habilita o mysqli e o cliente MySQL
RUN apt-get update && apt-get install -y \
        libmariadb-dev \
        libzip-dev \
        curl \
        gnupg

RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - && \
    apt-get install -y nodejs