# Web-Based Student Management System

A web-based Student Management System developed as part of the **B.Tech DBMS Lab Project**.  
The application demonstrates core **Database Management System concepts** using a real-world use case.

---

## 📌 Project Overview

The Student Management System (SMS) is designed to manage:
- Student details
- Faculty information
- Course details
- Student enrollments
- Academic marks and reports

The system uses a **normalized relational database** and a simple web interface to perform database operations.

---

## 🛠️ Technologies Used

- **Frontend:** HTML
- **Backend:** PHP
- **Database:** MySQL
- **Server:** XAMPP (Apache + MySQL)
- **Tools:** phpMyAdmin, VS Code

---

## 🗄️ Database Design

### Tables Used
- `student`
- `faculty`
- `course`
- `enrollment`
- `marks`

### Relationships
- One student can enroll in many courses
- One course can have many students
- Faculty can teach multiple courses
- Enrollment acts as a linking table
- Marks depend on enrollment

---

## ✨ DBMS Concepts Implemented

- DDL (CREATE TABLE)
- DML (INSERT, UPDATE, DELETE, SELECT)
- Primary & Foreign Keys
- Integrity Constraints
- JOIN operations
- Aggregate functions (AVG, COUNT, etc.)
- Views
- Triggers

---

## 📂 Project Structure

