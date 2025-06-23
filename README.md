# Laravel Microservices Architecture

This project demonstrates how to build a **microservices-based system** using **Laravel 12**, where each service is isolated, communicates via HTTP, and serves a specific purpose.

---

## 🧩 Microservices Included

| Service             | Purpose                                  | Port     |
|---------------------|-------------------------------------------|----------|
| `user-service`      | Handles user registration, login, token auth | 8000     |
| `project-service`   | Manages projects (CRUD) using token-based auth | 8001     |
| `notification-service` | Sends notifications (via email or log)     | 8002     |

---

## 📦 Tech Stack

- Laravel 12
- MySQL (each service has its own DB)
- Laravel Sanctum (for auth)
- Laravel Mail (log driver for email)
- Laravel HTTP Client (service-to-service communication)

---

## 🛠 Folder Structure
```
laravel-microservices/
├── user-service/ # Handles auth, tokens, user data
├── project-service/ # CRUD operations for projects
├── notification-service/ # Sends email notifications
└── README.md

```
---

## ⚙️ Service Setup Instructions

### ✅ 1. User Service (`user-service`)

**Setup:**
```bash
cd user-service
composer install
cp .env.example .env
php artisan key:generate

```
# Configure DB in .env

php artisan migrate
php artisan serve --port=8000

Endpoints:

POST /api/register → Register new user

POST /api/login → Get token

GET /api/user → Get logged-in user (requires Bearer token)

Auth Token: Uses Laravel Sanctum

### ✅ 2. Project Service (project-service)

**Setup:**
 ```bash
Copy
Edit
cd project-service
composer install
cp .env.example .env
php artisan key:generate

```
# Configure DB in .env
php artisan migrate
php artisan serve --port=8001

Features:

CRUD operations for Project

Validates token by calling user-service

Endpoints (all protected with token):

GET /api/projects

POST /api/projects

PUT /api/projects/{id}

DELETE /api/projects/{id}

Token Validation:

Middleware calls http://localhost:8000/api/user using bearer token

If token valid, user data is injected into request

Notification Integration:

On successful project creation, sends POST to notification-service

### ✅ 2. Notification Service (notification-service)

**Setup:**

bash
```
Copy
Edit
cd notification-service
composer install
cp .env.example .env
php artisan key:generate
```
# Set MAIL_MAILER=log in .env
php artisan serve --port=8002
Endpoint:

POST /api/notify

Payload Example:

json
Copy
Edit
{
  "email": "john@example.com",
  "message": "Project created successfully"
}
Mail Output: Goes to storage/logs/laravel.log (via log driver)

🔄 Communication Flow
Client registers and logs in using user-service → gets token.

Client uses token to call project-service.

project-service validates token with user-service.

After project is created, it sends data to notification-service.




