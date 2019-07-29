#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Import script args ==

timezone=$(echo "$1")

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Configure locales"
echo 'hu_HU.UTF-8 UTF-8' >> /etc/locale.gen
locale-gen

wget -q https://www.postgresql.org/media/keys/ACCC4CF8.asc -O - | apt-key add -
echo "deb http://apt.postgresql.org/pub/repos/apt/ stretch-pgdg main" >> /etc/apt/sources.list.d/pgdg.list



info "Update OS software"
apt-get update
apt-get upgrade -y

# Install additional software

apt-get install -y vim ssh screen sudo less ntp ntpdate lsof rsync mc whois htop sysstat bzip2 tcpdump dstat dnsutils curl telnet
apt-get install -y git memcached php7.0 php7.0-cli php7.0-curl php7.0-gd php7.0-intl php7.0-mbstring php7.0-mcrypt php7.0-pgsql php-memcached phpunit postgresql php-zip
apt-get install -y php-xdebug

info "Stopping apache"
service apache2 stop

info "Install nginx"
apt-get install -y nginx

# Configure PostgreSQL

sed -i "s/# DO NOT DISABLE!/local all all trust\n# DO NOT DISABLE!/" /etc/postgresql/11/main/pg_hba.conf
service postgresql restart

db_user_name='denes'
db_user_pass='asd123'
db_name='ticket'

# Initialize database: $db_name
echo "CREATE USER $db_user_name WITH PASSWORD '$db_user_pass';" | psql -U postgres
echo "CREATE DATABASE $db_name OWNER $db_user_name ENCODING 'UTF8' LC_COLLATE = 'hu_HU.UTF-8' LC_CTYPE = 'hu_HU.UTF-8' TEMPLATE = template0;" | psql -U postgres
echo "ALTER SCHEMA public OWNER TO ${db_user_name};" | psql -U postgres ${db_name}


cat << EOF > /etc/php/7.0/mods-available/xdebug.ini

zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"


info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
