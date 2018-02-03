FROM ubuntu:14.04

# Setup environment
ENV DEBIAN_FRONTEND noninteractive

# Update sources
ADD sources.list  /etc/apt/sources.list
RUN apt-get update -y  &&  rm -rf /var/lib/apt/lists/*

RUN echo "Asia/Chongqing" > /etc/timezone
RUN sudo dpkg-reconfigure -f noninteractive tzdata



RUN mkdir -p /var/lock/apache2 /var/run/apache2

RUN apt-get -qq update && apt-get install -y \
  apache2 \
  vim  \
  unzip \
  php5  \
  php5-mysql \ 
  php5-dev \
  php5-gd \
  php5-memcache \ 
  php5-pspell \
  php5-snmp \
  snmp \
  php5-xmlrpc \ 
  libapache2-mod-php5 \ 
  php5-cli  \
  supervisor

RUN a2enmod rewrite


# install supervisord
RUN mkdir -p /var/log/supervisor

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf


ADD p.php /var/www/html/


COPY lamp/php.ini /etc/php5/apache2/php.ini


RUN echo "Asia/Chongqing" > /etc/timezone

WORKDIR /var/www/html

EXPOSE 22 80 443

CMD ["supervisord", "-n"]
