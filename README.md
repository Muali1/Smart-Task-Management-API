# 🚀 Smart Task Management API (Laravel)

A professional RESTful API built with Laravel for managing tasks with advanced business logic, status flow constraints, and smart filtering/sorting.

## 📌 Features & Business Logic
This project goes beyond simple CRUD, implementing the following rules:
- **Status Flow Control:** Tasks can only move from `pending` ➔ `in_progress` ➔ `done`.
- **Completion Guard:** Once a task is `done`, it cannot be modified.
- **Priority Validation:** If a task is marked as `high` priority, a `due_date` is mandatory.
- **Overdue Detection:** Automatically identifies tasks that are past their due date (if not completed).
- **Smart Default Sorting:** By default, tasks are sorted by `high` priority first, then by the nearest `due_date`.

---

## ⚙️ Setup Instructions

Follow these steps to run the project locally:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Muali1/Smart-Task-Management-API.git](https://github.com/Muali1/Smart-Task-Management-API.git)
   cd Smart-Task-Management-API
2. **Install Composer dependencies: composer install
3. Environment Setup : copy .env.example into .env
4. Generate App Key : php artisan key:generate
5. Run Migrations & Seeders: php artisan migrate:fresh --seed
6. Serve the Application: php artisan serve

### 🔌 API Endpoints Reference

| Method | Endpoint | Functionality | Description |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/tasks` | **List Tasks** | Retrieve all tasks with support for **filtering**, **searching**, and **sorting**. |
| **POST** | `/api/tasks` | **Create Task** | Add a new task to the system (Validates priority and due date). |
| **GET** | `/api/tasks/{id}` | **Task Details** | Fetch all details of a specific task by its ID. |
| **PUT** | `/api/tasks/{id}` | **Update Task** | Modify task details or update status (Validates **Status Flow**). |
| **DELETE** | `/api/tasks/{id}` | **Remove Task** | Permanently delete a task from the database. |
