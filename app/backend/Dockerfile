FROM yiisoftware/yii2-php:8.3-apache

# Enable rewrite
RUN a2enmod rewrite

# Добавляем конфиг бэка
COPY docker/apache/backend.conf /etc/apache2/sites-available/backend.conf
RUN a2ensite backend.conf \
    && a2dissite 000-default.conf
