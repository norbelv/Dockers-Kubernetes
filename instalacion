# Guía Detallada de Instalación y Verificación de Docker Desktop (Windows y Linux)

Esta guía te guiará paso a paso en la instalación de **Docker Desktop** tanto en **Windows** como en **Linux**, especificando los requisitos previos, el proceso de instalación y los comandos para comprobar que la instalación se ha realizado con éxito.

---

## 📋 Tabla de Contenidos
1. [Instalación en Windows](#1-instalación-en-windows)
   - [Requisitos previos](#requisitos-previos-windows)
   - [Paso a paso](#paso-a-paso-windows)
2. [Instalación en Linux (Ubuntu/Debian)](#2-instalación-en-linux-ubuntudebian)
   - [Requisitos previos](#requisitos-previos-linux)
   - [Paso a paso](#paso-a-paso-linux)
3. [Prueba de Instalación Correcta (Ambos Sistemas)](#3-prueba-de-instalación-correcta)
4. [Solución de Problemas Comunes](#4-solución-de-problemas-comunes)

---

## 1. Instalación en Windows

<a name="requisitos-previos-windows"></a>
### 🛠️ Requisitos Previos (Windows)
* **Sistema Operativo:** Windows 10 (64-bit: Home, Pro, Enterprise o Education) v2004 o superior, o Windows 11.
* **Habilitar WSL 2:** Se recomienda encarecidamente utilizar el motor WSL 2 (Windows Subsystem for Linux).
* **Virtualización:** La virtualización por hardware debe estar habilitada en la BIOS/UEFI.

#### Paso 0: Habilitar WSL 2 (Si no lo tienes activo)
Abre **PowerShell** o **Windows Terminal** como Administrador y ejecuta:

```powershell
wsl --install
```
*Reinicia tu PC si el sistema te lo solicita.*

---

<a name="paso-a-paso-windows"></a>
### 🚀 Paso a Paso (Windows)

1. **Descargar el Instalador:**
   - Ve al sitio oficial: [Docker Desktop para Windows](https://www.docker.com/products/docker-desktop/).
   - Haz clic en **"Download for Windows"** para obtener el archivo `Docker Desktop Installer.exe`.

2. **Ejecutar el Instalador:**
   - Haz doble clic en `Docker Desktop Installer.exe`.
   - Asegúrate de tener marcada la casilla **"Use WSL 2 instead of Hyper-V"** (recomendado).
   - Opcionalmente, selecciona si deseas agregar un acceso directo al escritorio.
   - Haz clic en **OK** y espera a que finalice el proceso de descompresión e instalación.

3. **Finalizar Instalación:**
   - Haz clic en **Close and restart** (Cerrar y reiniciar) para completar el proceso.

4. **Iniciar Docker Desktop:**
   - Abre **Docker Desktop** desde el menú Inicio.
   - Acepta los términos y condiciones (Docker Subscription Service Agreement).
   - Verás el icono de Docker (la ballena) en la bandeja del sistema (junto al reloj). Espera a que el icono cambie a estado estable (indica que el motor está corriendo).

---

## 2. Instalación en Linux (Ubuntu/Debian)

> **Nota:** Docker Desktop en Linux ejecuta una máquina virtual Linux ligera. Es ideal si buscas la misma experiencia de GUI que en Windows/macOS.

<a name="requisitos-previos-linux"></a>
### 🛠️ Requisitos Previos (Linux)
* Sistema operativo de 64 bits (Ubuntu 22.04 LTS o 24.04 LTS recomendados).
* Compatibilidad con virtualización KVM.
* Mínimo 4 GB de RAM.

#### Paso 0: Verificar soporte KVM y preparar permisos
Ejecuta en tu terminal:

```bash
# Verificar si el procesador soporta virtualización KVM
kvm-ok
```
*Si `kvm-ok` no está instalado, instálalo con `sudo apt install cpu-checker`.*

Para cargar el módulo KVM y dar permisos a tu usuario:
```bash
sudo modprobe kvm
sudo usermod -aG kvm $USER
```

---

<a name="paso-a-paso-linux"></a>
### 🚀 Paso a Paso (Linux - Ubuntu)

1. **Configurar el Repositorio de Docker:**

```bash
# Actualizar el índice de paquetes e instalar dependencias iniciales
sudo apt-get update
sudo apt-get install ca-certificates curl gnupg

# Agregar la clave GPG oficial de Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Configurar el repositorio de Docker
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
```

2. **Descargar el Paquete DEB de Docker Desktop:**
   - Ve a la página de descargas oficiales de Docker Desktop para Linux y descarga la versión `.deb` más reciente, o usa `curl`/`wget`.

3. **Instalar el Paquete DEB:**

```bash
sudo apt-get install ./docker-desktop-<VERSION>-amd64.deb
```
*(Reemplaza `<VERSION>` por la versión exacta del archivo descargado, por ejemplo: `docker-desktop-4.34.0-amd64.deb`).*

4. **Iniciar Docker Desktop:**
   - Busca **Docker Desktop** en el menú de aplicaciones de tu entorno de escritorio o ejecútalo desde la terminal:
```bash
systemctl --user start docker-desktop
```

---

## 3. Prueba de Instalación Correcta

Para confirmar que Docker está instalado y funcionando adecuadamente en tu sistema, abre una terminal (**PowerShell/CMD** en Windows o **Terminal** en Linux) y sigue estos pasos de verificación:

### Prueba 1: Verificar la Versión de Docker
Ejecuta el comando para verificar que Docker CLI responde:

```bash
docker --version
```
*Resultado esperado:* Debe mostrar una salida similar a `Docker version 27.x.x, build xxx...`.

Comprueba la versión de Docker Compose:
```bash
docker compose version
```

### Prueba 2: Verificar la Información del Sistema Docker
Verifica que el demonio/motor de Docker está corriendo activamente:

```bash
docker info
```
*Resultado esperado:* Una lista detallada con información del sistema, cantidad de contenedores, imágenes y el driver de almacenamiento. Si aparece un error indicando *"Cannot connect to the Docker daemon"*, asegúrate de que Docker Desktop esté abierto.

### Prueba 3: Ejecutar el Contenedor "Hello-World"
Esta es la prueba definitiva que descarga una imagen de prueba, ejecuta un contenedor, imprime un mensaje y finaliza:

```bash
docker run hello-world
```

#### Salida esperada en la terminal:

```text
Unable to find image 'hello-world:latest' locally
latest: Pulling from library/hello-world
c1ec31b23086: Pull complete 
Digest: sha256:4f53e7004105a32b...
Status: Downloaded newer image for hello-world:latest

Hello from Docker!
This message shows that your installation appears to be working correctly.

To generate this message, Docker took the following steps:
 1. The Docker client contacted the Docker daemon.
 2. The Docker daemon pulled the "hello-world" image from the Docker Hub.
 3. The Docker daemon created a new container from that image which runs the
    executable that produces the output you are currently reading.
 4. The Docker daemon streamed that output to the Docker client, which sent it
    to your terminal.
```

### Prueba 4: Probar un Servidor Web (Nginx)
Ejecuta un servidor web rápido para confirmar reenvío de puertos y conectividad de red:

```bash
docker run -d -p 8080:80 --name mi-test-web nginx
```

- Abre tu navegador web e ingresa a: `http://localhost:8080`
- Deberías ver la página de bienvenida: **"Welcome to nginx!"**.

**Limpieza post-prueba:**
```bash
docker stop mi-test-web
docker rm mi-test-web
```

---

## 4. Solución de Problemas Comunes

* **Windows - "WSL 2 kernel update is required":**
  - Descarga e instala el paquete de actualización del kernel de WSL 2 desde el sitio oficial de Microsoft ejecutando `wsl --update`.
* **Linux - Error de permisos / "Permission Denied":**
  - Asegúrate de agregar tu usuario al grupo `docker`:
    ```bash
    sudo usermod -aG docker $USER
    ```
    luego cierra e inicia sesión nuevamente.
* **Virtualización desactivada:**
  - Si recibes un error sobre virtualización, debes reiniciar tu equipo, acceder a la BIOS/UEFI y habilitar **Intel VT-x** o **AMD-V**.
