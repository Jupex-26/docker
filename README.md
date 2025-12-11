# EJERCICIO DOCKER

Este es un ejercicio de docker mostrando su funcionamiento con proxy que redirige la petición al contenedor correspondiente. 
Un contenedor se trata de un servidor de chistes que muestra al usuario aleatoriamente uno de estos.
Tiene 3 contenedores donde un mismo servidor, que tratá de una votación, se replica 3 veces, además cuenta con un contenedor en específico que tiene más balance de carga que los otros dos.
Para el servidor de votación hay un contenedor de base de datos para persistir las votaciones de los usuarios.


---

## DESARROLLO

### Servidor de Chistes

Para este servidor usé un solo index.php donde inicializo un array con un total de 50 chistes.
Cuando un usuario hace una petición a este servidor se muestra aleatoriamente uno de estos chistes, este tiene en cuenta que puede empezar desde 0 hasta el número total del array -1 para así si se quiere introducir otro elemento(chiste) más no se tenga que cambiar también el randomizador.

`$chistes[random_int(0,count($chistes)-1)]`

---

### Servidor de Encuesta

Este trata sobre la siguiente encuesta: **¿Independizar Linares de Jaén?**

Para el desarrollo hice las siguientes clases:
* Conexión a la base de datos
* Métodos usando la base de datos 
* Vista encargada de mostrar lo que va a ver el cliente
* Clase encargada de usar los métodos de las siguientes clases y gestionar las peticiones GET y POST 

#### Funcionamiento

El cliente visita la página, este verá un menú donde puede navegar entre Formulario y Resultados.
Por defecto le mostrará el formulario al usuario donde le saldra la siguiente encuesta:
`¿Independizar Linares de la provincia de Jaén? Si  No  Enviar`

Una vez seleccione una opción y la envíe le mostrará un mensaje confirmando que se ha enviado el voto correctamente.
*Esta votación se envía a la base de datos, haciendo así la persistencia de los diferentes votos de clientes.*

Si decide meterse en la página de resultados podrá comprobar como va el recuento de votos con sus respectivos porcentajes entre la opción **Si** y **No**

---

### Proxy Inverso

Este proxy será el único entrypoint de los contenedores de chistes y el servidor de votación, exponiendo solamente el puerto 80.

Aquí especifiqué el balance de carga entre las distintas réplicas bajo la misma url para la votación, especificando que contenedor tiene más carga. 

Tanto para el servidor de chistes como para el de votación configure el proxy para que cuando le llegue una petición a una url específica redirija el contenedor adecuado


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



