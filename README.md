# Project Installation Guide

This guide will help you set up and run a raw PHP project on Windows, Ubuntu, and macOS. This project follows the Laravel MVC design pattern flow (Laravel Clone) and has great potential for further feature development.

## Prerequisites
Ensure you have the following installed:
- PHP (>=8.0 recommended)
- MySQL
- Apache/Nginx (or use PHP's built-in server)
- Composer

---
<details>
  <summary>Database Import</summary>
  Check file in project root directory
  ![Alt text](https://github.com/sagor-roy/event-management/blob/main/public/assets/src/images/screenshot.jpg)
</details>

---

<details>
  <summary>Installation on Windows</summary>

### 1. Install Required Software
- Download and install [XAMPP](https://www.apachefriends.org/download.html) or [WAMP](https://www.wampserver.com/).
- Alternatively, install PHP, MySQL, and Apache manually.

### 2. Clone the Repository
```sh
 git clone https://github.com/sagor-roy/event-management.git
 cd your-repo
```

### 3. Configure `.env`
Copy `.env.example` to `.env` and update the database configuration.
```sh
APP_NAME = 'Event Management'
APP_ENV = local

DB_HOST = localhost
DB_NAME = 'events_management'
DB_USER = root
DB_PASS = 'your_password'
```
For Production (Hide Server Display Error)
```sh
APP_ENV = production
```
### 4. Start Apache & MySQL
- If using XAMPP, start Apache and MySQL from the XAMPP Control Panel.
- If manually installed, use:
```sh
 php -S localhost:8000 -t public
```

### 5. Import Database
- Open phpMyAdmin (`http://localhost/phpmyadmin`).
- Create a new database and import the `database.sql` file.

### 6. Run the Project
Open a browser and visit:
```sh
 http://localhost/your-project-folder
```
</details>

---

<details>
  <summary>Installation on Ubuntu</summary>

### 1. Install Required Packages
```sh
sudo apt update
sudo apt install apache2 php php-mysql mysql-server unzip
```

### 2. Clone the Repository
```sh
git clone https://github.com/sagor-roy/event-management.git
cd your-repo
```

### 3. Configure `.env` 
Copy `.env.example` to `.env` and update the database configuration.
```sh
APP_NAME = 'Event Management'
APP_ENV = local

DB_HOST = localhost
DB_NAME = 'events_management'
DB_USER = root
DB_PASS = 'your_password'
```
For Production (Hide Server Display Error)
```sh
APP_ENV = production
```
### 4. Set Up MySQL Database
```sh
sudo mysql -u root -p
CREATE DATABASE your_database;
EXIT;
```
Import SQL file:
```sh
mysql -u root -p your_database < database.sql
```

### 5. Configure Apache
```sh
sudo cp -r your-repo /var/www/html/
sudo chmod -R 755 /var/www/html/your-repo
sudo systemctl restart apache2
```

### 6. Run the Project
Open your browser and go to:
```sh
http://localhost/your-repo
```
Or run:
```sh
 php -S localhost:8000 -t public
```
</details>

---

<details>
  <summary>Installation on macOS</summary>

### 1. Install Homebrew (if not installed)
```sh
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### 2. Install PHP, MySQL, and Apache
```sh
brew install php mysql apache2
```

### 3. Clone the Repository
```sh
git clone https://github.com/sagor-roy/event-management.git
cd your-repo
```

### 3. Configure `.env`
Copy `.env.example` to `.env` and update the database configuration.
```sh
APP_NAME = 'Event Management'
APP_ENV = local

DB_HOST = localhost
DB_NAME = 'events_management'
DB_USER = root
DB_PASS = 'your_password'
```
For Production (Hide Server Display Error)
```sh
APP_ENV = production
```
### 5. Start MySQL and Import Database
```sh
brew services start mysql
mysql -u root -p -e "CREATE DATABASE your_database;"
mysql -u root -p your_database < database.sql
```

### 6. Run PHP's Built-in Server (Optional)
```sh
php -S localhost:8000 -t public
```
Then, visit:
```sh
http://localhost:8000
```
</details>

---

## Additional Notes
- Use `composer install`
- Modify `config/database.php` as per your environment settings if needed.

---


