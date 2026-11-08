# ☸️ Guía Práctica de Actividades y Ejercicios — Kubernetes con Docker Desktop y `kubectl`

Documentación detallada paso a paso para la realización de las actividades, manifiestos YAML, comandos de verificación, escalabilidad, auto-reparación y cuestionario del Laboratorio 09.

---

## 🚀 Actividad 1: Configuración del Entorno de Kubernetes

### Paso 1.1: Habilitar Kubernetes en Docker Desktop
1. Abrir la interfaz gráfica de **Docker Desktop**.
2. Dirigirse a la sección de **Settings** (ícono de engranaje en la parte superior derecha).
3. Seleccionar **Kubernetes** en el menú lateral izquierdo.
4. Marcar la casilla **Enable Kubernetes**.
5. Hacer clic en el botón **Apply & Restart**.
6. Confirmar la instalación y esperar a que el indicador en la esquina inferior izquierda pase a estado verde (`Kubernetes is running`).

---

### Paso 1.2: Verificación del Contexto y del Clúster

#### 1. Consultar y cambiar el contexto activo:
Abre tu terminal (PowerShell o CMD) y ejecuta:

```powershell
kubectl config get-contexts
```

Si el asterisco (`*`) no apunta a `docker-desktop`, cambia el contexto ejecutando:

```powershell
kubectl config use-context docker-desktop
```

#### 2. Verificar el estado del clúster y del nodo:
Ejecuta los comandos para comprobar la conexión con el Control Plane:

```powershell
kubectl cluster-info
kubectl get nodes
```

* **Resultado esperado**: 
  * `Kubernetes control plane is running at https://kubernetes.docker.internal:6443`
  * Un nodo llamado `docker-desktop` con estado `Ready` y rol `control-plane`.

---

## 📄 Actividad 2: Creación de Deployment y Service con YAML

### Paso 2.1: Despliegue de NGINX (`nginx-deployment.yaml`)

1. Crea la carpeta de trabajo `k8s-lab` y navega hacia ella:
   ```powershell
   mkdir k8s-lab
   cd k8s-lab
   ```

2. Crea el archivo `nginx-deployment.yaml`:

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: nginx-deployment
  labels:
    app: nginx
spec:
  replicas: 1
  selector:
    matchLabels:
      app: nginx
  template:
    metadata:
      labels:
        app: nginx
    spec:
      containers:
      - name: nginx
        image: nginx:latest
        ports:
        - containerPort: 80
```

3. Aplicar el manifiesto en el clúster:
   ```powershell
   kubectl apply -f nginx-deployment.yaml
   ```

4. Verificar el despliegue:
   ```powershell
   kubectl get deployments
   kubectl get pods
   kubectl describe deployment nginx-deployment
   ```

---

### Paso 2.2: Exposición del Servicio NGINX (`nginx-service.yaml`)

1. Crea el archivo `nginx-service.yaml` en la misma carpeta:

```yaml
apiVersion: v1
kind: Service
metadata:
  name: nginx-service
spec:
  type: NodePort
  selector:
    app: nginx
  ports:
    - protocol: TCP
      port: 80
      targetPort: 80
      nodePort: 30080
```

2. Aplicar el servicio:
   ```powershell
   kubectl apply -f nginx-service.yaml
   ```

3. Verificar el estado del servicio:
   ```powershell
   kubectl get services
   ```

4. **Prueba de acceso**: Abre un navegador web e ingresa a:
   `http://localhost:30080` (debe mostrar la pantalla de bienvenida de NGINX).

---

## 📈 Actividad 3: Escalabilidad y Auto-reparación

### Paso 3.1: Escalar el Deployment de NGINX
Incrementa las réplicas del deployment a 3 desde la terminal:

```powershell
kubectl scale deployment nginx-deployment --replicas=3
```

Verifica la creación de las 3 réplicas:

```powershell
kubectl get pods
```

---

### Paso 3.2: Demostrar Auto-reparación (*Self-Healing*)
1. Lista los Pods para copiar el nombre exacto de uno de ellos:
   ```powershell
   kubectl get pods
   ```
2. Elimina manualmente un Pod (por ejemplo `nginx-deployment-96b9d695-ljsvr`):
   ```powershell
   kubectl delete pod nginx-deployment-96b9d695-ljsvr
   ```
3. Ejecuta inmediatamente el comando de verificación:
   ```powershell
   kubectl get pods
   ```
* **Observación**: Notarás que el Pod eliminado ya no está, pero Kubernetes creó uno nuevo de forma automática en pocos segundos para mantener la regla declarada de 3 réplicas.

---

### Paso 3.3: Limpieza de Recursos
Elimina los manifiestos creados para liberar memoria y recursos del equipo:

```powershell
kubectl delete -f nginx-service.yaml
kubectl delete -f nginx-deployment.yaml
```

---

## 📝 Solución de Ejercicios del Laboratorio

### 📌 Ejercicio 1: Despliegue de un servidor web Apache con YAML
Crea el archivo `apache-deployment.yaml`:

```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: apache-deployment
  labels:
    app: apache
spec:
  replicas: 2
  selector:
    matchLabels:
      app: apache
  template:
    metadata:
      labels:
        app: apache
    spec:
      containers:
      - name: apache
        image: httpd:latest
        ports:
        - containerPort: 80
```

