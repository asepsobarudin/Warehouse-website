
# Warehouse Stocks Project

## Introduction
Warehouse Stocks is a web-based application designed to manage warehouse inventory efficiently. This project utilizes the Shop Cashier Website repository as its foundation.

## Getting Started

### 1. Clone Repository
Clone the Warehouse Stocks repository using the following command:
```bash
git clone https://github.com/asepsobarudin/Shop_Cashier_Website
```

### 2. Open Folder in Code Editor
Navigate to the cloned repository and open the folder in your preferred code editor.

### 3. Install Dependencies
Open the terminal and run the following commands to install the necessary dependencies:
```bash 
composer update 
```
``` bash
npm install
```

### 4. Configure Environment
Rename the .env.example file to .env. Open the .env file and configure the database connection settings.
``` bash
database.default.hostname = 127.0.0.1
database.default.database = db_toko //database name
database.default.username = root
database.default.password = //database password
database.default.DBDriver = MySQLi
#database.default.DBPrefix =
database.default.port = 3306
```

### 5. Migrate and Seed Database
Run the following commands in the terminal to migrate the database and seed the Goods table:
```bash
php spark migrate
```
or if a database has been created:
```bash
php spark migrate:refresh
```

Optional if you want to add data automatically:
```bash
php spark db:seed Goods
```

### 6. Run Server and UI
Start the PHP development server and build the UI by executing the following commands:
```bash 
php spark serve
```
#### for development :
```bash 
npm run dev
```

### 7. Completion
The Warehouse Stocks project is now set up and running. Access the application at the specified address, and you're ready to manage your warehouse inventory.
