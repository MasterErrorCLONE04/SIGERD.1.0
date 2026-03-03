# Requisitos de Ejecución - SIGERD

A continuación se detallan las especificaciones técnicas necesarias para garantizar el correcto despliegue, ejecución y mantenimiento del sistema SIGERD.

---

## 1. Requisitos de Hardware

- **Procesador (CPU):** Mínimo 2 vCPUs (o núcleos físicos) a 2.0 GHz o superior.
- **Memoria RAM:** Mínimo 4 GB (Recomendado 8 GB para mejor rendimiento de la base de datos y PHP).
- **Almacenamiento:** Mínimo 20 GB de espacio libre en disco (preferiblemente SSD) para el sistema, base de datos y almacenamiento de archivos/imágenes de evidencia.

---

## 2. Requisitos de Software

- **Lenguaje (PHP):** Versión 8.2 o superior.
- **Extensiones requeridas:** BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML.
- **Servidor Web:** Nginx (recomendado) o Apache.
- **Gestor de Dependencias:** Composer (para instalar las librerías de Laravel).
- **Node.js & NPM:** Necesarios solo durante el entorno de desarrollo y despliegue para compilar los estilos CSS (TailwindCSS) y scripts (Vite).

---

## 3. Sistema Operativo

El software puede ejecutarse en servidores Linux o Windows, aunque Linux es el estándar recomendado para producción.
- **Recomendado:** Linux (Ubuntu 22.04 LTS, Debian 11+, CentOS Stream 9) o Windows Server.
- **Entorno de Desarrollo:** Windows (usando Laragon, XAMPP, o WSL2), macOS, o Linux.

---

## 4. Servidor de Base de Datos

- **Motor:** MySQL 8.0+ o MariaDB 10.6+.
- **Codificación:** Compatible con `utf8mb4` para soporte completo de caracteres y emojis rudimentarios.

---

## 5. Navegadores Compatibles

El sistema utiliza tecnologías modernas (Vite + TailwindCSS), por lo que requiere navegadores actualizados que soporten características CSS/JS recientes:
- **Google Chrome** (Versiones recientes)
- **Mozilla Firefox** (Versiones recientes)
- **Microsoft Edge** (Versiones recientes)
- **Safari** (Versiones recientes)

---

## 6. Plataformas Tecnológicas Utilizadas

- **Lenguaje de programación**
  - **PHP 8.x** (orientado a objetos, soporte para tipado estricto y atributos modernos).
- **Framework backend**
  - **Laravel 12.x** (estructura MVC, ruteo avanzado, Eloquent ORM, migraciones de base de datos).
- **Motor de base de datos**
  - **MySQL / MariaDB**, gestionada de manera integral a través de las migraciones de Laravel.
- **Servidor web**
  - **Apache o Nginx** (cualquier servidor compatible con PHP FPM).
- **Frontend**
  - **Blade** como motor nativo de plantillas de vistas.
  - **TailwindCSS** para un diseño responsivo, utilitario y moderno.
  - **Alpine.js** para añadir interactividad ligera en el navegador sin recargar páginas.
- **Generación de documentos**
  - **barryvdh/laravel-dompdf** para la exportación y generación de reportes en formato PDF.

---

## 7. Frameworks y Estructura

- **Laravel**
  - Gestión centralizada de rutas web, controladores y middlewares.
  - **Eloquent ORM** para el mapeo objeto-relacional de las entidades de la plataforma (`User`, `Task`, `Incident`, `Notification`).
  - Sistema de migraciones para el control de versiones seguro del esquema de la base de datos.
- **TailwindCSS**
  - Framework CSS basado en utilidades, responsable de construir toda la interfaz estandarizada de los paneles (Administrador, Trabajador, Instructor).
- **Alpine.js**
  - Framework JavaScript ligero para inyectar comportamientos dinámicos directamente en las vistas Blade (menús desplegables, pestañas activas, validaciones en vivo, etc.).

---

## 8. Librerías Externas Clave

- **DomPDF (`barryvdh/laravel-dompdf`)**
  - Librería backend utilizada exclusivamente para la generación y renderizado de reportes estadísticos exportables en formato PDF de las tareas finalizadas.
- **Google Fonts & Material Symbols**
  - Integración de fuentes modernas (Inter) e iconos estilizados de Google (`Material Symbols Outlined`) para la iconografía de toda la plataforma.

---

## 9. Patrones de Diseño Aplicados

- **MVC (Modelo–Vista–Controlador)**
  - Modelos Eloquent que representan inequívocamente las entidades del dominio en base de datos.
  - Controladores organizados estrictamente por rol (`Admin`, `Worker`, `Instructor`) que encapsulan de forma aislada la lógica de negocio y orquestan los flujos permitidos.
  - Vistas Blade que definen únicamente la capa de presentación al cliente final.
- **Active Record (Eloquent ORM)**
  - Cada modelo de Laravel en el sistema encapsula su persistencia y centraliza la lógica de sus relaciones e interacciones hacia las tablas.
- **REST-like Controllers**
  - Controladores que exponen sus métodos atómicos de acceso a datos utilizando una estructura estándar (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) para facilitar operaciones CRUD.
- **Separación de Responsabilidades Lógicas**
  - El uso de Espacios de Nombres (`App\Http\Controllers\Admin`, `App\Http\Controllers\Worker`) separa estructuralmente la seguridad, permisos y responsabilidades visuales, manteniendo el código escalable y libre de colisiones.

---

## 10. Protocolos de Seguridad Implementados

- **Autenticación y Autorización**
  - Autenticación criptográfica basada en sesiones modernas de Laravel.
  - Validación jerárquica de **Roles de usuario** (`administrador`, `trabajador`, `instructor`) para proteger la navegación y restringir categóricamente accesos a módulos lógicos en el enrutamiento.
- **Protección CSRF**
  - Uso perimetral obligatorio del token `@csrf` en todos los formularios para evitar falsificación de peticiones en sitios cruzados con verificación automática a nivel global.
- **Protección y Cifrado de Datos**
  - Contraseñas fuertemente almacenadas con hashing seguro e irreversible (`bcrypt` o `argon2` provistos de forma algorítmica por Laravel Hash).
- **Validación Backend de Datos**
  - Validación minuciosa y exhaustiva en el ecosistema de Controladores (`Request Validator`) antes de la creación o actualización de registros en Base de Datos; previniendo inyecciones de datos masivos no deseados o estructuras inválidas (ej. limitar peso y extensión de imágenes maliciosas).
- **Comunicación en Tránsito Externa**
  - Se requiere enfáticamente desplegar en producción detrás de un certificado de seguridad (HTTPS/SSL), resguardando así la integridad, confidencialidad e intercepción segura de las credenciales de los usuarios finales.
