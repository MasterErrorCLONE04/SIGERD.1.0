<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# SIGERD - Sistema Integral de Gestión Estructural de Reportes y Daños

**SIGERD** (o Sistema de Gestión de Reporte de Daños Estructurales) es una aplicación web integral diseñada para gestionar, reportar y dar seguimiento a incidencias y mantenimientos estructurales. El sistema permite un flujo de trabajo eficiente desde la detección de una falla hasta su resolución, involucrando diferentes roles y niveles de autorización.

## 📋 Tabla de Contenidos

1. [Descripción General](#descripción-general)
2. [Roles de Usuario y Permisos](#roles-de-usuario-y-permisos)
3. [Funcionalidades Principales](#funcionalidades-principales)
4. [Flujo de Trabajo](#flujo-de-trabajo)
5. [Tecnologías Utilizadas](#tecnologías-utilizadas)
6. [Instalación y Configuración](#instalación-y-configuración)

---

## 📖 Descripción General

SIGERD centraliza la gestión de mantenimiento y reparaciones. Permite a los instructores o personal en sitio reportar incidentes con evidencia fotográfica. Los administradores gestionan estos incidentes, convirtiéndolos en tareas asignadas a trabajadores especializados. Todo el proceso es monitoreado en tiempo real, generando un historial detallado y reportes en PDF para auditoría y control.

---

## 👥 Roles de Usuario y Permisos

El sistema cuenta con tres roles principales, cada uno con un panel de control (Dashboard) y permisos específicos:

### 1. Administrador (`admin`)
El rol de mayor jerarquía. Tiene control total sobre el sistema.
- **Dashboard**: Vista general de incidentes y tareas.
- **Gestión de Usuarios**: Crear, editar y eliminar usuarios.
- **Gestión de Incidentes**: Ver reportes generados por instructores.
- **Gestión de Tareas**:
  - Convertir Incidentes en Tareas.
  - Asignar tareas a Trabajadores.
  - Definir prioridad (Baja, Media, Alta) y fechas límite.
  - Revisar tareas completadas (Aprobar, Rechazar o marcar con Retraso).
- **Reportes**: Exportar reportes de tareas en PDF filtrados por mes/año.

### 2. Instructor (`instructor`)
El rol encargado de la detección y reporte inicial.
- **Dashboard**: Estado de sus reportes.
- **Reportar Incidente**: Formulario para detallar fallas (Título, Descripción Detallada, Ubicación).
- **Evidencia**: Carga obligatoria de fotos (evidencia inicial) al crear un reporte.
- **Seguimiento**: Ver el estado de sus incidentes reportados (Pendiente, Resuelto, etc.).

### 3. Trabajador (`worker`)
El rol operativo encargado de ejecutar las reparaciones.
- **Dashboard**: Tareas pendientes asignadas.
- **Gestión de Tareas**:
  - Ver detalles de la tarea (instrucciones, ubicación, imágenes de referencia).
  - Actualizar estado de la tarea (En Progreso, Realizada).
  - Cargar **Evidencia Final**: Fotos del trabajo terminado.
  - Agregar descripción final de la resolución.

---

## 🚀 Funcionalidades Principales

### Gestión de Fallas e Incidentes
- Registro detallado con ubicación y fecha.
- Subida de múltiples imágenes como evidencia inicial.
- Notificaciones automáticas a administradores cuando se crea un reporte.

### Sistema de Tareas y Seguimiento
- **Conversión**: Transformación fluida de un reporte de incidente a una orden de trabajo (tarea).
- **Asignación Inteligente**: Selección de trabajadores disponibles.
- **Imágenes de Referencia**: Los administradores pueden adjuntar imágenes guía para el trabajador.
- **Estados de Tarea**: Flujo completo: `Asignado` -> `En Progreso` -> `Realizada` -> `Revisión` -> `Finalizada`.
- **Alertas de Vencimiento**: Marcado automático de tareas como "Incompleta" si pasa la fecha límite.

### Control de Calidad (Revisión)
- Los administradores deben revisar las tareas marcadas como "Realizada".
- **Aprobar**: Cierra la tarea y el incidente asociado.
- **Rechazar**: Devuelve la tarea al estado "En Progreso" para correcciones.
- **Retraso**: Justificación de demoras.

### Notificaciones y Comunicación
- Sistema de notificaciones internas (Nueva tarea asignada, Nuevo incidente reportado).
- Indicadores de mensajes no leídos.

### Reportes y Exportación
- Generación de PDFs con resumen mensual de tareas, estadísticas de cumplimiento y desglose por prioridad y trabajador.

---

## 🔄 Flujo de Trabajo Típico

1. **Reporte**: Un **Instructor** detecta una grieta en una pared. Entra al sistema, llena el formulario de incidente y sube fotos de la grieta.
2. **Triaje**: El **Administrador** recibe la notificación. Revisa el incidente y decide que requiere reparación.
3. **Asignación**: El Administrador convierte el incidente en una **Tarea**, asigna a un **Trabajador**, establece prioridad "Alta" y adjunta planos como referencia.
4. **Ejecución**: El **Trabajador** ve la tarea en su dashboard. Cambia el estado a "En Progreso". Al terminar, sube fotos de la pared reparada y marca la tarea como "Realizada".
5. **Cierre**: El **Administrador** revisa las fotos finales. Si está conforme, aprueba la tarea. El sistema marca automáticamente el incidente original como "Resuelto".

---

## 🛠 Tecnologías Utilizadas

El proyecto está construido sobre un stack robusto y moderno:

- **Backend Framework**: [Laravel 12](https://laravel.com)
  - **Laravel Breeze**: Sistema de autenticación seguro.
  - **Eloquent ORM**: Gestión de base de datos.
- **Base de Datos**: MySQL / MariaDB.
- **Frontend**: Blade Templates con Tailwind CSS (para un diseño responsivo y moderno).
- **Librerías Clave**:
  - `barryvdh/laravel-dompdf`: Generación de reportes PDF.
  - `spatie/laravel-medialibrary` (o gestión nativa personalizada): Manejo de evidencias y archivos.
  - `pusher/pusher-php-server`: Capacidades de tiempo real (notificaciones).
- **Entorno de Desarrollo**: Compatible con Laragon / Docker (Sail).

---

## ⚙️ Instalación y Configuración

Siga estos pasos para desplegar el proyecto en un entorno local:

1. **Clonar el repositorio**:
   ```bash
   git clone <URL_DEL_REPOSITORIO>
   cd SIGERD
   ```

2. **Instalar dependencias de PHP**:
   ```bash
   composer install
   ```

3. **Instalar dependencias de Frontend**:
   ```bash
   npm install
   ```

4. **Configurar entorno**:
   - Duplicar el archivo `.env.example` y renombrarlo a `.env`.
   - Configurar las credenciales de base de datos en `.env` (DB_DATABASE, DB_USERNAME, etc.).

5. **Generar clave de aplicación**:
   ```bash
   php artisan key:generate
   ```

6. **Migrar base de datos y crear enlace simbólico de almacenamiento**:
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

7. **Ejecutar el servidor**:
   En dos terminales separadas:
   ```bash
   php artisan serve
   ```
   ```bash
   npm run dev
   ```

¡Listo! El sistema estará accesible en `http://localhost:8000`.

---
*SIGERD - Proyecto Personal de Gestión Estructural.*
