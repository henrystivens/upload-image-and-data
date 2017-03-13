Subir imagen y datos con KumbiaPHP
======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/henrystivens/upload-image-and-data/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/henrystivens/upload-image-and-data/?branch=master)

## Correr en Docker

Como prerequisito debe tener instalado Docker en el sistema operatvo: [Obtener Docker](https://www.docker.com/products/overview)

### 1. Correr mysql con datos externos y publicado

``
docker run --detach --name=mysql-dev --env="MYSQL_ROOT_PASSWORD=root" --volume /home/usuario/mysql/data:/var/lib/mysql --publish 6603:3306 mysql:5.7
``

Cambia el valor del parámetro --volume por el directorio que desees

### 2. Importar base de datos

Importar el archivo *default/app/config/sql/file_and_data_upload.sql*

### 3. Correr Apache + PHP 7

``
docker-compose up -d --build
``

o simplemente...

``
docker-compose up -d
``

Mirar la web en **http://localhost:8081**

La opción ``--build``, es sólo para la primera vez o cuando se cambian los ficheros del docker.

``docker-compose up`` (muestra el log en la terminal)

``docker-compose up -d `` (como demonio, sin datos en la terminal)
