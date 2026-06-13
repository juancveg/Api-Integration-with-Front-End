# 🛒 API Integration with Front End

A two-part project demonstrating API integration with a PHP front end:

- **Apiturismo** — a custom REST API (PHP + MySQL) for managing a `clients` database (CRUD).
- **Frontangular** — a PHP storefront that consumes the [Fake Store API](https://fakestoreapi.com/) to display products.

---

## 📁 Project Structure

```
Api-Integration-with-Front-End/
├── Apiturismo/              # Custom REST API (PHP + MySQLi)
│   ├── conexion.php         # Database connection
│   ├── getcliente.php       # GET    /getcliente  → list or fetch client(s)
│   ├── save.php             # POST   /save        → create client
│   ├── update.php           # PUT    /update      → update client
│   └── delete.php           # DELETE /delete      → remove client
│
└── Frontangular/            # PHP storefront (Fake Store API)
    ├── index.php            # Home — random featured product
    ├── listado.php          # Product listing table
    └── detalle.php          # Product detail page
```

---

## 🗄️ Database Setup (Apiturismo)

Create a MySQL database named `turismo` and run the following SQL:

```sql
CREATE DATABASE turismo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE turismo;

CREATE TABLE clientes (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombres    VARCHAR(100) NOT NULL,
    apellidos  VARCHAR(100) NOT NULL,
    direccion  VARCHAR(200),
    telefono   VARCHAR(20),
    correo     VARCHAR(100),
    created    DATETIME,
    modified   DATETIME
);
```

Then update `conexion.php` with your credentials if needed.

---

## 🔌 REST API — Endpoints

Base URL: `http://localhost/Apiturismo/`

| Method   | File              | Description             | Body (JSON)                                                    |
|----------|-------------------|-------------------------|----------------------------------------------------------------|
| `GET`    | `getcliente.php`  | Get all clients         | _(none)_                                                       |
| `GET`    | `getcliente.php`  | Get client by ID        | `{ "id": 1 }`                                                  |
| `POST`   | `save.php`        | Create a new client     | `{ "nombres": "...", "apellidos": "...", "direccion": "...", "telefono": "...", "correo": "..." }` |
| `PUT`    | `update.php`      | Update existing client  | `{ "id": 1, "nombres": "...", ... }`                           |
| `DELETE` | `delete.php`      | Delete a client         | `{ "id": 1 }`                                                  |

### Example responses

**GET all clients**
```json
[
  { "id": "1", "nombres": "John", "apellidos": "Doe", "correo": "john@example.com" }
]
```

**POST / PUT / DELETE**
```json
{ "codigo": "ok", "mensaje": "Record saved" }
```

---

## 🖥️ Front End — Pages (Frontangular)

Requires a PHP server with `allow_url_fopen` enabled (to call the Fake Store API).

| Page          | URL                          | Description                          |
|---------------|------------------------------|--------------------------------------|
| Home          | `index.php`                  | Random featured product of the day   |
| Product list  | `listado.php`                | Full product table with detail links |
| Product detail| `detalle.php?id={id}`        | Full details for a single product    |

---

## 🚀 Getting Started

### Requirements

- PHP 7.4+
- MySQL / MariaDB
- A local server: [XAMPP](https://www.apachefriends.org/), [Laragon](https://laragon.org/), or similar

### Installation

1. Clone or extract the project into your server's web root (e.g. `htdocs/` on XAMPP).
2. Create the `turismo` database using the SQL above.
3. Open `Apiturismo/conexion.php` and set your DB credentials.
4. Visit `http://localhost/Frontangular/index.php` to see the storefront.
5. Test the API with [Postman](https://www.postman.com/) or `curl`.

### Quick curl test

```bash
# Get all clients
curl http://localhost/Apiturismo/getcliente.php

# Create a client
curl -X POST http://localhost/Apiturismo/save.php \
  -H "Content-Type: application/json" \
  -d '{"nombres":"John","apellidos":"Doe","direccion":"123 Main St","telefono":"555-1234","correo":"john@example.com"}'

# Delete a client
curl -X DELETE http://localhost/Apiturismo/delete.php \
  -H "Content-Type: application/json" \
  -d '{"id":1}'
```

---

## ⚠️ Security Notes

> This project is intended for **learning purposes**. Before deploying to production:

- Use **prepared statements** for all queries (save/update already do — apply the same pattern to `getcliente.php` and `delete.php`).
- Replace `Access-Control-Allow-Origin: *` with a specific domain.
- Store DB credentials in environment variables, not in source files.
- Add input validation and authentication (e.g. API keys or JWT).

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).
