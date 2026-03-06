# UniStack — INES Digital Notice Board & Marketplace

> Assignment #2 — From Street to Stack | INES-Ruhengeri, Year II CS
> Scenario C: UniStack

---

## 🚀 Live Demo
>https://group.liveblog365.com

---

## 📁 Project Structure
```
unistack/
├── app/
│   ├── controllers/        ← Business logic (MVC Controller layer)
│   ├── models/             ← Database queries (MVC Model layer)
│   └── views/              ← HTML templates (MVC View layer)
│       ├── shared/         ← Header, footer, login, register, home
│       ├── student/        ← Student dashboard, post forms
│       ├── moderator/      ← Moderator panel, flagged posts
│       └── admin/          ← Admin dashboard, users, audit log
├── config/
│   └── db.php              ← Database connection
├── docs/                   ← All planning & documentation
│   ├── street-report.md
│   ├── problem.md
│   ├── stakeholders.md
│   ├── user-stories.md
│   ├── scope.md
│   ├── ui-style.md
│   ├── page-map.md
│   ├── testing.md
│   ├── AI-usage.md
│   └── wireframes/
├── public/
│   ├── css/style.css       ← Main stylesheet
│   ├── js/app.js           ← JS polling + UI interactions
│   └── index.php           ← Front controller (router)
└── schema.sql              ← Database schema + seed data
```

---

## ⚙️ Setup Instructions

### 1. Prerequisites
- PHP 8.0+
- MySQL 8.0+
- Apache (XAMPP, WAMP, or LAMP)

### 2. Clone the Repository
```bash
git clone https://github.com/henrietteirasubiza/Web_Ass_2_group_7_II_A
cd Web_Ass_2_group_7_II_A
```

### 3. Database Setup
```sql
-- Option A: via phpMyAdmin
-- 1. Open phpMyAdmin
-- 2. Click "Import"
-- 3. Select schema.sql
-- 4. Click Go

-- Option B: via MySQL CLI
mysql -u root -p < schema.sql
```

### 4. Configure Database Connection
Edit `config/db.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');      // change this
define('DB_PASS', 'your_db_password');  // change this
define('DB_NAME', 'unistack_db');
```

### 5. Set Document Root
Point your Apache VirtualHost or XAMPP to the `public/` directory, or place the whole project in `htdocs/unistack/` and access via `http://localhost/unistack/public/`.

### 6. Fix Passwords After Import
The schema seeds demo users. Update their passwords after import:
```php
// Run this once in a temp PHP file to get real hashes:
echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
// Then update in phpMyAdmin:
UPDATE users SET password = 'paste_hash_here' WHERE email = 'admin@ines.ac.rw';
```

---

## 🔐 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ines.ac.rw | ines |
| Moderator | mod@ines.ac.rw | ines12 |
| Student | student@ines.ac.rw | ines |

> ⚠️ Change these passwords immediately in a production environment.

---

## 🌐 Deployment (InfinityFree / 000webhost)

1. Create a free account at https:profreehost.com
2. Create a hosting account and note your MySQL credentials
3. Upload all files via File Manager or FTP (FileZilla)
4. Create a database in InfinityFree control panel
5. Import `schema.sql` via phpMyAdmin (provided in control panel)
6. Update `config/db.php` with InfinityFree credentials
7. Access your live site via the provided subdomain

---

## 🛠️ Tech Stack
- **Backend:** PHP 8 (MVC, no framework)
- **Database:** MySQL 8 with MySQLi Prepared Statements
- **Frontend:** HTML5, CSS3 (custom, no framework), Vanilla JS
- **Fonts:** Inter (Google Fonts)
- **Hosting:** InfinityFree / 000webhost

---

## 👥 Team Members

| Name            |  Role | 
|------|------
| youssif mohamed | role1 |
|umugaba honore    |role2+role4|
| mwiseneza kelly | role3|
|iradukunda pauline|role5|
|ibrahim ahmed     |role6
| irasubiza henriette | role7

---

## 📄 License
Academic project — INES-Ruhengeri, 2026.
