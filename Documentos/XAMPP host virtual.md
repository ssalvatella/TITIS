
# Añadir en el fichero C:\xampp\apache\conf\extra\httpd-xampp.conf
```
<VirtualHost *:80>
  ServerName titis.dev
  ServerAlias www.titis.dev
  DocumentRoot "C:/Users/usuario/Documents/GitHub/TITIS/web"
  <Directory "C:/Users/usuario/Documents/GitHub/TITIS/web">
    Allow from all
    AllowOverride All
    Require all Granted
  </Directory>
</VirtualHost>
```
# Añadir en el fichero C:\Windows\System32\drivers\etc\hosts
```
127.0.0.1  titis.dev
```
