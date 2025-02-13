# WebInn: Step-by-Step Setup Guide

### Prerequisites

Make sure you have the following installed on your system:
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [Git](https://git-scm.com/)
- [XAMPP](https://www.apachefriends.org/) or similar for local server environment.

### Clone the Repository

1. Open your terminal (Git Bash or CMD).
2. Verify installations:
   ```bash
   composer --version
   npm --version
   git --version
   ```
3. Set up your Git credentials:
   ```bash
   git config --global user.name "Your Name"
   git config --global user.email "your@example.com"
   ```

4. Clone the repository:
   ```bash
   git clone https://github.com/aldrin112602/Web-Ed.git
   ```

### Setup Project in VS Code

1. Navigate to the project directory:
   ```bash
   code Web-Ed
   ```
   This will open VS Code with your project.

2. Open a terminal in VS Code and follow these steps.

### Install Dependencies

#### Composer (PHP)

Install PHP dependencies:
```bash
composer install
```

#### Node.js (JavaScript)

Install JavaScript dependencies:
```bash
npm install
```

### Configure Storage

Set up symbolic link for storage:
```bash
php artisan storage:link
```

### Start Local Server

1. Start PHP server (first terminal):
   ```bash
   npm run serve
   ```

2. Compile assets with Node.js (second terminal):
   ```bash
   npm run dev
   ```

### XAMPP Configuration

Ensure Apache and MySQL are running in XAMPP.

### Database Migration

Run migrations to set up your database:
```bash
npm run migrate
```

### Run the Seeder

Run the seeder to populate the database with the new data:

```bash
npm run seed
```
