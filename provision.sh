apt-get update
apt-get install -y apache2 composer php7.0-zip php7.0-curl libapache2-mod-php7.0 php7.0-gmp

VHOST=$(cat <<EOF
<VirtualHost *:80>
  DocumentRoot "/var/www/html/app/public"
  <Directory "/var/www/html/app/public">
    AllowOverride All
  </Directory>
</VirtualHost>
EOF
)

echo "${VHOST}" > /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite
a2enmod rewrite
a2enmod php7.0

# Restart apache
service apache2 restart