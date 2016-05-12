server {
  listen      8080 default_server;
  listen [::]:8080 default_server;
  server_name .pubkey.sh;

  return 301 https://$host:1443$request_uri;
}

server {
  listen      1443 default_server ssl;
  listen [::]:1443 default_server ssl;
  server_name .pubkey.sh;

  index index.php;
  root /home/ubuntu/vagrant/public;

  include security.conf;
  ssl_certificate     /home/ubuntu/vagrant/data/server.pem;
  ssl_certificate_key /home/ubuntu/vagrant/data/server.key;

  location / {
    try_files $uri $uri/ @rewrite;
  }

  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php7.0-fpm.sock;
  }

  location @rewrite {
    rewrite ^ /;
  }
}
