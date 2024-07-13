# CodeIgniter
Docker - CodeIgniter 3.1.13 (PHP 7.1) - RabbitMQ

## Inicio
- En la ruta docker/php se encuentra el archivo init.sh donde se asigna permisos a la carpeta cache
- Se agrega archivo .htaccess donde se coloca regla para omitir el index.php de las url's
- Se agrega el archivo application/config/ci_rabbitmq.php donde se encuentran las credenciales para conectar a RabbitMQ
- Se modifica el archivo application/config/config.php para permitir tener una url base en ['base_url'], omitir el index.php en las url's en ['index_page'] y permitir cargar la carpeta vendor en ['composer_autoload']
- Se modifica el archivo application/config/autoload.php para agregar el helper url en ['helper']

## Docker
- Para la primera vez que se levanta el proyecto con docker o se cambie los archivos de docker ejecutar:
```bash
sudo docker-compose up --build -d
```
- En las siguientes oportunidades ejecutar:

Para levantar:
```bash
sudo docker-compose start
```
Para detener:
```bash
sudo docker-compose stop
```
- Para ingresar al contenedor ejecutar:
```bash
sudo docker-compose exec webserver bash
```

- Para instalar las dependencias con composer, dentro del contenedor con docker ejecutar:
```bash
composer install
```
- Para ver el proyecto desde un navegador:

Sin virtualhost:
```bash
http://localhost:9484
```
Con virtualhost:

Si se usa Linux, agregar en /etc/hosts de la pc host la siguiente linea:
```bash
9.21.21.19    local.domain.com
```
- Para ingresar al administrador de rabbitmq ingresar a la siguiente url, las credenciales se puede obtener del archivo application/config/ci_rabbitmq.php:
```bash
http://localhost:10672
```
- Para iniciar el receive de rabbitmq, ingresar al contenedor con php (webserver) y dentro ejecutar el siguiente comando:
```bash
php index.php cron/receive index
```
- Para enviar un mensaje al receive ingresar por un navegador la url del proyecto (http://localhost:9484) y escribir el mensaje en la caja de texto, al enviar, este mensaje se verá en la terminal donde se ejecutó e inicio el receive. 