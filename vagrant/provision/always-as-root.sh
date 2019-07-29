#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Provision script ==

info "Provision-script user: `whoami`"

info "Restart web-stack"
service php7.0-fpm restart
service apache2 stop
service nginx restart
service postgresql restart
#service mysql restart
