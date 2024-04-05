# CleanTagProxy
Web Proxy for removing specific html tags from other websites

## Configure a VPS for hosting this app
Get an Ubuntu VPS and follow the following steps

1. apt -y update 
2. apt -y upgrade
RESTART THE VPS
3. apt -y install apache2
4. apt -y install php-xml
5. apt -y install php libapache2-mod-php
6. a2enmod php
7. ln -s /etc/apache2/mods-available/php.load /etc/apache2/mods-enabled/
8. apt -y install composer
9. apt -y install certbot python3-certbot-apache
10. certbot --apache -d fake.premiertablelinens.com
11. mkdir /var/www/fake_ptl_website/

COPY PROJECT FILES
12. cd /var/www/fake_ptl_website/
13. nano .env
    APP_ENV=prod
14. composer install --no-dev --optimize-autoloader
15. nano /etc/apache2/sites-available/fake-ptl-website.conf

    Put this as the file content
    ```
    <VirtualHost *:80>
        ServerAdmin webmaster@fake.premiertablelinens.com
        ServerName fake.premiertablelinens.com
        DocumentRoot /var/www/fake_ptl_website/public

        <Directory /var/www/fake_ptl_website/public>
            AllowOverride All
            Order Allow,Deny
            Allow from All
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```

16. a2ensite fake-ptl-website.conf
17. systemctl reload apache2
18. systemctl restart apache2

After these steps, the server is ready to host the app, by placing the files in:

`/var/www/fake_ptl_website/`

Remember to have an A DNS record making fake.premiertablelinens.com point to the VPS public IP address.