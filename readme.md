# 📰 Avalos News - Newsletter Automático

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?style=flat&logo=postgresql)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=flat&logo=docker)
![PHPMailer](https://img.shields.io/badge/PHPMailer-6.x-green?style=flat)

## 📋 Descripción del Proyecto

**Avalos News** es una plataforma automatizada de newsletter que agrega, procesa y distribuye contenido en un formato profesional. El sistema está diseñado para mantener a los usuarios informados sobre tecnología, negocios y mercados financieros mediante actualizaciones automáticas y correos personalizados.

### ✨ Características Principales

- **🤖 Automatización Completa**: Sistema de cron jobs que actualiza contenido cada hora y envía newsletters diarios
- **📧 Newsletter Inteligente**: Envío automático de correos HTML responsivos con PHPMailer
- **🔐 Sistema de Autenticación**: Registro e inicio de sesión con contraseñas hasheadas (bcrypt)
- **📊 Agregación de Datos en Tiempo Real**: 
  - Noticias de tecnología y negocios
  - Precios de acciones destacadas
  - Cotizaciones de criptomonedas
- **✍️ Contenido Original con IA**: Integración con Google Gemini 2.5 Flash para reescribir noticias y evitar plagio
- **🌐 Web Scraping**: Extracción automática de contenido completo desde fuentes originales
- **🎨 Diseño Profesional**: Interfaz estilo periódico con sistema de tarjetas y diseño responsive

---

## 🔌 APIs e Integraciones

### 1. **GNews API**
- **Propósito**: Agregación de noticias en español de México
- **Categorías**: Tecnología y Negocios
- **Características**: Filtrado por idioma (es), país (mx), con imágenes y metadatos
- **Endpoint**: `https://gnews.io/api/v4/top-headlines?category=business&lang=es&country=mx&max=20`

### 2. **Google Gemini AI (2.5 Flash)**
- **Propósito**: Reescritura automática de contenido para originalidad
- **Modelo**: `gemini-2.5-flash`
- **Características**: 
  - Generación de contenido periodístico profesional
  - Mantiene hechos y contexto original
  - Reformulación completa para evitar plagio
- **Endpoint**: `https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?`

### 3. **Alpha Vantage API**
- **Propósito**: Datos de mercado de valores en tiempo real
- **Características**: Top gainers/losers del mercado estadounidense
- **Función**: `TOP_GAINERS_LOSERS`
- **Endpoint**: `https://www.alphavantage.co/query?function=TOP_GAINERS_LOSERS`

### 4. **CoinGecko API**
- **Propósito**: Cotizaciones de criptomonedas
- **Características**: 
  - Precios en USD
  - Top 10 criptomonedas por capitalización de mercado
  - Datos actualizados en tiempo real
- **Endpoint**: `https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10`

### 5. **PHPMailer**
- **Propósito**: Envío de correos electrónicos HTML
- **Características**:
  - Soporte SMTP (Gmail)
  - Correos HTML responsive
  - Codificación UTF-8
- **Protocolo**: STARTTLS en puerto 587

---

## 🛠️ Stack Tecnológico

| Componente | Tecnología | Versión |
|------------|------------|---------|
| **Backend** | PHP | 8.2 |
| **Base de Datos** | PostgreSQL | 15 |
| **Servidor Web** | Apache | 2.4 |
| **Containerización** | Docker & Docker Compose | Latest |
| **Automatización** | Cron | System |
| **Estilos** | CSS3 (Variables CSS) | - |
| **Email** | PHPMailer | 6.x |

---

## 📁 Estructura del Proyecto

```
Newsletter(botbi)/
├── api/
│   ├── mercados/
│   │   ├── accionesapi.php          # Obtención de datos de acciones
│   │   ├── accionesbd.php           # Consultas de acciones a BD
│   │   ├── criptosapi.php           # Obtención de datos de criptos
│   │   └── criptosbd.php            # Consultas de criptos a BD
│   ├── noticias/
│   │   ├── tecnologiasapi.php       # API de noticias de tecnología
│   │   ├── tecnologiasbd.php        # Consultas de noticias tech
│   │   ├── negociosapi.php          # API de noticias de negocios
│   │   └── negociosbd.php           # Consultas de noticias business
│   ├── newsletter/
│   │   └── newsletter.php           # Generación y envío de newsletter
│   └── helpers/
│       ├── content_new.php          # Web scraping de contenido
│       └── ai_helper.php            # Reescritura con IA (Gemini)
├── config/
│   └── db.php                       # Configuración de base de datos
├── database/
│   └── db.sql                       # Schema de PostgreSQL
├── includes/
│   ├── db.php                       # Clase de conexión a BD
│   ├── header.php                   # Header con navegación y sesiones
│   ├── footer.php                   # Footer con formulario de auth
│   └── mail_config.php              # Configuración de PHPMailer
├── public/
│   ├── index.php                    # Página principal
│   ├── noticia.php                  # Vista de detalle de noticia
│   ├── auth.php                     # Autenticación (login/registro)
│   ├── logout.php                   # Cierre de sesión
│   ├── mandar_correo.php            # Envío manual de newsletter
│   └── css/
│       └── styles.css               # Estilos globales
├── PHPMailer/                       # Librería PHPMailer (local)
├── crontab                          # Configuración de tareas automáticas
├── docker-compose.yml               # Orquestación de contenedores
├── Dockerfile                       # Imagen de PHP con Apache y Cron
├── .env                             # Variables de entorno (API keys)
├── .gitignore                       # Archivos excluidos de Git
└── Readme.md                        # Este archivo
```

---

## 🚀 Instrucciones de Despliegue

### Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:

- **Docker**: v20.10 o superior ([Descargar Docker](https://www.docker.com/products/docker-desktop))
- **Docker Compose**: v2.0 o superior (incluido con Docker Desktop)
- **Git**: Para clonar el repositorio

### Paso 1: Clonar el Repositorio

```bash
git clone git@github.com:DavidAvalos14/Newsletter-Botbi-.git
cd Newsletter(botbi)
```

### Paso 2: Configurar Variables de Entorno

Crea un archivo `.env` en la raíz del proyecto con las siguientes variables:

```env
# API Keys
API_KEY=TU_API_KEY_ALPHA_VANTAGE
API_KEY_NEWS=TU_API_KEY_GNEWS
API_KEY_GEMINI=TU_API_KEY_GOOGLE_GEMINI
```

#### 📌 Cómo Obtener las API Keys

1. **Alpha Vantage**: Regístrate en [https://www.alphavantage.co/support/#api-key](https://www.alphavantage.co/support/#api-key)
2. **GNews**: Obtén tu clave en [https://gnews.io/](https://gnews.io/)
3. **Google Gemini**: Crea una API key en [https://aistudio.google.com/app/apikey](https://aistudio.google.com/app/apikey)
4. **Gmail App Password**: 
   - Ve a [Cuenta de Google](https://myaccount.google.com/)
   - Seguridad → Verificación en 2 pasos (actívala)
   - Contraseñas de aplicaciones → Generar nueva contraseña

### Paso 3: Construir y Levantar los Contenedores

```bash
# Construir las imágenes
docker-compose build

# Levantar los servicios
docker-compose up -d
```

### Paso 4: Verificar el Estado

```bash
# Ver contenedores en ejecución
docker-compose ps

# Ver logs en tiempo real
docker-compose logs -f

# Verificar que cron esté activo
docker exec -it newsletter_botbi-app-1 crontab -l
```

### Paso 5: Acceder a la Aplicación

Abre tu navegador y visita:

```
http://localhost:8080
```

---

## 🔄 Automatización con Cron

El sistema ejecuta las siguientes tareas automáticamente:

| Tarea | Frecuencia | Script | Descripción |
|-------|-----------|--------|-------------|
| **Actualizar Criptomonedas** | Cada hora (minuto 0) | `api/mercados/criptosapi.php` | Obtiene cotizaciones de CoinGecko |
| **Actualizar Acciones** | Cada hora (minuto 0) | `api/mercados/accionesapi.php` | Obtiene top gainers de Alpha Vantage |
| **Actualizar Noticias Tech** | Cada hora (minuto 0) | `api/noticias/tecnologiasapi.php` | Obtiene, scraping y reescribe con IA |
| **Actualizar Noticias Negocios** | Cada hora (minuto 0) | `api/noticias/negociosapi.php` | Obtiene, scraping y reescribe con IA |
| **Enviar Newsletter** | Diario a las 8:00 AM | `api/newsletter/newsletter.php` | Envía correo a todos los suscriptores |

### Ver Logs de Cron

```bash
docker exec -it newsletter_botbi-app-1 tail -f /var/log/cron.log
```

### Carga Inicial de Datos

Al desplegar por primera vez, los datos se cargarán automáticamente gracias a las tareas `@reboot` en crontab (después de 30-45 segundos).

**Si los datos no se cargan automáticamente**, puedes ejecutarlos manualmente:

#### Paso 1: Identificar el nombre del contenedor

```bash
# Ver contenedores activos con su nombre
docker-compose ps

# O usa este comando
docker ps
```

Busca el contenedor del servicio **app** (ejemplo: `newsletter_botbi-app-1` o `newsletterbotbi-app-1`)

#### Paso 2: Ejecutar scripts de carga manual

Reemplaza `newsletter_botbi-app-1` con el nombre real de tu contenedor:

```bash
# Ejecutar todos los scripts de datos
docker exec newsletter_botbi-app-1 php /var/www/html/api/mercados/criptosapi.php
docker exec newsletter_botbi-app-1 php /var/www/html/api/mercados/accionesapi.php
docker exec newsletter_botbi-app-1 php /var/www/html/api/noticias/tecnologiasapi.php
docker exec newsletter_botbi-app-1 php /var/www/html/api/noticias/negociosapi.php
```

**Alternativa más simple (sin necesidad de saber el nombre):**

```bash
docker-compose exec app php /var/www/html/api/mercados/criptosapi.php
docker-compose exec app php /var/www/html/api/mercados/accionesapi.php
docker-compose exec app php /var/www/html/api/noticias/tecnologiasapi.php
docker-compose exec app php /var/www/html/api/noticias/negociosapi.php
```

---

## 📧 Sistema de Newsletter

### Características del Email

- ✅ **Diseño HTML Responsive**: Compatible con todos los clientes de correo
- ✅ **Contenido Personalizado**:
  - Top 10 noticias de tecnología
  - Top 10 noticias de negocios
  - Acciones destacadas con precios
  - Criptomonedas con cotizaciones actuales
- ✅ **Envío Automático**: Todos los días a las 8:00 AM
- ✅ **Email de Bienvenida**: Enviado inmediatamente al registrarse

### Envío Manual de Newsletter

Puedes enviar el newsletter manualmente visitando:

```
http://localhost:8080/mandar_correo.php
```

---

## 🗄️ Base de Datos

### Schema PostgreSQL

La aplicación utiliza 3 tablas principales:

#### 1. **suscriptores**
Almacena usuarios registrados con autenticación segura.

```sql
CREATE TABLE "suscriptores" (
    "id_subs" BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    "subs_email" VARCHAR(255) UNIQUE NOT NULL,
    "subs_password" VARCHAR(255) NOT NULL
);
```

#### 2. **mercados**
Almacena datos de acciones y criptomonedas.

```sql
CREATE TABLE "mercados" (
    "id_mercados" BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    "mcds_nombre" VARCHAR(255) UNIQUE NOT NULL,
    "mcds_precio" DECIMAL(12, 2) NOT NULL,
    "mcds_imagen" TEXT NOT NULL,
    "mcds_tipo" VARCHAR(20) NOT NULL CHECK ("mcds_tipo" IN ('Cripto', 'Accion'))
);
```

#### 3. **noticias**
Almacena noticias reescritas con IA.

```sql
CREATE TABLE "noticias" (
    "news_uuid" UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    "news_titulo" VARCHAR(255) UNIQUE NOT NULL,
    "news_descripcion" TEXT NOT NULL,
    "news_contenido" TEXT NOT NULL,
    "news_fecha" TIMESTAMPTZ DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "news_categoria" VARCHAR(50) NOT NULL CHECK ("news_categoria" IN ('Tecnologia', 'Negocios')),
    "news_url" TEXT UNIQUE NOT NULL,
    "news_imagen" TEXT NOT NULL
);
```

### Conexión Manual a PostgreSQL

```bash
docker exec -it newsletter_botbi-postgres-1 psql -U usr_botbi -d newsletter_db
```

---

## 🛠️ Comandos Útiles

### Docker

```bash
# Detener contenedores
docker-compose down

# Detener y eliminar volúmenes (reiniciar BD)
docker-compose down -v

# Reconstruir contenedores
docker-compose build --no-cache

# Ver logs de un servicio específico
docker-compose logs -f app
docker-compose logs -f postgres

# Ejecutar comando dentro del contenedor
docker exec -it newsletter_botbi-app-1 bash
```

### Base de Datos

```bash
# Backup de la base de datos
docker exec newsletter_botbi-postgres-1 pg_dump -U usr_botbi newsletter_db > backup.sql

# Restaurar backup
cat backup.sql | docker exec -i newsletter_botbi-postgres-1 psql -U usr_botbi -d newsletter_db
```

---

## 🔒 Seguridad

- ✅ **Contraseñas hasheadas**: Se usa `password_hash()` con bcrypt
- ✅ **Variables de entorno**: API keys no están en el código
- ✅ **.gitignore configurado**: Archivos sensibles excluidos de Git
- ✅ **Sanitización de inputs**: `filter_var()` en formularios
- ✅ **Prepared statements**: Prevención de SQL injection
- ✅ **HTTPS recomendado**: Para producción usar certificado SSL

---

## 🐛 Troubleshooting

### Problema: Contenedores no inician

```bash
# Ver logs detallados
docker-compose logs

# Verificar puertos en uso
netstat -ano | findstr :8080
netstat -ano | findstr :5432
```

### Problema: Cron no ejecuta tareas

```bash
# Verificar que cron esté corriendo
docker exec -it newsletter_botbi-app-1 service cron status

# Ver tareas programadas
docker exec -it newsletter_botbi-app-1 crontab -l

# Ver logs de ejecución
docker exec -it newsletter_botbi-app-1 cat /var/log/cron.log
```

### Problema: No se envían correos

- ✅ Verifica que el puerto 587 no esté bloqueado por firewall

### Problema: Error de base de datos

```bash
# Recrear base de datos
docker-compose down -v
docker-compose up -d
```

---

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

---

## 👨‍💻 Autor

**Angel David Avalos Carrillo**

- Portfolio: [https://davidavalos14.github.io/Portafolio](https://davidavalos14.github.io/Portafolio)
- Proyecto: Newsletter Automatizado con IA

---

## 🙏 Agradecimientos

- **GNews** por su API de noticias en español
- **Google** por Gemini AI
- **Alpha Vantage** por datos de mercado
- **CoinGecko** por información de criptomonedas
- **PHPMailer** por facilitar el envío de correos

---

**⭐ Si te gusta este proyecto, dale una estrella!**
