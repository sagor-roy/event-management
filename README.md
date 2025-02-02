# Event Management System

## Overview

The Event Management System is a web-based application that allows users to create, manage, and view events, register attendees, and generate event reports. The project is developed using pure PHP (without frameworks) and MySQL.This project follows the Laravel MVC design pattern flow (Laravel Clone) and has great potential for further feature development and trying to the best practice

## Features

### 1. User Authentication

- Secure user login and registration.
- Passwords are hashed for security.

### 2. Event Management

- Authenticated users can create, update, view, and delete events.
- Events include details such as name, description, date, and maximum capacity.

### 3. Attendee Registration

- Users can register for events via a registration form.
- Registration is restricted beyond the maximum event capacity.

### 4. Event Dashboard

- Displays events in a paginated, sortable, and filterable format.

### 5. Event Reports

- Admins can download attendee lists for specific events in CSV format.

### 6. Bonus Features

- Search Functionality: Search across events and attendees.
- AJAX-based Registration: Enhances user experience. Every form submit with AJAX
- JSON API Endpoint: Fetch event details programmatically.
  <details>
  <summary>API Enpoint Docs</summary>
    
  ### Base URL
  ```sh
    http://65.0.105.94/api/v1
  ```

  ### Endpoints
  #### 1. Get Event by ID
  Retrieves details of a specific event, including its attendees and remaining ticket count.
  - URL: /event/{event_id}
  - Method: GET
  - URL Parameters:
  - event_id (required): The ID of the event.
    
  #### Example Request
  ```sh
  GET /api/v1/event/1
  ```

  #### Example Request
  ```sh
      {
        "id": 1,
        "slug": "tech-world",
        "description": "A conference about technology.",
        "deadline": "2023-12-15 10:00:00",
        "location": "New York",
        "name": "Tech World",
        "max_capacity": 100,
        "remaining_tickets": 98,
        "attended": [
            {
                "id": 1,
                "name": "John",
                "phone": "1234567890"
            },
            {
                "id": 2,
                "name": "Jane",
                "phone": "0987654321"
            }
        ]
    }
  ```

  #### Example Response (Event Not Found)
  ```sh
  {
      "status": "faild",
      "message": "Event not found.",
      "data": []
  }
  ```

  ### 2. Get Paginated List of Events

  Retrieves a paginated list of events with details, including remaining tickets and pagination metadata.

  - URL: `/events`
  - Method: `GET`
  - Query Parameters:
  - `page` (optional): The page number to retrieve (default: `1`).
  - `limit` (optional): The number of events per page (default: `5`).
  
  #### Example Request
  ```sh
  GET /api/v1/events?page=1&limit=5
  ```
  ### Example Response (Success)
  ```sh
    {
      "status": "success",
      "data": {
          "events": [
              {
                  "id": 1,
                  "name": "Tech World",
                  "slug": "tech-world",
                  "description": "A conference about technology.",
                  "date": "2023-12-15 10:00:00",
                  "location": "New York",
                  "max_capacity": 100,
                  "remaining_tickets": 98,
                  "status": "active",
                  "created_by": 1,
                  "created_by_name": "Admin",
                  "created_at": "2023-10-01 12:00:00",
                  "updated_at": "2023-10-01 12:00:00"
              },
              {
                  "id": 2,
                  "name": "Music Festival",
                  "slug": "music-festival",
                  "description": "Annual music festival.",
                  "date": "2023-11-20 18:00:00",
                  "location": "Los Angeles",
                  "max_capacity": 500,
                  "remaining_tickets": 450,
                  "status": "active",
                  "created_by": 1,
                  "created_by_name": "Admin",
                  "created_at": "2023-10-01 12:00:00",
                  "updated_at": "2023-10-01 12:00:00"
              }
          ],
          "pagination": {
              "current_page": 1,
              "total_pages": 10,
              "per_page": 5,
              "total_records": 50
          }
      }
  }
  ```

  ### Error Responses
  All endpoints return the following error structure in case of failure:

  ```sh
    {
      "status": "faild",
      "message": "Error message here.",
      "data": []
  }
  ```

  ### Response Codes
  - `200 OK`: The request was successful.
  - `404 Not Found`: The requested resource (e.g., event) was not found.
  - `500 Internal Server Error`: An unexpected error occurred on the server.

  ### Example Usage
  #### Fetch Event by ID
  ```sh
  curl -X GET "http://65.0.105.94/api/v1/event/1"
  ```
  #### Fetch Paginated Events

  ```sh
  curl -X GET "http://65.0.105.94/api/v1/events?page=1&limit=5"
  ```
