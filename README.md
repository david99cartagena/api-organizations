# 📦 API REST Organizations - Laravel 10 & JWT

API REST robusta desarrollada con **Laravel 10** para la gestión de organizaciones. Incluye autenticación segura mediante **JWT**, soporte para **Docker** y documentación interactiva con **Swagger**.

## ⚙️ Stack Tecnológico

### Backend & Core

- **PHP:** 8.1+
- **Framework:** Laravel 10.50.2
- **Autenticación:** [JWT Auth](https://github.com/tymondesigns/jwt-auth) (`v2.3`)
- **Documentación:** [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger) (`v8.6`)

### Infraestructura & Base de Datos

- **Base de Datos:** MySQL 8.0
- **Servidor Web:** Apache / Laravel Artisan
- **Contenedores:** Docker & Docker Compose
- **Gestor de Dependencias:** Composer
- **Correo:** SMTP (Gmail compatible)

## 📄 Documentación de la API (Swagger)

Los endpoints están documentados automáticamente. Una vez que el servidor esté corriendo, puedes acceder a la interfaz interactiva aquí:

> 🔗 [http://127.0.0.1:8000/api/documentation/](http://127.0.0.1:8000/api/documentation/)

## 🖥️ Guía de Instalación en Windows (Local)

### ✅ Requisitos Previos

Asegúrate de tener instaladas las siguientes herramientas:

- [XAMPP](https://www.apachefriends.org/index.html) (Apache y MySQL).
- [Composer](https://getcomposer.org/).
- [Git](https://git-scm.com/).
- [Visual Studio Code](https://code.visualstudio.com/) (Recomendado).

### 🛠️ Pasos para configurar el proyecto

1.  **Clonar el repositorio:**

    ```bash
    git clone [https://github.com/david99cartagena/api-organizations.git](https://github.com/david99cartagena/api-organizations.git)
    cd api-organizations
    ```

2.  **Configurar el entorno:**
    Copia el archivo de ejemplo y edita tus credenciales de base de datos en el archivo `.env`.

    ```bash
    cp .env.example .env
    ```

3.  **Instalar dependencias de PHP:**

    ```bash
    composer install
    ```

4.  **Configuración de seguridad y base de datos:**
    Genera la clave de la aplicación, el secreto de JWT y ejecuta las migraciones.

    ```bash
    php artisan key:generate
    php artisan jwt:secret
    php artisan migrate
    ```

5.  **Iniciar el servidor:**
    ```bash
    php artisan serve
    ```
    La API estará disponible en: `http://localhost:8000`

> [!TIP]
> Si el puerto 8000 está ocupado, puedes usar: `php artisan serve --port=8080`

## 📷 Vista Previa de la Aplicación

| Documentación Swagger                                                                                                      | Listado de Endpoints                                                                                                       |
| -------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| ![Screenshot 1](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_1.png) | ![Screenshot 2](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_2.png) |

| Pruebas de Endpoints                                                                                                       | Respuestas JSON                                                                                                            |
| -------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| ![Screenshot 3](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_3.png) | ![Screenshot 4](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_4.png) |

| Gestión de Datos                                                                                                           | Estructura Final                                                                                                           |
| -------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| ![Screenshot 5](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_5.png) | ![Screenshot 6](https://raw.githubusercontent.com/david99cartagena/api-organizations/refs/heads/main/img/Screenshot_6.png) |

Desarrollado por [David Cartagena](https://github.com/david99cartagena)
