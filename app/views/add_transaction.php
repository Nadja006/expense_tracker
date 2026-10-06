<div id="add-transaction">
    <h1>Add Transaction</h1>
    <form action="index.php?page=add_transaction" method="POST">
        <label>Type:</label>
        <select name="type">
            <option value="income">Income</option>
            <option value="expense">Expense</option>
        </select><br>
        <label>Category:</label>
        <select name="category">
            <option value="salary">Salary</option>
            <option value="food">Food</option>
            <option value="car">Car</option>
            <option value="shopping">Shopping</option>
        </select><br>
        <input type="number" name="amount" placeholder="Amount"><br>
        <input type="text" name="description" placeholder="Description" maxlength="255"><br>
        <button type="submit">+ Add transaction</button>
    </form>
</div>