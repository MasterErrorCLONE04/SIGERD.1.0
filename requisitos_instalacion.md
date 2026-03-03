# Manual de Instalación y Despliegue - SIGERD

A continuación se detallan los pasos exactos y los requisitos de configuración técnica para instalar, configurar y levantar el entorno de **SIGERD 1.0** desde cero.

---

## Prerrequisitos del Sistema

Antes de iniciar la instalación, asegúrese de que el entorno de servidor cuente con:
- Servidor web con soporte probado para **PHP 8.2+** (Apache o Nginx + PHP FPM).
- **PHP 8.2+** con las siguientes extensiones habilitadas: `mbstring`, `openssl`, `pdo_mysql`, `json`, `tokenizer`, `xml`, `gd` (necesaria para el manejo de imágenes recortadas y para la generación de PDFs con DomPDF).
- Servidor de base de datos relacional **MySQL 8.0+** o **MariaDB 10.6+**.
- **Composer** instalado globalmente para gestionar las dependencias y paquetes de Laravel.
- **Node.js + NPM** instalados (requeridos para compilar localmente los assets del frontend, TailwindCSS y Alpine.js).

---

## Base de Datos (Estructura)

- El esquema relacional completo de la base de datos se gestiona automáticamente mediante el sistema de migraciones de Laravel incluidas en el directorio `database/migrations`.
- **Para preparar la base de datos:**
  1. Inicie sesión en su gestor de MySQL (ej. phpMyAdmin o consola).
  2. Cree una base de datos totalmente vacía (se sugiere nombrarla `sigerd` o `sigerd_db`).
  3. Configure estas credenciales en el archivo `.env` del proyecto (detallado más abajo).
  4. Ejecute el comando de migración para poblar las tablas.

---

## Pasos de Instalación Paso a Paso

### 1. Clonar el repositorio fuente
Abra su terminal en la carpeta pública de su servidor web (ej. `htdocs` o `www`) y ejecute:
```bash
git clone https://github.com/MasterErrorCLONE04/SIGERD.1.0.git
cd SIGERD.1.0
```

### 2. Instalar dependencias backend (PHP)
Descargue y construya la carpeta `vendor` ejecutando:
```bash
composer install
```

### 3. Configurar las Variables de Entorno (.env)
Copie el archivo de ejemplo para crear la configuración vital de su entorno local:
```bash
cp .env.example .env
```

Abra el archivo `.env` recién creado en su editor de código y configure estrictamente los siguientes bloques:

**Configuración General de la Aplicación:**
```ini
APP_NAME=SIGERD
APP_URL=http://127.0.0.1:8000 # O la URL de su host virtual (ej. http://sigerd.test)
```

**Configuración Estricta de la Base de Datos MySQL:**
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigerd     # Reemplace por el nombre real de su DB creada
DB_USERNAME=root       # Usuario administrador de MySQL
DB_PASSWORD=           # Contraseña de MySQL (vacía en entornos locales por defecto)
```

**Configuración de Correo Electrónico (Notificaciones):**
*(Opcional en desarrollo local, pero vital para probar el envío de emails estadísticos)*
```ini
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=su_correo@gmail.com
MAIL_PASSWORD=su_contraseña_de_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=su_correo@gmail.com
MAIL_FROM_NAME="Notificaciones SIGERD"
```

### 4. Generar la Clave de Encriptación
Garantice la seguridad de las sesiones y contraseñas cifradas generando la llave única (esto rellenará la variable `APP_KEY` en su `.env`):
```bash
php artisan key:generate
```

### 5. Ejecutar Migraciones y Poblado de Datos (Seeders)
Construya las tablas (Users, Tasks, Incidents) y cree los perfiles de usuario iniciales (Administrador de sistema, roles base) en un solo comando:
```bash
php artisan migrate --seed
```
*(Nota: El seeder creará los usuarios por defecto para que pueda iniciar sesión inmediatamente).*

### 6. Enlazar el Almacenamiento Local Físico (Storage Link)
SIGERD almacena fotografías y evidencias técnicas en la carpeta persistente `storage/app/public`. Para que estas imágenes sean visibles en los navegadores (en perfiles y reportes), es **obligatorio** crear el atajo simbólico público:
```bash
php artisan storage:link
```

### 7. Compilar Módulos Frontend (Vite / Tailwind)
Instale las dependencias de Javascript y compile la hoja de estilos maestra:
```bash
npm install
npm run build
```
*(Durante el desarrollo, puede usar `npm run dev` para observar cambios en vivo).*

### 8. Puesta en Marcha (Desarrollo)
Si no está usando un entorno como Laragon o XAMPP que asigne dominios automáticamente, lance el servidor de desarrollo nativo de Laravel:
```bash
php artisan serve
```
Y acceda vía navegador a la URL indicada (usualmente `http://127.0.0.1:8000`).

