# 🚀 Guía Completa: Aplicación Web Multi-contenedor con PHP, NGINX y MySQL en Docker Compose

En esta documentación se detalla el diseño, la configuración y el despliegue de una arquitectura de microservicios contenerizados utilizando **Docker**, **Docker Compose**, **PHP 8.2**, **NGINX** y **MySQL 8.0**.

---

## 🏛️ Arquitectura del Sistema

La solución consta de tres servicios desacoplados que se comunican dentro de una red privada administrada por Docker Compose:

```
[ Cliente / Navegador ] 
       │
       │ (Puerto 8080:80)
       ▼
 ┌───────────┐      FastCGI (Puerto 9000)      ┌───────────┐
 │   NGINX   │ ──────────────────────────────► │  PHP-FPM  │
 └───────────┘                                 └─────┬─────┘
  (Servidor)                                         │
                                                     │ SQL (Puerto 3306)
                                                     ▼
                                               ┌───────────┐
                                               │   MySQL   │
                                               └───────────┘
```

1. **Servidor Web (`web`)**: NGINX actúa como proxy de entrada en el puerto `8080`, atendiendo las peticiones HTTP y redirigiendo la ejecución del código PHP hacia el motor PHP-FPM.
2. **Procesador de Aplicación (`php`)**: Entorno PHP 8.2 optimizado que ejecuta los scripts `index.php` y `guardar.php`.
3. **Base de Datos (`db`)**: Instancia de MySQL 8.0 encargada del almacenamiento persistente mediante volúmenes de Docker.

---

## 📁 Estructura del Proyecto

```text
Ejemplo03-docker-compose/
├── docker-compose.yml    # Archivo de orquestación de servicios
├── Dockerfile            # Construcción de la imagen PHP personalizada
├── default.conf          # Configuración de NGINX y FastCGI
├── init.sql              # Script SQL de inicialización automática
└── html/
    ├── index.php         # Interfaz de usuario y lectura de registros
    └── guardar.php       # Controlador para la inserción de datos
```

---

## ⚙️ Explicación de los Archivos de Configuración

### 1. `docker-compose.yml`
Es el manifiesto que define y conecta los tres contenedores.

```yaml
services:
  web:
    image: nginx:alpine
    ports:
      - "8080:80"
    volumes:
      - ./html:/var/www/html
      - ./default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - php

  php:
    build: .
    volumes:
      - ./html:/var/www/html
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: mi_base_datos
      MYSQL_USER: usuario_app
      MYSQL_PASSWORD: password_app
    volumes:
      - db_data:/var/lib/mysql
      - ./init.sql:/docker-entrypoint-initdb.d/init.sql

volumes:
  db_data:
```

* **`depends_on`**: Garantiza el orden correcto de inicio (PHP depende de DB; NGINX depende de PHP).
* **`volumes` (`db_data`)**: Permite que los datos guardados en la tabla `usuarios` no se pierdan cuando los contenedores se detienen o se destruyen.
* **`docker-entrypoint-initdb.d/`**: Carpeta especial de la imagen de MySQL donde cualquier archivo `.sql` copiado se ejecuta automáticamente la primera vez que se inicia la base de datos.

---

### 2. `Dockerfile`
Define cómo se compila el entorno PHP.

```dockerfile
FROM php:8.2-fpm-alpine

# Instalar módulos de conexión a MySQL requeridos por PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar el código fuente dentro del contenedor
COPY ./html /var/www/html
```

---

### 3. `init.sql`
Define el esquema inicial de la base de datos.

```sql
CREATE DATABASE IF NOT EXISTS mi_base_datos;
USE mi_base_datos;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🛠️ Guía de Comandos para Administración

| Operación | Comando Docker | Descripción |
| :--- | :--- | :--- |
| **Construir e Iniciar** | `docker-compose up -d --build` | Compila las imágenes y levanta la infraestructura en segundo plano. |
| **Ver Estado** | `docker-compose ps` | Muestra el estado actual (`Up` / `Exited`) de todos los servicios. |
| **Ver Logs** | `docker-compose logs -f [servicio]` | Inspecciona la salida de la consola en tiempo real (ej. `db` o `php`). |
| **Detener Servicios** | `docker-compose stop` | Pausa los contenedores sin eliminar datos ni configuraciones. |
| **Limpieza Completa** | `docker-compose down -v` | Detiene, remueve contenedores y borra el volumen de datos para reiniciar desde cero. |

---

## 🧪 Prueba de Funcionamiento

1. Abre tu terminal en la carpeta del proyecto.
2. Levanta la aplicación completa con un solo comando

```bash
docker-compose up -d --build
```
   
3. Abrir un navegador de preferencia e ingresar a: `http://localhost:8080`.

```bash
http://localhost:8080
```

5. Completar el formulario con Nombre y Apellido.
6. Al hacer clic en **Guardar en MySQL**, el script `guardar.php` realiza un `INSERT` en la base de datos y redirige a `index.php`, mostrando la lista actualizada de registros consultados mediante la extensión `mysqli`.
