# CleanTagProxy
Web Proxy for removing specific html tags from other websites

## Configure a VPS for hosting this app
Get an Ubuntu VPS and follow the following steps


1. Update the linux packages list

    `apt -y update`

2. apt -y install apache2 php-xml php libapache2-mod-php composer certbot python3-certbot-apache
3. ln -s /etc/apache2/mods-available/php.load /etc/apache2/mods-enabled/
4. certbot --apache -d fake.premiertablelinens.com
5. a2dissite 000-default
6. a2dissite 000-default-le-ssl
7. nano /etc/apache2/sites-available/fakeptl.conf

    Put this as the file content
    ```
    <VirtualHost *:443>
        ServerAdmin afernandez@designcodesolutions.com
        DocumentRoot /var/www/fakeptl/public

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        ServerName fake.premiertablelinens.com
        SSLCertificateFile /etc/letsencrypt/live/fake.premiertablelinens.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/fake.premiertablelinens.com/privkey.pem
        Include /etc/letsencrypt/options-ssl-apache.conf
    </VirtualHost>
    ```

8. a2ensite fakeptl.conf
9. systemctl reload apache2
10. systemctl restart apache2

## Deployment

cd /var/www && rm -rf * && wget https://github.com/Albert-DCS/CleanTagProxy/archive/refs/heads/main.zip && unzip main.zip && mv CleanTagProxy-main fakeptl && rm main.zip && cd fakeptl && composer install --no-dev --optimize-autoloader

https://fake.premiertablelinens.com

Remember to have an A DNS record making fake.premiertablelinens.com point to the VPS public IP address.