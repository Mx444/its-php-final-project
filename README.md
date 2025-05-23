# PHP Final Project - ITS Steve Jobs Academy

This repository contains a PHP project developed during the course at ITS Steve Jobs Academy. The project implements a web application with user management and authentication functionality.

## Repository Structure

The repository is organized into thematic folders:

- **setup/**: Initial configuration
  - Database setup
  - Initialization scripts

- **database/**: Database management
  - User manipulation functions
  - CRUD operations (Create, Read, Update, Delete)
  - Connection configuration

- **frontend/**: User interface
  - Login page
  - Dashboard
  - Support functions
  - Session management

- **project/**: MVC implementation
  - **controller/**: Application logic management
  - **model/**: Data model definitions
  - **view/**: Templates and presentation
  - **config/**: General configurations

## Main Features

- User authentication
- User profile management
- Administrative dashboard
- CRUD operations on users

## How to Use the Project

### Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Installation

1. Clone the repository:
```bash
git clone https://github.com/your-username/its-php-final-project.git
```

2. Configure the database:
```bash
cd its-php-final-project/setup
php db_config.php
```

3. Start the web server and navigate to the project address.

## Feature Examples

### User Management
```php
// Creating a new user
createUser('username', 'email@example.com', 'password');

// Retrieving all users
$users = getUsers();

// Updating a user
updateUser(1, 'new_username');

// Deleting a user
deleteUser(1);
```

### Authentication
```php
// User login
// Implemented in login.php

// User logout
// Implemented in logout.php
```

## Project Architecture

The project follows the Model-View-Controller (MVC) architectural pattern:

- **Model**: Manages data access and business logic
- **View**: Presents data to the user
- **Controller**: Coordinates interactions between Model and View

## Educational Objectives

This project was designed to:
- Understand the fundamental concepts of PHP programming
- Develop database management skills
- Apply the MVC pattern in a practical context
- Implement authentication and authorization features

## Technical Requirements

- PHP 7.4+
- MySQL/MariaDB
- Basic knowledge of HTML/CSS
- Understanding of object-oriented programming concepts

---

*This repository was created as part of the educational journey at ITS Steve Jobs Academy.*