<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Transaction.php";

class TrackerController{
    
    private $user;
    private $transaction;

    public function __construct($db){
        $this->user = new User($db);
        $this->transaction = new Transaction($db);
    }

    public function register(){
        if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['email']) && !empty($_POST['email'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            if($this->user->userExists($username, $email)){
                echo "<p class='message'>Username or email already exists.</p>";
            }
            else{
                $usernamePattern = "/^[a-z]{4,16}$/";
                $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&]).{5,15}$/";

                if(preg_match($usernamePattern, $username) && preg_match($passwordPattern, $password) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $this->user->registerUser($username, password_hash($password, PASSWORD_DEFAULT), $email);
                    header("Location: index.php?page=login");
                    exit;
                }
                else if(!preg_match($usernamePattern, $username)){
                    echo "<p class='message'>Username must contain only lowercase letters and be 4-16 characters long.</p>";
                }
                else if(!preg_match($passwordPattern, $password)){
                    echo "<p class='message'>Password must contain at least one uppercase letter, <br>one lowercase letter, one number and one special character.</p>";
                }
                else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    echo "<p class='message'>Please enter a valid email address.</p>";
                }
            }
        }
        
    }

    public function login(){
        if(isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['password']) && !empty($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->user->getUserByUsername($username);

            if($user && password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php?page=home");
                exit;
            }
            else{
                echo "<p class='message'>This user does not exist.</p>";
            }
        }
    }

    public function logout(){
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }

    public function addTransaction(){
        if(isset($_POST['type']) && isset($_POST['category']) && isset($_POST['amount']) &&  isset($_POST['description'])){

            $type = $_POST['type'];
            $category = $_POST['category'];
            $amount = $_POST['amount'];
            $description = strip_tags($_POST['description']);

            if(empty($type) || empty($category) || empty($amount) || empty($description)){
                echo "<p class='message'>Please complete all required fields before adding a transaction.</p>";
            }
            else if(!is_numeric($amount)){
                echo "<p class='message'>Amount must be a number.</p>";
            }
            else if($amount <= 0){
                echo "<p class='message'>Amount must be greater than 0.</p>";
            }
            else{
                $user_id = $_SESSION['user_id'];
                $category_id = $this->transaction->getCategoryId($category);

                if($category_id === null){
                    echo "<p class='message'>Invalid category.</p>";
                }
                else{
                    $this->transaction->newTransaction($user_id, $category_id, $type, $amount, $description);

                    header("Location: index.php?page=home");
                    exit;
                }
            }
        }

    }

    public function showTransaction(){
        $user_id = $_SESSION['user_id'];
        $transactions = $this->transaction->getTransactionByUser($user_id);

        return $transactions;
    }

    public function showRecentTransactions(){
        $user_id = $_SESSION['user_id'];
        $recent_transactions = $this->transaction->getRecentTransactions($user_id);

        return $recent_transactions;
    }

    public function showTotalIncome(){
        $user_id = $_SESSION['user_id'];
        $total_income = $this->transaction->getTotalIncome($user_id);

        return $total_income;
    }

    public function showTotalExpense(){
        $user_id = $_SESSION['user_id'];
        $total_expense = $this->transaction->getTotalExpense($user_id);

        return $total_expense;
    }

    public function showBalance($total_income, $total_expense){
        $user_id = $_SESSION['user_id'];

        $balance = $total_income - $total_expense;

        return $balance;
    }

    public function showNumberOfTransactions(){
        $user_id = $_SESSION['user_id'];
        $number_transactions = $this->transaction->getNumberOfTransactions($user_id);

        return $number_transactions;
    }

    public function showTopCategory(){
        $user_id = $_SESSION['user_id'];
        $category_name = $this->transaction->getTopCategory($user_id);

        return $category_name;
    }

    public function showBiggestExpense(){
        $user_id = $_SESSION['user_id'];
        $biggest_expense = $this->transaction->getBiggestExpense($user_id);

        return $biggest_expense;
    }

    public function showTransactionById(){
        $user_id = $_SESSION['user_id'];
        $transaction_id = $_POST['transaction_id'];
        $update_transaction = $this->transaction->getTransactionById($user_id, $transaction_id);

        return $update_transaction;
    }

    public function updateTransaction(){
        if(isset($_POST['type']) && isset($_POST['category_id']) && isset($_POST['amount']) &&  isset($_POST['description'])){
            $type = $_POST['type'];
            $category_id = $_POST['category_id'];
            $amount = $_POST['amount'];
            $description = strip_tags($_POST['description']);
            $user_id = $_SESSION['user_id'];
            $transaction_id = $_POST['transaction_id'];


            $this->transaction->updateTransaction($type, $category_id, $amount, $description, $user_id, $transaction_id);
            header("Location: index.php?page=transactions");
            exit;
        }
    }

    public function deleteTransaction(){
        if(isset($_POST['transaction_id'])){
            $user_id = $_SESSION['user_id'];
            $transaction_id = $_POST['transaction_id'];

            $this->transaction->deleteTransaction($user_id, $transaction_id);
            header("Location: index.php?page=transactions");
            exit;
        }
    }
}

?>