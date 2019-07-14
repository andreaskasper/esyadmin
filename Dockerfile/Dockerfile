FROM antage/apache2-php7

RUN apt-get update \
	&& apt-get install -y git php-curl \
	&& git clone https://github.com/andreaskasper/esyadmin.git /var/www/html \
	&& phpenmod curl \
	&& apt-get clean

ENV APACHE_DOCUMENT_ROOT	/var/www/html/src
ENV PHP_SMTP				localhost
ENV PHP_SMTP_FROM			localhost
ENV APACHE_ALLOW_OVERRIDE   All

EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2"]