echo '-- Installing apache and php mods --';
apt-get update
apt-get install -y zip unzip apache2 composer libapache2-mod-php7.0 php7.0-zip php7.0-curl php7.0-mbstring php7.0-gmp
echo '-- Successfully installed apache and php mods --';

echo '-- Creating apache vhost --';
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
echo '-- Successfully created apache vhost --';

echo '-- Enabling Apache mods  --';
# Enable mod_rewrite
a2enmod rewrite
a2enmod php7.0

# Restart apache
service apache2 restart
echo '-- Successfully enabled Apache mods --';