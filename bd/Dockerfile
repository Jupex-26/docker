# Imagen base oficial de MySQL
FROM mysql:8.0

# Establecer variables de entorno
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=votacion

# Definir el directorio de trabajo (opcional)
WORKDIR /var/lib/mysql

COPY init.sql /docker-entrypoint-initdb.d/



