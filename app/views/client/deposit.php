<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';


?>

<div class="flex-1 p-8 mt-14">
    <h1 class="text-2xl font-bold mb-4">Deposit</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <?php if(isset($_SESSION['errors'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php 
                    foreach($_SESSION['errors'] as $error) {
                        echo $error . '<br>';
                    }
                    unset($_SESSION['errors']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="/user/deposit" method="POST" class="space-y-4">
                <div>
                    <label for="account" class="block text-sm font-medium text-gray-700">Choose Account</label>
                    <select name="account_id" id="account" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <?php foreach($accounts as $account): ?>
                            <option value="<?= $account['id'] ?>">
                                Account <?= $account['id'] ?> (<?= ucfirst($account['account_type']) ?>) - Balance: <?= $account['balance'] ?> DH
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount (DH)</label>
                    <input type="number" name="amount" id="amount" required min="1" step="0.01"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Deposit Money
                </button>
            </form>
        </div>
    </div>
</div>

<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>

