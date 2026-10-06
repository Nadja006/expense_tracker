<?php if(isset($_SESSION['user_id'])): ?>

    <div id="transactions-page">
        <div id="transactions-page-heading">
            <img src="/expense_tracker/assets/images/payment-done.png" alt="Transactions">
            <h1>My Transactions</h1>
        </div>

        <table id="transactions-table">
            <tr id="table-header">
                <th>Date</th>
                <th>Type</th>
                <th>Category</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        <?php foreach($transactions as $transaction): ?>
             <tr id="table-rows">
                <td><?= $transaction['date'] ?></td>
                <td><?= $transaction['type'] ?></td>
                <td><?= htmlspecialchars($transaction['category_name']) ?></td>
                <td><?= htmlspecialchars($transaction['description']) ?></td>
                <td><?= $transaction['amount'] ?> RSD</td>
                <td id="actions">
                    <form action="index.php?page=edit_transaction" method="POST">
                        <input type="hidden" name="transaction_id" value="<?= $transaction['transaction_id'] ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form action="index.php?page=delete_transaction" method="POST">
                        <input type="hidden" name="transaction_id" value="<?= $transaction['transaction_id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>

        <a href="index.php?page=home"><- Back to Dashboard</a>
    </div>
<?php else:
    header("Location: index.php?page=login");
    exit;
    endif; 
?>
