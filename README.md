# EJERCICIO DOCKER

Este es un ejercicio de docker mostrando su funcionamiento con proxy que redirige la petición al contenedor correspondiente. Tiene un servidor que se replica 3 veces con un contenedor en específico que tiene más balance de carga que los otros dos.

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

