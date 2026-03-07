# Diagrama de Despliegue - SIGERD

A continuación se presenta el código fuente en formato **PlantUML** del diagrama de despliegue del sistema SIGERD. Este diagrama ilustra la arquitectura física e infraestructura de red donde se hospeda y ejecuta la aplicación, basándose estrictamente en los requerimientos técnicos del software (Laravel, MySQL, Nginx/Apache).

---

## Código PlantUML

```plantuml
@startuml SIGERD_DiagramaDespliegue
left to right direction
skinparam node {
    BackgroundColor White
    BorderColor #5B4EFF
}
skinparam component {
    BackgroundColor #F3F4F6
    BorderColor #4B5563
}
skinparam database {
    BackgroundColor White
    BorderColor #059669
}
skinparam linetype ortho

' Nodos Cliente
node "Dispositivo Cliente (Móvil / PC)" as ClientNode {
    component "Navegador Web\n(Chrome, Safari, Edge)" as Browser
    artifact "Frontend Renderizado\n(HTML, TailwindCSS, Alpine.js)" as Frontend
    
    Browser *-- Frontend
}

' Servidor de Aplicación Web
node "Servidor de Aplicaciones (Linux/Windows)" as AppServer {
    node "Servidor Web\n(Nginx / Apache)" as WebServer {
        component "Balanceador / Proxy Inverso" as Proxy
    }

    node "Motor PHP" as PHPEngine {
        component "PHP 8.2+ (PHP-FPM)" as PHPFPM
        artifact "Código Aplicación SIGERD\n(Laravel 12.x)" as LaravelApp
        
        PHPFPM *-- LaravelApp
    }
    
    node "Sistema de Archivos Local" as Storage {
        artifact "Evidencias e Imágenes\n(/storage/app/public)" as LocalFiles
    }
    
    WebServer ..> PHPEngine : Peticiones FastCGI
    LaravelApp ..> Storage : Lectura/Escritura
}

' Servidor de Base de Datos
node "Servidor de Base de Datos" as DBServer {
    database "MySQL 8.0 / MariaDB" as RDBMS {
        artifact "Esquema 'sigerd_db'\n(Users, Tasks, Incidents)" as DBSchema
    }
}

' Conexiones de Red (Despliegue)
ClientNode =right=> AppServer : "HTTP / HTTPS\n(Internet / Intranet)"
AppServer =down=> DBServer : "TCP/IP (Puerto 3306)\n(Conexión PDO)"

@enduml
```

### Descripción de la Arquitectura de Despliegue
1. **Capa Cliente:** Representa cualquier dispositivo (PC, Tablet o Celular) desde el cual los roles (Admin, Trabajador, Instructor) acceden a la plataforma mediante un navegador web moderno.
2. **Servidor de Aplicaciones:** El nodo central donde reside el código de Laravel. Un servidor Nginx o Apache recibe las peticiones HTTP y las pasa a PHP-FPM para procesar la lógica de negocio. Además, incluye el volumen de almacenamiento local físico donde se guardan las fotografías y evidencias técnicas (`storage/app/public`).
3. **Servidor de Base de Datos:** Nodo (que puede estar en el mismo servidor o en uno dedicado) que ejecuta MySQL o MariaDB y aloja el esquema relacional estructurado del sistema SIGERD.
