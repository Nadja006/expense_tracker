<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

//Configuration
require_once "config/database.php";

//Controllers
require_once "app/controllers/TrackerController.php";

//Instance
$trackerController = new TrackerController($conn);

$page = $_GET['page'] ?? 'register';

require_once "includes/header.php"; 
switch($page){
    case "register":
        require_once "app/views/register.php";
        $trackerController->register();
        break;
    case "login":
        require_once "app/views/login.php";
        $trackerController->login();
        break;
    case "home":
        $total_income = $trackerController->showTotalIncome();
        $total_expense = $trackerController->showTotalExpense();
        $balance = $trackerController->showBalance($total_income, $total_expense);
        $number_transactions = $trackerController->showNumberOfTransactions();
        $category_name = $trackerController->showTopCategory();
        $biggest_expense = $trackerController->showBiggestExpense();
        $recent_transactions = $trackerController->showRecentTransactions();
        require_once "app/views/home.php";
        break;
    case "logout":
        $trackerController->logout();
        break;
    case "add_transaction":
        require_once "app/views/add_transaction.php";
        $trackerController->addTransaction();
        break;
    case "transactions":
        $transactions = $trackerController->showTransaction();
        require_once "app/views/transactions.php";
        break;
    case "edit_transaction":
        if(isset($_POST['type'])){
            $trackerController->updateTransaction();
        } 
        else {
            $update_transaction = $trackerController->showTransactionById();
            require_once "app/views/edit_transaction.php";
        }
        break;
    case "delete_transaction":
        $trackerController->deleteTransaction();
        break;
    }
require_once "includes/footer.php"; 
?>