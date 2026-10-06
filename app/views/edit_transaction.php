<div id="add-transaction">
    <h1>Edit Transaction</h1>
    <form action="index.php?page=edit_transaction" method="POST">
        <input type="hidden" name="transaction_id" value="<?= $update_transaction['transaction_id'] ?>">
        <label>Type:</label>
        <select name="type">
            <option value="income" <?= $update_transaction['type'] == 'Income' ? 'selected' : '' ?>>Income</option>
            <option value="expense" <?= $update_transaction['type'] == 'Expense' ? 'selected' : '' ?>>Expense</option>
        </select><br>
        <label>Category:</label>
        <select name="category_id">
            <option value="1" <?= $update_transaction['category_name'] == 'Salary' ? 'selected' : '' ?>>Salary</option>
            <option value="2" <?= $update_transaction['category_name'] == 'Food' ? 'selected' : '' ?>>Food</option>
            <option value="3" <?= $update_transaction['category_name'] == 'Car' ? 'selected' : '' ?>>Car</option>
            <option value="4" <?= $update_transaction['category_name'] == 'Shopping' ? 'selected' : '' ?>>Shopping</option>
        </select><br>
        <input type="number" name="amount" placeholder="Amount" value="<?= $update_transaction['amount'] ?>"><br>
        <input type="text" name="description" placeholder="Description" maxlength="255" value="<?= htmlspecialchars($update_transaction['description']) ?>"><br>
        <button type="submit">Update transaction</button>
    </form>
</div>