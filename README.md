# Mini SaaS / POS Backend System (API-First)

## Project Overview

This project is a **Multi-Tenant POS / Inventory Management Backend System** built with **Laravel 12** following an **API-first, secure, and scalable architecture**.

Each business operates as an independent **tenant**, and **strict data isolation** is enforced across all layers of the system.

---

## Tech Stack

* **Laravel 12**
* **Laravel Sanctum** (API Authentication)
* **MySQL** (Relational Database)
* **Eloquent ORM**
* **Postman** (API testing & demo)

---

## Core Features

* Multi-Tenancy using `X-Tenant-ID` header
* Token-based Authentication (Sanctum)
* Role-Based Access Control (Owner, Staff)
* Inventory & Order Management with transactional stock handling
* Optimized reporting-ready data structure
* Secure, production-grade API design

---

## Architecture Overview

### Multi-Tenancy Strategy

* Every business entity contains a `tenant_id`
* Tenant context is resolved globally using a middleware
* A shared `BaseTenantModel` applies global scopes to enforce tenant isolation

**Tenant Resolution Flow:**

```
Request → X-Tenant-ID Header → ResolveTenant Middleware → Global Tenant Context
```

---

## Authentication & Authorization

### Authentication

* Implemented using **Laravel Sanctum**
* Only **Owner** and **Staff** users can authenticate
* Customers are treated as business entities (no login)

### Authorization (RBAC)

* Roles: `owner`, `staff`
* Authorization logic implemented using **Laravel Policies**
* Policies are tenant-aware and role-aware
* No authorization logic exists inside controllers

---

## Inventory & Order Management

### Product

* SKU is unique per tenant
* Stock and low-stock threshold tracking

### Order

* Orders support multiple products
* Stock is deducted using `DB::transaction()`
* Row-level locking prevents race conditions
* Negative inventory is strictly prevented

### Order Cancellation

* Only owners can cancel orders
* Cancelling an order restores inventory stock
* All operations are transactional

---

## Security Considerations

* Form Request Validation for all inputs
* Mass assignment protection using `$fillable`
* Strict policy-based authorization
* API rate limiting
* Secure error handling without sensitive data exposure

---

## Performance Considerations

* Eager loading to avoid N+1 queries
* Indexed columns:

  * `tenant_id`
  * `created_at`
  * `product_id`
* Database transactions for critical operations

---

## API Design Standards

* RESTful API conventions
* Consistent JSON response structure
* Laravel API Resources (`JsonResource`)
* Pagination on listing endpoints

---

## Database Seeding

Seeders are provided for:

* Tenant
* Owner & Staff Users
* Customers
* Products

Seeding ensures:

* Correct `tenant_id` assignment
* Valid foreign key relationships
* Ready-to-demo environment

Run:

```bash
php artisan migrate:fresh --seed
```

---

## Postman API Collection

### What Is Provided

This project includes **ready-to-import Postman collections** covering:

* Authentication (Login, Logout)
* Product CRUD
* Customer CRUD
* Order Creation & Cancellation


#### Upload json API collection file to the postman

* Add Postman collection JSON files to the GitHub repository:

```
/postman
 ├── Mini SaaS POS API.postman_collection.json
```

#### Public Postman API Collection view link

[Postman API Collection](https://documenter.getpostman.com/view/14128827/2sBXVkBUd1)

---

## API Usage Requirements

All API requests must include:

```
X-Tenant-ID: <tenant_id>
Authorization: Bearer <token>
```

---

## Setup Instructions

```bash
composer install
cp .env.example .env

.env file modify these lines
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=pos_api

php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## Demo Flow

1. Login as Owner
2. Create Product & Customer
3. Create Order (stock deduction)
4. Cancel Order (stock restore)

---

## Evaluation Alignment

This project fully satisfies:

* Multi-tenant data isolation
* Secure authentication & RBAC
* Transaction-safe inventory handling
* Clean architecture & documentation

---

## Project GitHub Link

[Project GitHub Link](https://github.com/basudev-g/multitenat-pos-api-app)

## Author

**Basudev Goswami**
Laravel Developer
