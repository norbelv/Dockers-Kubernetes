1. **Levantando una pagina Web en el Servidor Web con Nginx :**

## 🚀 Comando `docker build`

El comando `docker build` sirve para procesar las instrucciones de un archivo `Dockerfile` y construir una **imagen personalizada de Docker**.
**Ojo** tiene que estar todo en una misma carpeta

## Ejemplo de uso - Construir la nueva imagen:
```bash
docker build -t mi-web-cip .
```

### Desglose de parámetros:

* **`docker build`**: Inicia el proceso de construcción de la imagen.
* **`-t mi-web-cip` *(Tag / Etiqueta)***: Asigna un nombre personalizado (y opcionalmente una versión) a la imagen generada.
* **`.` *(Contexto de construcción)***: Representa el directorio actual. Le indica a Docker que busque el `Dockerfile` y sus archivos adjuntos (`index.html`, `styles.css`, etc.) en esa carpeta.

Una vez creada la imagen ahora creamos en contenedor con la imagen construida personalizada.

## Ejemplo de uso - Crear el Contenedor con la imagen personalizada:
```bash
docker run -d -p 9876:80 --name contenedor-cip mi-web-cip
```


## 📊 Diferencia clave entre `docker build` y `docker run`

| Comando | Acción | Salida / Resultado |
| :--- | :--- | :--- |
| **`docker build`** | Lee el `Dockerfile` y empaqueta el entorno y los archivos. | Genera una **Imagen** (el molde/plantilla). |
| **`docker run`** | Toma una Imagen e inicia un proceso de ejecución. | Genera un **Contenedor** (la instancia viva). 
