FROM antage/apache2-php7

RUN apt-get update \
	&& apt-get install -y git \
	&& git clone https://github.com/andreaskasper/esyadmin.git /var/www/html \
	&& apt-get clean

ENV APACHE_DOCUMENT_ROOT	/var/www/html/src
ENV PHP_SMTP				localhost
ENV PHP_SMTP_FROM			localhost

EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2"]