# 🚀 FutbolShop — Guía de instalación en Linux

## Requisitos

Necesitas tener instalado:
- **PHP 8.0+** con extensiones `pdo`, `pdo_mysql`, `mbstring`
- **MySQL** o **MariaDB**
- Un servidor web: **Apache** o el servidor integrado de PHP

---

## Opción A — Servidor integrado de PHP (más fácil, sin Apache)

Ideal para desarrollo local. No necesitas configurar nada extra.

### 1. Instalar PHP y MySQL

```bash
sudo apt update
sudo apt install php php-mysql php-mbstring mysql-server -y
```

### 2. Iniciar MySQL y crear la base de datos

```bash
# Iniciar el servicio de MySQL
sudo systemctl start mysql

# Entrar como root (en Ubuntu/Debian no pide contraseña por defecto)
sudo mysql

# Dentro de MySQL, ejecutar el script:
source /ruta/a/futbolshop/database.sql;
exit;
```

O directamente desde la terminal:
```bash
sudo mysql < /ruta/a/futbolshop/database.sql
```

### 3. Verificar credenciales en config.php

Abre `config.php` y revisa estas líneas:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'futbolshop');
define('DB_USER', 'root');   // tu usuario de MySQL
define('DB_PASS', '');       // tu contraseña (vacía si no pusiste)
```

### 4. Lanzar el servidor PHP

```bash
# Ubícate en la carpeta del proyecto
cd /ruta/a/futbolshop

# Iniciar servidor en el puerto 8000
php -S localhost:8000
```

### 5. Abrir en el navegador

```
http://localhost:8000
```

---

## Opción B — Apache (producción o más realista)

### 1. Instalar todo

```bash
sudo apt update
sudo apt install apache2 php php-mysql php-mbstring mysql-server libapache2-mod-php -y
```

### 2. Copiar el proyecto a Apache

```bash
sudo cp -r futbolshop /var/www/html/futbolshop
sudo chown -R www-data:www-data /var/www/html/futbolshop
```

### 3. Crear la base de datos

```bash
sudo systemctl start mysql
sudo mysql < /var/www/html/futbolshop/database.sql
```

### 4. Iniciar Apache

```bash
sudo systemctl start apache2
sudo systemctl enable apache2
```

### 5. Abrir en el navegador

```
http://localhost/futbolshop
```

---

## ⚠️ Solución de problemas comunes

### "No se puede conectar a la base de datos"
- Verifica que MySQL esté corriendo: `sudo systemctl status mysql`
- Confirma usuario y contraseña en `config.php`
- En Ubuntu, el usuario root de MySQL puede requerir `sudo`:
  ```bash
  sudo mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY ''; FLUSH PRIVILEGES;"
  ```

### "Las imágenes no cargan"
- Verifica que las rutas sean en minúsculas (Linux distingue mayúsculas)
- Revisa que la carpeta `assets/img/productos/` tenga los archivos

### "Error 500 / página en blanco"
- Activa los errores de PHP temporalmente en `index.php`:
  ```php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  ```

---

## Usuarios de prueba

| Rol   | Email                       | Contraseña  |
|-------|-----------------------------|-------------|
| Admin | admin@futbolshop.com        | Admin123    |
| User  | usuario@futbolshop.com      | Usuario123  |

> Las contraseñas están guardadas hasheadas con `password_hash()` en la base de datos.

---

## Estructura del proyecto

```
futbolshop/
├── index.php              ← Página de inicio
├── config.php             ← Conexión DB + funciones globales
├── database.sql           ← Script para crear la BD ← EJECUTAR PRIMERO
├── INSTRUCCIONES.md       ← Este archivo
│
├── pages/                 ← Controladores (solo lógica PHP)
│   ├── productos.php
│   ├── contacto.php
│   ├── login.php
│   ├── register.php
│   ├── carrito.php
│   └── logout.php
│
├── views/                 ← Vistas .phtml (solo HTML)
│   ├── home.phtml
│   ├── productos.phtml
│   ├── contacto.phtml
│   ├── login.phtml
│   └── carrito.phtml
│
├── includes/              ← Componentes reutilizables
│   ├── header.php
│   └── footer.php
│
└── assets/                ← Recursos estáticos
    ├── css/style.css
    ├── js/app.js
    └── img/productos/     ← Imágenes de productos
```
