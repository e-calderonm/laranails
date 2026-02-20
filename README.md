# 💅 LaraNails - Sistema de Gestión de Belleza

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Mobile First](https://img.shields.io/badge/Mobile-First-blue?style=for-the-badge&logo=apple&logoColor=white)

> **Sistema inteligente para la gestión de citas, clientes y servicios en salones de belleza y spas.**

LaraNails es una aplicación web progresiva diseñada bajo la filosofía **Mobile First**, permitiendo a los administradores gestionar su negocio desde cualquier dispositivo (especialmente iPhone 16 Pro). El sistema automatiza el cálculo de tiempos, previene conflictos de agenda y gestiona un catálogo de servicios completo.

---

## 🚀 Características Principales

### 📅 Módulo de Agendamiento Inteligente (Core)
* **Validación de Conflictos:** Algoritmo que impide agendar citas si el horario se cruza con otra existente.
* **Cálculo Automático:** Suma la duración de múltiples servicios seleccionados (ej: Uñas + Cejas) para bloquear el tiempo exacto en la agenda.
* **Gestión de Estados:** Confirmación, Cancelación y Edición de citas.

### 👥 Gestión de Clientes (CRM)
* Registro completo de clientes con historial.
* Búsqueda rápida por nombre o cédula.
* Acceso directo a agendamiento desde el perfil del cliente.

### 💅 Catálogo de Servicios
* Gestión de precios y tiempos estimados.
* Categorización (Uñas, Depilación, Pestañas).
* Historial de precios: El sistema guarda el precio del servicio al momento de la reserva.

### 📱 Diseño & UX
* **Interfaz Mobile First:** Optimizada para pantallas táctiles y móviles.
* **Estética Pastel:** Diseño visual acorde al sector de belleza (Paleta Rose/Violet).
* **Feedback Inmediato:** Alertas visuales para conflictos de horario y confirmaciones.

---


## 🛠️ Tecnologías Utilizadas

* **Backend:** Laravel 10 / PHP 8.2+
* **Frontend:** Blade, Tailwind CSS, Alpine.js
* **Base de Datos:** MySQL (Hospedada en Clever Cloud)
* **Autenticación:** Laravel Breeze
* **Despliegue:** Render / Railway (Producción)

---

## ⚙️ Instalación Local

Si deseas correr este proyecto en tu entorno local, sigue estos pasos:

1.  **Clonar el repositorio**
    ```bash
    git clone [https://github.com/TU_USUARIO/gestion-belleza.git](https://github.com/TU_USUARIO/gestion-belleza.git)
    cd gestion-belleza
    ```

2.  **Instalar dependencias de PHP y Node**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar entorno**
    Copiar el archivo de ejemplo y generar la llave.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Base de Datos**
    Configura tus credenciales en el archivo `.env` y ejecuta las migraciones con datos de prueba (Seeders incluidos):
    ```bash
    php artisan migrate:fresh --seed
    ```
    *> Esto creará el Admin por defecto y cargará la lista de precios de uñas/cejas.*

5.  **Ejecutar**
    ```bash
    npm run build
    php artisan serve
    ```

---

## 🔐 Credenciales de Acceso (Demo)

El sistema cuenta con un usuario administrador pre-cargado para pruebas:

* **Usuario:** `admin@belleza.com`
* **Contraseña:** `password123`

---

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia [MIT](https://opensource.org/licenses/MIT).

---
Hecho con ❤️ y mucho café
