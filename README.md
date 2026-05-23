<div align="center">
  <!-- You can replace this placeholder with your actual project logo -->
  <img src="public/assets/images/logo/logo-white.png" alt="Project Logo" width="120" height="120">
  
  # 🌟 Manajemen Relawan dan Kegiatan Sosial Siswa 🌟
  *(Student Volunteer & Social Activity Management System)*

  <p align="center">
    A comprehensive platform designed to streamline and organize school-based social activities, volunteer registrations, and student participation history.
  </p>

  <!-- Badges -->
  <p align="center">
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E" alt="JavaScript" />
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  </p>
</div>

---

## 📖 Table of Contents
- [Project Overview](#-project-overview)
- [Problem Statement](#-problem-statement)
- [Objectives](#-objectives)
- [Main Features](#-main-features)
- [Technology Stack](#-technology-stack)
- [Architecture & Database](#-architecture--database)
- [Folder Structure](#-folder-structure)
- [Installation & Setup](#-installation--setup)
- [Usage Instructions](#-usage-instructions)
- [Application Flow & Roles](#-application-flow--roles)
- [Future Improvements & Scalability](#-future-improvements--scalability)
- [Security Considerations](#-security-considerations)
- [Contributors](#-contributors)

---

## 🚀 Project Overview

Schools frequently organize various social initiatives, ranging from charity events and community service to fundraising and humanitarian relief programs. **Idealis** (Student Volunteer & Social Activity Management System) is an integrated web-based platform tailored specifically for educational institutions to manage these activities efficiently. It acts as a centralized hub connecting activity coordinators with passionate student volunteers.

## 🛑 Problem Statement

Currently, volunteer data management in schools is largely manual, paper-based, or scattered across disjointed spreadsheets. This leads to:
- **Poor Communication**: Information regarding schedules, activity specifics, and exact volunteer needs fails to reach students clearly.
- **Disorganized Data**: Tracking who registered for what is tedious and prone to errors.
- **Lack of Recognition**: There is no structured, verifiable participation history for students who consistently contribute to social causes, making it hard for them to showcase their extracurricular achievements.

## 🎯 Objectives

This system was built to address these challenges with the following goals:
1. **Streamline Management**: Provide a structured, digital approach to creating and managing social activities.
2. **Simplify Registration**: Offer an intuitive and accessible portal for students to browse and sign up for volunteer opportunities.
3. **Record History**: Maintain an accurate, permanent record of student participation and contributions for future reference (e.g., portfolios, certificates).
4. **Improve Communication**: Ensure clear dissemination of event details and requirements.

---

## ✨ Main Features

- **📅 Event Management (CRUD)**: Admins can easily Create, Read, Update, and Delete social activities.
- **📝 Volunteer Registration System**: Students can view active events and seamlessly register as volunteers.
- **👥 Activity Rosters**: Dedicated views to see the complete list of volunteers for each specific activity.
- **🏆 Participation History**: A personalized dashboard for students showing their past activities and volunteer hours.
- **📊 Interactive Dashboard**: A centralized control panel for quick insights into active events and user statistics.
- **🔍 Detailed Activity Pages**: Comprehensive pages displaying event descriptions, dates, requirements, and current volunteer counts.
- **🔐 Secure Authentication**: Robust user login and registration system with role-based access control.
- **📱 Responsive UI Design**: A mobile-friendly interface built with Tailwind CSS, ensuring accessibility across all devices.

---

## 🛠 Technology Stack

This project leverages a robust and modern technology stack suitable for scalable web applications:

*   **Backend**: Raw PHP (Custom MVC-like architecture)
*   **Frontend Logic**: Vanilla JavaScript (AJAX for asynchronous operations)
*   **Styling**: CSS3 & Tailwind CSS (Utility-first styling for rapid UI development)
*   **Database**: MySQL (Relational database management)

---

## 🗄 Architecture & Database

### Database Overview (ERD Explanation)
The database is structured to handle users, events, and the relationships between them representing participation and roles.

**Key Entities:**
1.  **`users`**: Stores user credentials, profiles, and system roles (Admin, Student, PIC).
    - *Example Columns*: `id`, `name`, `email`, `password`, `role`, `department`, `created_at`
2.  **`events`**: Contains all details regarding social activities and news.
    - *Example Columns*: `id`, `title`, `description`, `event_date`, `location`, `status`, `created_by`
3.  **`participants` / `donations`**: Pivot tables linking users to events, tracking registration status, history, and optional financial contributions.
    - *Example Columns*: `id`, `user_id`, `event_id`, `registered_at`, `donation_amount`, `status`

### Example Routes
- `GET /login` - Displays the authentication portal.
- `POST /auth/login` - Handles backend authentication logic.
- `GET /dashboard` - Central hub for both Admins and Users.
- `GET /events` - Lists all available open events.
- `GET /event/detail?id={id}` - View specific details for a single activity.
- `POST /event/join` - Handles asynchronous student registration.

---

## 📂 Folder Structure

```text
idealis/
├── .gitignore
├── README.md             # Project documentation
├── app/
│   ├── config/           # Configuration files
│   ├── controllers/      # PHP classes handling business logic & routing
│   ├── core/             # Application core (Router, DB, Controller base)
│   ├── middleware/       # Route middlewares (Auth)
│   ├── models/           # Database interaction classes
│   └── views/            # UI templates (HTML/PHP mix)
│       ├── admin/
│       ├── auth/
│       ├── donations/
│       ├── events/
│       ├── history/
│       ├── landing/
│       ├── layouts/      # Reusable UI components (header, footer, modals)
│       ├── news/
│       ├── profile/
│       ├── suggestions/
│       └── volunteers/
└── public/               # Publicly accessible files
    ├── index.php         # Application entry point / Front Controller
    ├── assets/           # Static assets (fonts, images)
    ├── css/              # Custom CSS outputs
    └── js/               # Client-side JavaScript & AJAX handlers
```

---

## ⚙️ Installation & Setup

Follow these steps to get the project running on your local machine.

### Prerequisites
- XAMPP / Laragon / WAMP installed
- PHP >= 7.4 (or 8.x)
- MySQL

### Step-by-step Guide

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/yourusername/idealis.git
    cd idealis
    ```

2.  **Environment Setup**
    - Move the project folder to your local server's root directory (e.g., `htdocs` for XAMPP or `www` for Laragon).

3.  **Database Configuration**
    - Open your database manager (phpMyAdmin, DBeaver, etc.).
    - Create a new database named `idealis`.
    - Import the provided SQL schema file (e.g., `database/idealis.sql`).
    - Configure your database connection inside `config/database.php` (update `DB_NAME`, `DB_USER`, `DB_PASS`).

4.  **Run the Application**
    - Start your local Apache and MySQL servers.
    - Open your browser and navigate to `http://localhost/idealis` (or your configured local host URL).

---

## 💡 Application Flow & Roles

### User Roles
- **Admin**: Full access. Can create, edit, delete events, manage users, modify system data, and view overall system statistics.
- **PIC (Person In Charge)**: Can manage specific events assigned to them and view participant lists for their events.
- **Student/User**: Can browse active events, register as volunteers, and view their personal participation history and profiles.

### Authentication Flow
1. Users register via the secure Sign-Up portal. Passwords are encrypted using PHP's native robust `password_hash()` mechanism.
2. Upon Login, a secure PHP session is initiated.
3. Access Control checks session validity and user roles before granting access to protected routes or administrative dashboard areas.

### Responsive Design
The UI is heavily styled with **Tailwind CSS**, utilizing its mobile-first utility classes. This ensures that the application is fully functional, visually appealing, and accessible whether accessed from a desktop monitor, tablet, or smartphone.

---

## 🔮 Future Improvements & Scalability

To further enhance the system, the following features are considered for future releases:
- [ ] **Email Notifications**: Automated emails for registration confirmations and event updates using a service like PHPMailer.
- [ ] **Certificate Generation**: Automatically generate and download PDF certificates for completed volunteer hours.
- [ ] **Export to Excel/PDF**: Allow admins to easily export participant lists and activity reports for school records.
- [ ] **Framework Migration**: Scale the backend by migrating to a full-fledged framework like Laravel to benefit from advanced ORM, routing, and ecosystem features.

## 🛡️ Security Considerations

- **SQL Injection Prevention**: All database interactions utilize PDO (PHP Data Objects) Prepared Statements.
- **XSS Protection**: User inputs are sanitized and outputs are escaped before rendering in the DOM to prevent Cross-Site Scripting.
- **Authentication**: Passwords are securely hashed, and sessions are tightly controlled and regenerated to prevent session hijacking.

---

## 🤝 Contributors

- **[Your Name/Username]** - *Lead Developer* - [Your GitHub Profile](https://github.com/yourusername)

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/yourusername/idealis/issues).

<div align="center">
  <br>
  <i>Built with ❤️ to foster better school communities.</i>
</div>
