# E-commerce en PHP

Aplicació web d'e-commerce en PHP

Fet per Fabio i Robin

## Entrega Intermèdia (20/02/2026)

### Funcionalitats implementades

1. **Pàgina principal** (`index.php`)
   - Header
   - Menú de navegació (Inici, Carret)
   - Mosaic de productes amb nom i preu
   - Afegir productes al carret amb quantitat

2. **Carret de la compra** (`cart.php`)
   - Afegir productes des de la pàgina principal
   - Modificar quantitat de cada producte
   - Eliminar productes del carret
   - Subtotal (sense IVA)
   - Total final amb IVA 21%

### Executar amb Docker

```bash
docker compose up --build
```

Obre el navegador a: http://localhost:8080

### Executar sense Docker

Assegureu-vos de tenir PHP instal·lat:

```bash
cd src && php -S localhost:8000
```

O des del directori arrel del projecte:

```bash
php -S localhost:8000 -t src
```

### Estructura

```
ecomerce/
├── docker/
│   └── Dockerfile
├── src/
│   ├── index.php      # Pàgina principal amb productes
│   ├── cart.php       # Carret de la compra
│   ├── inc/
│   │   ├── config.php    # Productes i constants
│   │   ├── functions.php # Funcions del carret
│   │   ├── header.php    # Header i menú
│   │   └── footer.php    # Peu de pàgina
│   └── css/
│       └── style.css     # Estils
└── docker-compose.yml
```

### Tecnologia

- PHP amb sessions per la gestió del carret
- Sense base de dades (productes definits a `inc/config.php`)
