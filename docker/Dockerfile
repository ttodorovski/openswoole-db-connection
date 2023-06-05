FROM php:8.1-cli

RUN apt-get update && apt-get install vim -y && \
    apt-get install openssl -y && \
    apt-get install libssl-dev -y && \
    apt-get install wget -y && \
    apt-get install git -y && \
    apt-get install procps -y && \
    apt-get install htop -y && \
    apt-get install build-essential -y && \
    apt-get install curl -y && \
    apt-get install libcurl4-openssl-dev -y && \
    apt-get install uuid-dev

RUN cd /tmp && git clone https://github.com/openswoole/ext-openswoole.git && \
    cd ext-openswoole && \
    git checkout v22.0.0 && \
    phpize  && \
    ./configure --enable-openssl --enable-hook-curl --enable-http2 --enable-mysqlnd \
    --enable-hook-curl  --enable-swoole-json && \
    make && make install

RUN touch /usr/local/etc/php/conf.d/openswoole.ini && \
    echo 'extension=openswoole.so' > /usr/local/etc/php/conf.d/zzz_openswoole.ini

RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64
RUN chmod +x /usr/local/bin/dumb-init

RUN docker-php-ext-install pdo_mysql \
    && pecl channel-update pecl.php.net \
    && pecl install uuid-1.2.0 \
    && docker-php-ext-enable uuid

RUN apt-get autoremove -y && rm -rf /var/lib/apt/lists/*

ENTRYPOINT ["/usr/local/bin/dumb-init", "--", "php"]
