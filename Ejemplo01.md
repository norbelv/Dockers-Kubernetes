1. **Levantando un Servidor Web con Nginx :**

## 🚀 Comando `docker run`

El comando `docker run` es la instrucción principal de Docker para crear y lanzar contenedores. Combina automáticamente la descarga de la imagen (si no existe localmente) con la creación e inicio del contenedor.

### Ejemplo de uso:

```powershell
docker run -d -p 9876:80 nginx
```

### Desglose de parámetros:

* **`docker run`**: Le indica a Docker que cree e inicie un nuevo contenedor a partir de una imagen especificada.
* **`-d` *(Detached mode / Modo desatendido)***: Ejecuta el contenedor en segundo plano. Esto libera tu terminal inmediatamente para que puedas seguir ejecutando otros comandos.
* **`-p 9876:80` *(Publish / Mapeo de puertos)***: Conecta un puerto de tu máquina física (host) con un puerto del contenedor. Sigue la estructura `puerto_host:puerto_contenedor`:
  * **`9876`**: Puerto de tu computadora local (Windows/Linux/macOS).
  * **`80`**: Puerto interno dentro del contenedor donde escucha el servicio (en este caso, NGINX).
* **`nginx`**: Nombre de la imagen oficial de Docker Hub utilizada para levantar el servicio.

### Detenemos en contenedor

```powershell
docker stop ID
```
### Eliminamos el contenedor

```powershell
docker rm ID
```

