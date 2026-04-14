# EDW Halcón - Sistema de Gestión de Pedidos

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-42b883?style=for-the-badge&logo=vue.js&logoColor=white)

**Sistema web para la distribuidora de materiales de construcción Halcón.**  
Automatiza los procesos internos permitiendo el seguimiento de pedidos con evidencia fotográfica y control de acceso basado en roles.

## ✨ Características principales

- **Búsqueda pública de pedidos**: Busca por número de cliente y factura. Muestra estado, timestamp y fotos de evidencia.
- **Dashboard protegido** con sistema de roles y permisos.
- **CRUD completo** de usuarios, productos, clientes y pedidos.
- **Sistema inteligente de fotos**:
  - Hasta 2 fotos por pedido: `image_path` (proceso) y `photo_delivered` (entrega).
  - Foto de proceso solo para estados 'pending' o 'processing'.
  - Foto de entrega solo para estado 'completed'.
  - Validación dinámica y almacenamiento en carpeta `public`.
  - Indicadores visuales en la lista de pedidos.
- **Archivado lógico** de pedidos con vista separada y opción de restauración.
- **Filtros avanzados** y cálculo de totales en tiempo real.
- **Interfaz moderna**: Avatares con iniciales, códigos de color por rol y diseño responsive.

## Roles del sistema

| Rol         | Acceso principal                              | Funciones principales                     |
|-------------|-----------------------------------------------|-------------------------------------------|
| **Admin**   | Todo el sistema                               | Gestión completa (Usuarios, Productos, Clientes, Pedidos) |
| **Almacén** | Pedidos y Productos                           | Gestión de inventario                     |
| **Ventas**  | Pedidos y Clientes                            | Gestión de clientes y pedidos             |
| **Compras** | Pedidos y Productos                           | Gestión de abastecimiento                 |
| **Ruta**    | Pedidos                                       | Subida de evidencia fotográfica           |

## Tecnologías utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade + componentes Vue.js
- **Base de datos**: MySQL
- **Estilos**: Tailwind CSS
- **Autenticación**: Autenticación nativa de Laravel

## Instalación rápida

```bash
git clone https://github.com/WolfyIt/EDW.git
cd EDW

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
php artisan serve

```

## Credenciales de prueba

| Rol         | Email                                         | Contraseñas                               |
|-------------|-----------------------------------------------|-------------------------------------------|
| **Admin**   | admin@halcon.test                             | secret123                                 |
| **Almacén** | warehouse@halcon.test                         | password123                               |
| **Ventas**  | sales@halcon.test                             | password123                               |
| **Compras** | purchasing@halcon.test                        | password123                               |
| **Ruta**    | route@halcon.test                             | password123                               |

## Capturas de pantalla

## Licencia
Este proyecto está bajo la licencia MIT.


Última actualización: Abril 2026