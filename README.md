# CleanTagProxy
Web Proxy for removing specific html tags from other websites

## Configure a VPS for hosting this app
Get an Ubuntu VPS and follow the following steps

1. apt update
2. apt upgrade
3. apt install apache2
4. mkdir /var/www/fake_ptl_website/
5. cd /var/www/fake_ptl_website/
6. nano index.html

    Put this as the file content
    ```
    <html>
        <head>
            <title>FakePTL VPS</title>
        </head>
        <body>
            <h1>Server is up and running!</h1>
        </body>
    </html>
    ```
7. nano /etc/apache2/sites-available/fake-ptl-website.conf

    Put this as the file content
    ```
	<VirtualHost *:80>
		ServerAdmin webmaster@fake.premiertablelinens.com
		ServerName fake.premiertablelinens.com
		DocumentRoot /var/www/fake_ptl_website

		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>
    ```

8. a2ensite fake-ptl-website.conf
9. systemctl reload apache2
10. apt install certbot python3-certbot-apache
11. certbot --apache -d fake.premiertablelinens.com
12. systemctl restart apache2

After these steps, the server is ready to host the app, by placing the files in:

`/var/www/fake_ptl_website/`

Remember to have an A DNS record making fake.premiertablelinens.com point to the VPS public IP address.