<?php

class Transaction{

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function newTransaction($user_id, $category_id, $type, $amount, $description){
        $stmt = $this->conn->prepare("INSERT INTO transactions (user_id, category_id, type, amount, description, date) VALUES (?, ?, ?, ?, ?, CURDATE())");
        $stmt->bind_param("iisds", $user_id, $category_id, $type, $amount, $description);
        if(!$stmt->execute()){
            die($stmt->error);
        }
        $stmt->close();
    }

    public function getCategoryId($category){
        $stmt = $this->conn->prepare("SELECT category_id FROM categories WHERE category_name=?");
        $stmt->bind_param("s", $category);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        if(!$result){
            return null;
        }

        $category_id = $result['category_id'];

        $stmt->close();

        return $category_id;
    }

    public function getTransactionByUser($user_id){
        $stmt = $this->conn->prepare("SELECT transactions.*, categories.category_name 
                                      FROM transactions 
                                      JOIN categories
                                      ON transactions.category_id = categories.category_id
                                      WHERE transactions.user_id=? 
                                      ORDER BY transactions.transaction_id DESC");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result();

        $transactions = [];

        while($row = $result->fetch_assoc()){
            $transactions[] = $row;
        }

        $stmt->close();

        return $transactions;
    }

    public function getRecentTransactions($user_id){
        $stmt = $this->conn->prepare("SELECT transactions.*, categories.category_name
                                      FROM transactions 
                                      JOIN categories
                                      ON transactions.category_id = categories.category_id
                                      WHERE transactions.user_id=?
                                      ORDER BY transactions.transaction_id DESC
                                      LIMIT 3");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result();
        
        $recent_transactions = [];

        while($row = $result->fetch_assoc()){
            $recent_transactions[] = $row;
        }

        $stmt->close();

        return $recent_transactions;
    }

    public function getTotalIncome($user_id){
        $stmt = $this->conn->prepare("SELECT SUM(amount) AS total_income
                                      FROM transactions 
                                      WHERE transactions.user_id=? 
                                      AND type = 'Income' ");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $total_income = $result['total_income'];

        $stmt->close();

        return $total_income;
    }

    public function getTotalExpense($user_id){
        $stmt = $this->conn->prepare("SELECT SUM(amount) AS total_expense
                                      FROM transactions 
                                      WHERE transactions.user_id=? 
                                      AND type = 'Expense' ");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $total_expense = $result['total_expense'];

        $stmt->close();

        return $total_expense;
    }

    public function getNumberOfTransactions($user_id){
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS number_transactions
                                      FROM transactions 
                                      WHERE transactions.user_id=?");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $number_transactions = $result['number_transactions'];

        $stmt->close();

        return $number_transactions;
    }

    public function getTopCategory($user_id){
        $stmt = $this->conn->prepare("SELECT categories.category_name, COUNT(*) AS transactions_count
                                      FROM transactions 
                                      JOIN categories
                                      ON transactions.category_id = categories.category_id
                                      WHERE transactions.user_id=? 
                                      GROUP BY categories.category_id
                                      ORDER BY transactions_count DESC
                                      LIMIT 1");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        if($result){
            $category_name = $result['category_name'];
        } 
        else {
            $category_name = "No transactions";
        }

        $stmt->close();

        return $category_name;
    }

    public function getBiggestExpense($user_id){
        $stmt = $this->conn->prepare("SELECT transactions.amount, transactions.description
                                      FROM transactions
                                      WHERE transactions.user_id = ?
                                      AND type = 'Expense'
                                      ORDER BY transactions.amount DESC
                                      LIMIT 1");
        $stmt->bind_param("i", $user_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $result;
    }

    public function getTransactionById($user_id, $transaction_id){
        $stmt = $this->conn->prepare("SELECT transactions.*, categories.category_name
                                      FROM transactions 
                                      JOIN categories
                                      ON transactions.category_id = categories.category_id
                                      WHERE transactions.user_id=?
                                      AND transactions.transaction_id=?");
        $stmt->bind_param("ii", $user_id, $transaction_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();

        return $result;
    }

    public function updateTransaction($type, $category_id, $amount, $description, $user_id, $transaction_id){
        $stmt = $this->conn->prepare("UPDATE transactions
                                      SET type = ?,
                                      category_id = ?,
                                      amount = ?,
                                      description = ? 
                                      WHERE transactions.user_id=?
                                      AND transactions.transaction_id=?");
        $stmt->bind_param("sidsii", $type, $category_id, $amount, $description, $user_id, $transaction_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }
        $stmt->close();
    }

    public function deleteTransaction($user_id, $transaction_id){
        $stmt = $this->conn->prepare("DELETE FROM transactions
                                      WHERE transactions.user_id=?
                                      AND transactions.transaction_id=?");
        $stmt->bind_param("ii", $user_id, $transaction_id);
        if(!$stmt->execute()){
            die($stmt->error);
        }
        $stmt->close();
    }
}

?>