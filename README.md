# EDW - Sistema de Gestión de Pedidos

## Requisitos

- PHP 8.1 o superior
- Composer
- Node.js y npm
- SQLite

## Instalación

1. Clona el repositorio:
```bash
git clone <url-del-repositorio>
cd EDW
```

2. Instala las dependencias de PHP:
```bash
composer install
```

3. Instala las dependencias de Node.js:
```bash
npm install
```

4. Configura el entorno:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configura la base de datos:
- El proyecto está configurado para usar SQLite por defecto
- Crea el archivo de base de datos:
```bash
touch database/database.sqlite
```

6. Ejecuta las migraciones y los seeders:
```bash
php artisan migrate --seed
```

7. Compila los assets:
```bash
npm run build
```

8. Inicia el servidor:
```bash
php artisan serve
```

9. Visita http://localhost:8000 en tu navegador

## Características

- Gestión de pedidos
- Gestión de productos
- Gestión de usuarios
- Gestión de clientes
- Panel de administración
- Búsqueda de pedidos por número de cliente y factura

## Notas importantes

- La aplicación usa SQLite como base de datos por defecto para facilitar la instalación
- Asegúrate de tener los permisos correctos en las carpetas storage/ y bootstrap/cache/
- Para entornos de producción, configura las variables de entorno apropiadamente en el archivo .env