**Comandos de ejecución e inspección**:
```powershell
kubectl apply -f apache-deployment.yaml
kubectl get deployments
kubectl get pods
```

---

### 📌 Ejercicio 2: Exposición del servicio Apache con NodePort
Crea el archivo `apache-service.yaml`:

```yaml
apiVersion: v1
kind: Service
metadata:
  name: apache-service
spec:
  type: NodePort
  selector:
    app: apache
  ports:
    - protocol: TCP
      port: 80
      targetPort: 80
      nodePort: 30081
```

**Comandos de ejecución y prueba**:
```powershell
kubectl apply -f apache-service.yaml
kubectl get services
```
* **Acceso desde el navegador**: Entrar a `http://localhost:30081` (debe mostrar *"It works!"*).

---

### 📌 Ejercicio 3: Escalabilidad y Auto-reparación en Apache

1. **Escalar a 4 réplicas**:
   ```powershell
   kubectl scale deployment apache-deployment --replicas=4
   kubectl get pods
   ```

2. **Eliminar un Pod y verificar la recuperación**:
   ```powershell
   # Selecciona cualquier Pod de la lista y elimínalo
   kubectl delete pod <nombre-del-pod-apache>

   # Verifica la rápida regeneración del recurso
   kubectl get pods
   ```

---

### 📌 Ejercicio 4: Despliegue de NGINX con Service ClusterIP y `port-forward`

1. Crea el archivo `nginx-clusterip-deployment.yaml`:
```yaml
apiVersion: apps/v1
kind: Deployment
metadata:
  name: nginx-clusterip-deployment
spec:
  replicas: 1
  selector:
    matchLabels:
      app: nginx-clusterip
  template:
    metadata:
      labels:
        app: nginx-clusterip
    spec:
      containers:
      - name: nginx
        image: nginx:latest
        ports:
        - containerPort: 80
```

2. Crea el archivo `nginx-clusterip-service.yaml`:
```yaml
apiVersion: v1
kind: Service
metadata:
  name: nginx-clusterip-service
spec:
  type: ClusterIP
  selector:
    app: nginx-clusterip
  ports:
    - protocol: TCP
      port: 80
      targetPort: 80
```

3. Aplicar ambos archivos y activar el reenvío de puertos:
```powershell
kubectl apply -f nginx-clusterip-deployment.yaml
kubectl apply -f nginx-clusterip-service.yaml

# Reenvío de puerto local 8080 hacia el servicio ClusterIP interno en el puerto 80
kubectl port-forward service/nginx-clusterip-service 8080:80
```
* **Acceso desde el navegador**: Entrar a `http://localhost:8080`.

---

### 📌 Ejercicio 5: Limpieza Completa del Entorno

```powershell
kubectl delete -f apache-service.yaml
kubectl delete -f apache-deployment.yaml
kubectl delete -f nginx-clusterip-service.yaml
kubectl delete -f nginx-clusterip-deployment.yaml

# Verificación de eliminación completa
kubectl get all
```

---

## ❓ Respuestas al Cuestionario

1. **Diferencia entre contenedor Docker y Pod de Kubernetes**:
   Un contenedor de Docker es una instancia aislada individual. Un Pod en Kubernetes es la unidad de despliegue mínima y puede contener uno o más contenedores que comparten la misma IP de red, espacio de nombres y volúmenes.

2. **Función de un Deployment**:
   Permite administrar aplicaciones declarativas y sin estado, asegurando que el número deseado de Pods se mantenga activo, permitiendo actualizaciones paulatinas (*rolling updates*) y autorecuperación en caso de fallos.

3. **Comando para ver el estado de todos los Pods**:
   `kubectl get pods` (o `kubectl get pods -A` para ver en todos los Namespaces).

4. **Propósito de un Service y 2 tipos**:
   Proporciona un punto de entrada de red estable (IP y DNS) para acceder a un grupo dinámico de Pods. Tipos: `ClusterIP` (uso interno), `NodePort` (exposición externa vía puerto de nodo).

5. **Comando para ver detalles y eventos de un Pod**:
   `kubectl describe pod <nombre-del-pod>`

6. **¿Qué sucede al eliminar manualmente un Pod de un Deployment?**:
   El controlador (`ReplicaSet`) detecta la falta de una réplica en comparación con el estado deseado y crea inmediatamente un nuevo Pod para sustituirlo.

7. **Función de `kubectl scale`**:
   Permite ajustar dinámicamente el número de réplicas de un Deployment hacia arriba o abajo según las necesidades de carga.

8. **Función de `kubectl apply -f`**:
   Aplica una configuración declarativa contenida en un archivo YAML o JSON para crear o actualizar recursos en el clúster.

9. **Información de `kubectl cluster-info`**:
   Muestra las direcciones del servidor API de Kubernetes (Control Plane) y los servicios centrales integrados (como CoreDNS).

10. **Flujo de trabajo básico con YAML en Kubernetes**:
    1. Definir el estado deseado en un archivo `.yaml`.
    2. Ejecutar `kubectl apply -f <archivo>.yaml`.
    3. El API Server procesa y guarda el manifiesto.
    4. Los controladores coordinan y crean los objetos (Pods, Services, etc.).
    5. Validar con `kubectl get` o `kubectl describe`.
