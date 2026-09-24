# Motor Masters 

Sistema web para la gestión de un taller automotriz. Permite registrar clientes, administrar servicios, registrar vehículos y crear órdenes de servicio.(proyecto académico)

## Tecnologías

- PHP 8.2 o superior
- MySQL
- PDO
- HTML, CSS, JavaScript y Bootstrap 5
- Azure App Service para el alojamiento de la aplicación
- Amazon RDS para la base de datos en producción

## Estructura principal

```text
Controladores/   Controladores PHP y acciones de la aplicación
Documentos/      Scripts SQL de la base de datos
Modelos/         Conexión y acceso a datos
Vistas/          Páginas PHP, estilos, imágenes y JavaScript
index.php        Punto de entrada de la aplicación
```

## Requisitos

- PHP con las extensiones `pdo` y `pdo_mysql` habilitadas.
- MySQL o MariaDB local para desarrollo, o acceso a una instancia RDS.
- Servidor web Apache, XAMPP o Azure App Service configurado para ejecutar PHP.

## Instalación local con XAMPP

1. Clona el repositorio dentro de `htdocs`:

   ```bash
   git clone https://github.com/SelvinKoraddo/TallerMecanicoWeb.git TallerMecanico
   ```

2. Inicia Apache y MySQL desde XAMPP.

3. Crea la base de datos ejecutando:

   ```text
   Documentos/BD_version_simple.sql
   ```

4. Configura las credenciales de la base de datos. La aplicación busca estas variables de entorno:

   | Variable | Descripción |
   |---|---|
   | `DB_HOST` | Host de MySQL o RDS |
   | `DB_USER` | Usuario de la base de datos |
   | `DB_PASS` | Contraseña de la base de datos |
   | `DB_NAME` | Nombre de la base de datos, `L2_TallerCM23042` |

   En desarrollo local, si no se definen, el código utiliza valores predeterminados. Se recomienda definir siempre las variables y no guardar contraseñas en el repositorio.

5. Abre la aplicación en:

   ```text
   http://localhost/TallerMecanico/
   ```

## Configuración en Azure App Service

En **Configuration > Application settings**, agrega las variables:

```text
DB_HOST=endpoint-de-rds
DB_USER=usuario-de-rds
DB_PASS=contraseña-de-rds
DB_NAME=L2_TallerCM23042
```

Después de guardar los cambios, reinicia el App Service y despliega todo el contenido del repositorio, incluyendo las carpetas `Controladores`, `Modelos`, `Vistas` y `Documentos`.

El grupo de seguridad de RDS debe permitir conexiones entrantes desde Azure App Service en el puerto de MySQL, normalmente `3306`. No abras el puerto a todo Internet si puedes restringir el origen.

## Base de datos en RDS

Para una base ya creada, confirma que la tabla de vehículos permita registrar un vehículo sin servicio asignado:

```sql
ALTER TABLE automovil
MODIFY id_servicio INT(11) NULL;
```

Verifica la estructura con:

```sql
SHOW CREATE TABLE automovil;
```

## Funcionalidades

- Registro e inicio de sesión de clientes.
- Contraseñas almacenadas mediante `password_hash`.
- Registro y gestión de vehículos.
- Administración de clientes y servicios.
- Registro y seguimiento de órdenes de servicio.
- Roles de cliente y administrador.


