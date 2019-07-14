FROM antage/apache2-php7

RUN git clone https://github.com/andreaskasper/esyadmin.git /var/www/html

ENV APACHE_DOCUMENT_ROOT	/var/www/html/src
ENV PHP_SMTP				localhost
ENV PHP_SMTP_FROM			localhost

EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2"]