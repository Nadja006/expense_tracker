<?php if(isset($_SESSION['user_id'])): ?>

    <div id="app">
        
        <div id="body-header">

            <h1>Expense Tracker</h1>

            <div>
                <h2><?= $_SESSION['username'] ?></h2>
                <form action="index.php?page=logout" method="POST">
                <button type="submit">Logout</button>
                </form>
            </div>

        </div>

        <div id="body">

            <div id="body-sidebar">
                <a href="index.php?page=home">Dashboard</a>
                <a href="index.php?page=transactions">Transactions</a>
                <form action="index.php?page=logout" method="POST">
                    <button type="submit">Logout</button>
                </form>
            </div>

            <div id="body-central">

                <div>
                    <h2>Welcome, <?= $_SESSION['username'] ?></h2>
                    <h4>Here's your financial overview.</h4>
                </div>

                <div id="body-boxes">

                    <div class="body-box">
                        <div class="body-box-heading">
                            <img src="/expense_tracker/assets/images/cost.png" alt="Balance">
                            <h2>Balance</h2>
                        </div>
                        <h1><?= $balance ?> RSD</h1>
                    </div>

                    <div class="body-box">
                        <div class="body-box-heading">
                            <img src="/expense_tracker/assets/images/money-bag.png" alt="Income">
                            <h2>Total Income</h2>
                        </div>
                        <h1>+ <?= $total_income ?> RSD</h1>
                    </div>

                    <div class="body-box">
                        <div class="body-box-heading">
                            <img src="/expense_tracker/assets/images/accounts.png" alt="Expense">
                            <h2>Total Expenses</h2>
                        </div>
                        <h1>- <?= $total_expense ?> RSD</h1>
                    </div>

                </div>

                <div id="transactions">

                    <div id="recent-transactions">

                        <div class="recent-transactions-boxes">
                            <h3>Personal Statistics</h3>

                            <div class="statistics">
                                <h4>Total Transactions</h4>
                                <p><?= $number_transactions ?></p>
                            </div>

                            <div class="statistics">
                                <h4>Top Category</h4>
                                <p><?= $category_name ?></p>
                            </div>

                            <div class="statistics">
                                <h4>Biggest Expense</h4>
                                <?php if($biggest_expense): ?>
                                    <p><?= $biggest_expense['amount'] ?> - <?= htmlspecialchars($biggest_expense['description']) ?></p>
                                <?php else: ?>
                                    <p>No transactions</p>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div class="recent-transactions-boxes">
                            <h3>Recent Transactions</h3>
                            <table id="home-table">
                                <tr id="table-header">
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            <?php foreach($recent_transactions as $recent_transaction): ?>
                                <tr id="table-rows">
                                    <td><?= $recent_transaction['date'] ?></td>
                                    <td><?= $recent_transaction['type'] ?></td>
                                    <td><?= htmlspecialchars($recent_transaction['category_name']) ?></td>
                                    <td><?= htmlspecialchars($recent_transaction['description']) ?></td>
                                    <td><?= $recent_transaction['amount'] ?> RSD</td>
                                </tr>
                            <?php endforeach; ?>
                            </table>
                            <a href="index.php?page=transactions">Show more...</a>
                        </div>

                    </div>

                    <form action="index.php?page=add_transaction" method="POST">
                        <button type="submit">+ Add transaction</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
<?php else:
    header("Location: index.php?page=login");
    exit;
    endif; 
?>