</details>

---

# Project Installation Guide

This guide will help you set up and run a project on Docker, Windows, Ubuntu, and macOS.

## Prerequisites

Ensure you have the following installed:

- PHP (>=8.0 recommended)
- MySQL
- Apache/Nginx (or use PHP's built-in server)
- Composer

---

<details>
  <summary>Database</summary>
  
  #### Check databse in project root directory
  
  <img src="https://raw.githubusercontent.com/sagor-roy/event-management/main/public/assets/src/images/screenshot.jpg" width="100%">
</details>

---

<details>
  <summary>Installation on Docker</summary>
  
## Features
- **Apache Web Server** with PHP
- **MySQL Database** for storing event data
- **phpMyAdmin** for easy database management
- **Docker Compose** for effortless setup and deployment

## Setup Instructions

### 1️ **Clone the Repository**
```sh
 git clone https://github.com/sagor-roy/event-management.git
 cd your-repo
```
### 2. Configure `.env`

Copy `.env.example` to `.env` and paste.

```sh
APP_NAME = 'Event Management'
APP_ENV = local

DB_HOST = db #container name 
DB_NAME = 'events_management'
DB_USER = root
DB_PASS = 'plzletme!n' #change the password if needed

CAPTCHA_VISIBLE = 'true'
CAPTCHA_SITEKEY = 6Le6dAonAAAAAPZ2xjSKLAJyA4ST8nWLYE-YDZ3O
CAPTCHA_SECRET = 6Le6dAonAAAAALJtKx1jiPaE0SdHmQXLk_PIEtoJ
```
**Note:** Modify these values as needed but don't change `DB_HOST` name `db`.

### 3. Run the Project with Docker Compose
```sh
docker-compose up -d
```

**This will:**
- Build the `web` service (PHP + Apache)
- Start the `db` service (MySQL)
- Start `phpMyAdmin` for database access

### 4. Run the command and install `composer`
```sh
docker compose exec -it web /bin/bash --login -c "cd /var/www/html/ && composer install"
```

### 5. Access the Application
- Web Application: http://localhost:8000
- phpMyAdmin: http://localhost:8080
  - Username: `root`
  - Password: `plzletme!n`
  

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

CAPTCHA_VISIBLE = 'true'
CAPTCHA_SITEKEY = 6Le6dAonAAAAAPZ2xjSKLAJyA4ST8nWLYE-YDZ3O
CAPTCHA_SECRET = 6Le6dAonAAAAALJtKx1jiPaE0SdHmQXLk_PIEtoJ
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

CAPTCHA_VISIBLE = 'true'
CAPTCHA_SITEKEY = 6Le6dAonAAAAAPZ2xjSKLAJyA4ST8nWLYE-YDZ3O
CAPTCHA_SECRET = 6Le6dAonAAAAALJtKx1jiPaE0SdHmQXLk_PIEtoJ
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

CAPTCHA_VISIBLE = 'true'
CAPTCHA_SITEKEY = 6Le6dAonAAAAAPZ2xjSKLAJyA4ST8nWLYE-YDZ3O
CAPTCHA_SECRET = 6Le6dAonAAAAALJtKx1jiPaE0SdHmQXLk_PIEtoJ
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

### 6. Run PHP's Built-in Server

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
- If you want to disable Google Captcha, set `CAPTCHA_VISIBLE` = `false`
- Modify `config/database.php` as per your environment settings if needed.

---

## Hosting and Deployment

- Hosted on Amazon Web Service (AWS).
- Live project link: [http://65.0.105.94].
- Login credentials for testing:
  - **Login:** [http://65.0.105.94/login].
  - **Admin:** `admin@gmail.com` / **Password:** `plzalwme@2025`

## Support
#### For any issues or support, please contact [sagorroy204@gmail.com].
