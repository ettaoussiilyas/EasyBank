<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';

//get id account from url

$account = isset($data['account']) ? $data['account'] : null;
$error = isset($data['error']) ? $data['error'] : null;


?>

<div class="flex-1 p-8 mt-14">

        <?php if ($error) { ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php } ?>

        <!-- Withdrawal form -->
        <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Withdrawal Form</h2>
        <!-- account type -->
        <p class="text-sm text-gray-500 mb-4">Compte : <?= $account['account_type'] ?></p>
        <p class="text-sm text-gray-500 mb-4">Solde : <?= $account['balance'] ?></p>
        <p class="text-sm text-gray-500 mb-4">Retirer de votre compte</p>
        
        <form method="POST" action="/user/withdraw" class="space-y-6">
            <input type="hidden" name="id_account" value="<?= $data['account']['id'] ?>">
            
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input 
                    type="number" 
                    name="amount" 
                    id="amount" 
                    min="10" 
                    step="0.01" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description (optional)</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                ></textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/user/account" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <?php echo ($account['account_type'] == 'epargne') ? 'Transfer' : 'Withdraw'; ?>
                </button>
            </div>
        </form>
    </div>

</div>

<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>