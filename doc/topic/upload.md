LNMP 文件上传限制
# 文件大小限制
## Nginx
  vim nginx.conf
  client_max_body_size 100M;
## PHP
  vim php.ini
  upload_max_filesize 100M;

# 访问超时时间
## Nginx
  vim nginx.conf
  keepalive_timeout=1800;

  vim DOMAIN.conf
  keepalive_timeout=1800;
## PHP
  vim *.php
  ini_set('memory_limit', '100M');
  ini_set("max_execution_time", '1800');
