# 🎓 Student Transaction and Enrollment Management System

## 📘 Description / Overview
This project is a web-based **Student Transaction and Enrollment Management System** built using **Laravel**.  
It allows administrators to manage student records, course enrollments, and payment transactions efficiently.  
The system aims to provide a simple, organized, and secure way to handle student information and enrollment workflows.

---

## 🎯 Objectives
- To design and develop a functional student management system using Laravel.
- To enable CRUD operations (Create, Read, Update, Delete) for student and course data.
- To streamline the enrollment and transaction processes.
- To practice MVC architecture, routing, and database integration in Laravel.
- To enhance understanding of full-stack web development concepts.

---

## ⚙️ Features / Functionality
- **Student Management:** Add, edit, and view student profiles.  
- **Course Management:** Create and maintain course information.  
- **Enrollment Module:** Assign students to courses and manage enrollment records.  
- **Transaction Handling:** Record and view payment or fee transactions.  
- **Dashboard Analytics:** View summarized statistics for students and courses.  
- **Authentication System:** Secure login and registration for administrators.  
- **Database Integration:** Connected to MySQL for persistent storage.

---

## 🧩 Installation Instructions

### Prerequisites
- PHP 8.1 or later  
- Composer  
- Node.js and npm  
- MySQL Database  
- Laravel 10 framework

### Steps
1. Clone or extract the project files.
   ```bash
        git clone https://github.com/shinconcubierta/studentmanagementsystem.git

2. Navigate to the project folder.

        cd concubierta-students-tps


3. Install PHP dependencies.

        composer install


4. Install JavaScript dependencies.

        npm install


5. Create a copy of the environment file.

        cp .env.example .env


6. Generate the application key.

        php artisan key:generate


7. Set up your database credentials inside the .env file.

8. Run migrations to create tables.

        php artisan migrate


9. Start the development server.

        php artisan serve


10. Access the project in your browser at:
        http://127.0.0.1:8000
