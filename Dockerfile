# Используем базовый образ PHP 8.3 с Apache
FROM php:8.3-apache

# Обновляем индекс пакетов и устанавливаем необходимые зависимости
RUN apt-get update \
    && apt-get install -y \
    # Система контроля версий Git
    git \
    # Инструмент для работы с HTTP-запросами
    curl \
    # Библиотека для работы с PNG изображениями
    libpng-dev \
    # Библиотека для работы со строками (для mbstring)
    libonig-dev \
    # Библиотека для работы с XML
    libxml2-dev \
    # Утилита для создания ZIP-архивов
    zip \
    # Утилита для распаковки ZIP-архивов
    unzip \
    # Библиотека для работы с сжатыми файлами
    zlib1g-dev \
    # Библиотека для работы с PostgreSQL
    libpq-dev \
    # Библиотека для работы с ZIP-архивами
    libzip-dev

# Включаем модуль rewrite Apache, необходимый для Laravel
RUN a2enmod rewrite

# Устанавливаем корневую директорию Apache в public директорию Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Копируем файл конфигурации Apache, чтобы настроить сервер для Laravel
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Конфигурируем и устанавливаем PHP расширения для PostgreSQL, ZIP, BCMath, и GD
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath gd

# Копируем Composer из официального образа в наш контейнер
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию для контейнера
WORKDIR /var/www/html

# Копируем все файлы проекта в контейнер
COPY . .

# Устанавливаем зависимости Laravel с помощью Composer
RUN composer install

# Устанавливаем права доступа для папок storage и bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Открываем порт 80 для доступа к приложению через HTTP
EXPOSE 80

# Запускаем Apache веб-сервер в переднем плане
CMD ["apache2-foreground"]
