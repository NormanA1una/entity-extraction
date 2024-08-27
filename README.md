# Extracción de Entidades Predominantes desde una URL

Este proyecto es una aplicación web desarrollada con Laravel, jQuery y Python que permite a los usuarios ingresar una URL y extraer las entidades predominantes utilizando la API de Google Cloud Natural Language.

![Video demostrativo](/public/media/pruebaIntro.gif)

---

## 📋 Requisitos Previos

-   **Laravel 8.x**
-   **Composer**
-   **Python 3.7+**
-   **Google Cloud SDK (CLI)**

---

## ⚙️ Instalación

Sigue estos pasos para instalar y configurar el proyecto en tu entorno local.

### Si no tienes intaladas las dependencias necesarias te dejo los links de instalación:

-   https://getcomposer.org/
-   https://laravel.com/docs/11.x
-   https://cloud.google.com/sdk/docs/install-sdk

### 1. Clonar el Repositorio

git clone https://github.com/tu_usuario/tu_proyecto.git

cd tu_proyecto

### 2. Installar dependencias de PHP

composer install

### 3. Installar dependencias de Node.js

npm install

### 4. configura tus variables de entorno

Copia las variables de entorno del archivo .env.example y editalo con tus configuraciones personalizadas

## Variables de entorno

Para que este proyecto funcione adecuadamente se necesitan estas 3 variables de entorno

`PYTHON_PATH`

**Descripción:**

PYTHON_PATH define la ruta completa al intérprete de Python que se utilizará para ejecutar los scripts de Python en tu aplicación.

`PYTHON_SCRIPT_PATH`

**Descripción:**

PYTHON_SCRIPT_PATH define la ruta completa al script de Python que realiza el análisis de entidades utilizando la API de Google Cloud Natural Language.

Normalmente esta variable no debería de cambiar a menos que decidad mover de lugar el script de Python.

`GOOGLE_APPLICATION_CREDENTIALS`

**Descripción:**

GOOGLE_APPLICATION_CREDENTIALS define la ruta al archivo JSON de credenciales que Google Cloud SDK utiliza para autenticar solicitudes a la API de Google Cloud Natural Language.

## Obtener las credenciales para la validación y uso del API de API de Google Cloud Natural Language.

**Creación de una cuenta de Google Cloud**

-   Es necesario una cuenta de Google Cloud para luego hacer el login y conseguir los credenciales, puedes crearla acá: https://cloud.google.com/

-   Teniendo acceso a su cuenta de Google Cloud e instalado la SDK de Google Cloud procederemos a generar un Application Default Credentials (ADC)

Ejecuta este comando en la terminal para generar la ADC

```bash
  gcloud auth application-default login
```

Esto te abrirá una pantalla donde deberas elegir la cuenta de google correspondiente con la que usas Google Cloud y luego en la terminal tendras el siguiente mensaje:

![App Screenshot](/public/media/gcloudPath.png)

Este comando te generará una ruta, la cual es la que debes poner en la variable de entorno GOOGLE_APPLICATION_CREDENTIALS

# 🚀 Uso

1. Una vez está configurado todo el entorno local inicia el servidor de Laravel:

```bash
  php artisan serve
```

2. Abre en el navegador el servidor y veras la pantalla con el input para el url

![App Screenshot](/public/media/inputUrl.png)

3. Pon el URL y listo! 😎

![App Screenshot](/public/media/entitiesExtraction.png)
