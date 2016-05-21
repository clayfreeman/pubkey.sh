server {
  listen       ${HTTP_PORT} default_server;
  listen  [::]:${HTTP_PORT} default_server;
  server_name .${SERVER_NAME};

  include security.conf;

  # Drop the connection if a plaintext non-root URI is requested
  if ($request_uri != '/') {
    return 444;
  }

  return 301 https://$host:${HTTPS_PORT}$request_uri;
}

server {
  listen       ${HTTPS_PORT} default_server ssl;
  listen  [::]:${HTTPS_PORT} default_server ssl;
  server_name .${SERVER_NAME};

  index index.php;
  root /app/public;

  include security.conf;
  # TODO: Will change in the future depending upon SSL generation method
  ssl_certificate     /data/server.pem;
  ssl_certificate_key /data/server.key;

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
