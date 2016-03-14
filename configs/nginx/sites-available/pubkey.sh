server {
  listen 80 default_server;
  listen [::]:80 default_server;

  return 301 https://$host$request_uri;
}

server {
  listen 443 default_server ssl;
  listen [::]:443 default_server ssl;
  server_name .pubkey.sh;

  index index.php;
  root /home/vagrant/vagrant/public;

  include security.conf;
  ssl_certificate /home/vagrant/vagrant/data/server.pem;
  ssl_certificate_key /home/vagrant/vagrant/data/server.key;

  location / {
    try_files $uri $uri/ @rewrite;
  }

  location ~ \.php$ {
    try_files $uri @rewrite;
    include php.conf;
  }

  location @rewrite {
    rewrite ^ /;
  }
}
