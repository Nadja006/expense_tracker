Expense Tracker

A simple web application for tracking personal income and expenses.

About the Project

Expense Tracker allows users to manage their personal transactions in one place.
Users can create an account, log in, add and edit transactions, and view an overview of their financial activity.

Features

User registration and login;
Session-based authentication;
Add income and expenses;
Edit transactions;
View transaction history;
Personal statistics;
Total income;
Total expenses;
Current balance;
Number of transactions;
Top category;
Biggest expense;
Recent transactions

Technologies

PHP 8.2
MySQL / MariaDB
HTML5
CSS3
Apache
XAMPP

Project Structure

The project follows the MVC (Model-View-Controller) architecture.
Models – database queries and data handling;
Views – user interface;
Controllers – application logic

Database

The application uses a relational database containing users, categories and transactions.
Each transaction is connected to a specific user and category.

Getting Started

The project can be run locally using XAMPP.
Clone the repository.
Place the project inside the XAMPP htdocs folder.
Create the expense_tracker database.
Configure the local database connection.
Start Apache and MySQL/MariaDB.
Open the project in your browser.

Security

Passwords are hashed using PHP's password_hash().
Password verification is handled with password_verify().
Database credentials are excluded from the repository.
User data is separated using session-based authentication.

Future Improvements

Search and filtering;
Monthly reports;
Charts and data visualization;
Responsive design

Author

Nadja Stojanovic |
GitHub: Nadja006
