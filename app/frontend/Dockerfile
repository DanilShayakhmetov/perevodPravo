FROM yiisoftware/yii2-php:8.3-apache

# Enable rewrite
RUN a2enmod rewrite

# Добавляем конфиг фронта
COPY docker/apache/frontend.conf /etc/apache2/sites-available/frontend.conf
RUN a2ensite frontend.conf \
    && a2dissite 000-default.conf