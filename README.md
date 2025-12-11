# EJERCICIO DOCKER

Este es un ejercicio de docker mostrando su funcionamiento con proxy que redirige la petición al contenedor correspondiente. 
Un contenedor es un servidor de chistes que muestra al usuario aleatoriamente uno de estos.
Tiene 3 contenedores donde un mismo servidor, que trata de una votación, se replica 3 veces, además cuenta con un contenedor en específico que tiene más balance de carga que los otros dos.
Para el servidor de votación hay un contenedor de base de datos para persistir las votaciones de los usuarios.


---

## TECNOLOGÍAS USADAS

Para los servidores use la versión php:8.2 y para la persistencia en la base de datos: mysql:8.0

Las imagenes correspondientes de los contenedores son:
* Servidor: php:8.2-apache
* Base de Datos: mysql:8.0
* Proxy: nginx:alpine

---
## DESARROLLO

### Servidor de Chistes

Para este servidor usé un solo index.php donde inicializo un array con un total de 50 chistes.
Cuando un usuario hace una petición a este servidor se muestra aleatoriamente uno de estos chistes, este tiene en cuenta que puede empezar desde 0 hasta el número total del array menos uno para así si se quiere introducir otro elemento(chiste) más no se tenga que cambiar también el randomizador.

`$chistes[random_int(0,count($chistes)-1)]`

---

### Servidor de Encuesta

Este trata sobre la siguiente encuesta: **¿Independizar Linares de Jaén?**

Para el desarrollo hice las siguientes clases:
* Conexión a la base de datos.
* Métodos usando la base de datos. 
* Vista encargada de mostrar lo que va a ver el cliente.
* Clase encargada de usar los métodos de las demás clases y gestionar las peticiones GET y POST. 

#### Funcionamiento

El cliente visita la página, este verá un menú donde puede navegar entre Formulario y Resultados.
Por defecto le mostrará el formulario al usuario donde le saldrá la siguiente encuesta:
`¿Independizar Linares de la provincia de Jaén? Si  No  Enviar`

Una vez seleccione una opción y la envíe le mostrará un mensaje confirmando que se ha enviado el voto correctamente.
*Esta votación se envía a la base de datos, haciendo así la persistencia de los diferentes votos de clientes.*

Si decide meterse en la página de resultados podrá comprobar como va el recuento de votos con sus respectivos porcentajes entre la opción **"Si"** y **"No"**.

**Importante**

Para mostrar el correcto balance de carga incluí mostrar la IP del servidor.

---

### Proxy Inverso

Este proxy será el único entrypoint de los contenedores de chistes y el servidor de votación, exponiendo solamente el puerto 80.

Aquí especifiqué el balance de carga entre las distintas réplicas bajo la misma url para la votación, especificando que contenedor tiene más carga. 

Tanto para el servidor de chistes como para el de votación configuré el proxy para que cuando le llegue una petición a una url específica redirija el contenedor adecuado.


**Balance de Carga:**
```
    upstream encuestas-servers {
        server encuesta-loadbalance1 weight=3 max_fails=3  fail_timeout=30s;
        server encuesta-loadbalance2 weight=1 max_fails=3  fail_timeout=30s;
        server encuesta-loadbalance3 weight=1 max_fails=3  fail_timeout=30s;
    }
```


**Configuración redireccionamiento:**
```     
    server {
       listen 80;
       server_name www.freedomLinares.com;

       location / {
           proxy_pass http://encuestas-servers;
        }

    }

    server {
        listen 80;
        server_name www.chiquito.com;

        location / {
            proxy_pass http://chiste;
        }
    }
```




---

## CREACIÓN DE CONTENEDORES 

Tras haber desarrollado los servidores, base de datos y proxy solo faltan los contenedores y su red interna para poder conectarse entre ellos.

Hice un Dockerfile para cada uno de estos, con las imágenes especificadas en el primer apartado, con su configuración específica y los ficheros que contendrán cada contenedor.

---

## ORQUESTA DE CONTENEDORES

Tras hacer cada dockerfile hice un docker-compose.yml que se encargará de orquestar los contenedores donde especifico cada servicio con su carpeta específica, asignandole además el nombre de contenedor, la red en común que van a usar y las dependencias necesarias.

Importante:
* Dependencia: 
```
    depends_on: 
        - bd-votos
```

* Red: 
```
    networks: 
        red_proxy: 
            driver: bridge
```


---



# AUTOR

**Juan Pedro Expósito Pozuelo**