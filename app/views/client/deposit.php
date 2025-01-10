<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';


?>

<div class="flex-1 p-8 mt-14">
    <?php if ($error) { ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $error; ?></span>
        </div>
    <?php } ?>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Deposit Form</h2>
        
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
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

        <form action="/user/deposit" method="POST" class="space-y-6">
            <div>
                <label for="account" class="block text-sm font-medium text-gray-700">Choose Account</label>
                <select name="account_id" id="account" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <?php foreach($accounts as $account): ?>
                        <option value="<?= $account['id'] ?>">
                            Account <?= $account['id'] ?> (<?= ucfirst($account['account_type']) ?>) - Balance: <?= $account['balance'] ?> DH <?php if($account['status'] == 'inactive') { echo ' (Bloqué)'; } ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (DH)</label>
                <input type="number" name="amount" id="amount" required min="1" step="0.01"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/user/account" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Deposit Money
                </button>
            </div>
        </form>
    </div>
</div>

<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>