---

## Repositorio Oficial
* GitHub: `https://github.com/MasterErrorCLONE04/SIGERD.1.0.git`

---

## Arquitectura de Roles y Permisos Iniciales

El sistema SIGERD distribuye su autorización mediante el campo lógico `role` centralizado en la entidad `users`. Se compone de:

- **1. Administrador (`administrador`)**
  - Acceso total e irrestricto a la configuración del ecosistema.
  - Creación y gestión absoluta del catálogo de Instructores y Trabajadores.
  - Creación, edición, evaluación (voto de aprobación/rechazo) y delegación de Tareas técnicas.
  - Revisión del inventario de Incidentes reportados y facultad para convertirlos en tareas reparativas.
  - Recepción de métricas de Dashboard y generación de Reportes en PDF consolidado.

- **2. Instructor (`instructor`)**
  - Facultad exclusiva de reportar fallas de infraestructura, equipos o software mediante el gestor de Incidentes.
  - Capacidad de incluir evidencias fotográficas (hasta 2MB por imagen) y ubicaciones descriptivas del suceso.
  - Seguimiento del ciclo de vida de los reportes creados y recepción de notificaciones interactivas de atención.

- **3. Trabajador (`trabajador`)**
  - Consulta interactiva de misiones de trabajo delegadas explícitamente a su perfil.
  - Acceso al controlador operacional que le permite marcar el inicio ("En Progreso") y conclusión inmediata ("Realizada") de las labores.
  - Obligatoriedad técnica de inyectar fotografías reales in situ como evidencia de culminación para someter al veredicto administrativo.

---

## Errores Comunes de Instalación

**Error 1: La aplicación arroja un error 500 o "No connection could be made" a la base de datos**
- **Posibles causas:**
  - Credenciales incorrectas en el archivo `.env`.
  - Base de datos no creada o el servicio MySQL/MariaDB está detenido.
- **Soluciones:**
  - Verificar minuciosamente que `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` y `DB_HOST` sean correctos.
  - Confirmar desde su gestor local que el servicio MySQL está en ejecución y que el usuario especificado tiene permisos.

**Error 2: Las migraciones fallan al intentar ejecutar `php artisan migrate`**
- **Posibles causas:**
  - Versiones incompatibles u obsoletas de MySQL.
  - Migraciones aplicadas parcialmente en un intento o ejecución anterior.
- **Soluciones:**
  - Revisar el mensaje exacto de error en la consola; asegúrese de correr MySQL 8.0+ para soportar correctamente las columnas `json` de las evidencias de SIGERD.
  - Si está en en un entorno de pruebas, limpie y reconstruya la base de datos desde cero ejecutando `php artisan migrate:fresh --seed`.

**Error 3: Los archivos PDF de reportes no se generan correctamente o se ven desconfigurados**
- **Posibles causas:**
  - La extensión `gd` de PHP no está instalada o habilitada en el servidor.
  - Permisos insuficientes en el sistema de archivos temporal.
- **Soluciones:**
  - Habilitar la extensión `gd` agregando o descomentando `extension=gd` dentro de su archivo `php.ini`.
  - Verificar que existan permisos de lectura/escritura (chmod 775) en las carpetas `storage` y `bootstrap/cache` de Laravel.

**Error 4: Las imágenes o fotografías de evidencia no se muestran en pantalla o marcan error 404**
- **Posibles causas:**
  - Olvido al momento de crear el enlace simbólico del disco público de Laravel.
  - Permisos restrictivos sobre la carpeta `storage/app/public`.
- **Soluciones:**
  - Ejecutar el comando crucial `php artisan storage:link` en la terminal raíz del proyecto.
  - Si ya existe el enlace, compruebe que su servidor virtual Nginx/Apache tenga la ruta `DocumentRoot` apuntando adecuadamente a la carpeta integrada `public` y posea permisos de lectura del disco local.

**Error 5: Los usuarios ven ventanas continuas de “Acceso no autorizado”, "403 Forbidden" o no visualizan módulos**
- **Posibles causas:**
  - El perfil (`role`) del usuario está mal escrito o asignado erróneamente en la base de datos.
  - Se intenta acceder directamente a través de URL a una ruta protegida y segregada por middlewares de otro rol.
- **Soluciones:**
  - Revisar el campo `role` del usuario en la tabla `users` (los valores válidos explícitos de sistema son: `administrador`, `instructor`, `trabajador`).
  - Ajustar o actualizar manualmente ese rol desde la interfaz de "Gestión de Trabajadores/Instructores" si se cuenta con perfil Administrador, o forzar el string válido nativamente en la base de datos MySQL.
