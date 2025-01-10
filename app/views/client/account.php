<?php

require_once __DIR__.'/../partials/headerUser.php';
require_once __DIR__.'/../partials/sidebarUser.php';

$user = isset($data['user']) ? $data['user'] : null;
$accounts = isset($data['accounts']) ? $data['accounts'] : null;

?>

<div class="flex-1 p-8 mt-14">
    <div class="grid gap-6 md:grid-cols-2">
        <!-- Current Account -->
        <?php foreach ($accounts as $account): ?>
            <div class="account-card bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-center">
                        <div class="space-y-1">
                            <h3 class="text-xl font-semibold text-gray-800">Account <?php echo $account["account_type"] ?></h3>
                            <p class="text-sm text-gray-500 font-mono">EG76 1234 5600 9012</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-gray-900">€<?php echo $account["balance"] ?></p>
                            <?php
                                if ($account["status"] == "active") {
                                    echo
                                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 animate-pulse">
                                        Active
                                    </span>';
                                } else if ($account["status"] == "inactive") {
                                    echo
                                    '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Bloqué
                                    </span>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <?php if($account['status'] == 'active'): ?>
                            <a href="/user/deposit?id=<?= $account['id'] ?>" class="group flex items-center justify-center p-3 text-violet-600 border border-violet-600 rounded-lg transition-all duration-200 hover:bg-violet-600 hover:text-white bg-violet-500 text-white">
                                <i data-lucide="plus-circle" class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:rotate-90"></i>
                                Deposit
                            </a>
                        <?php else: ?>
                            <button disabled class="group flex items-center justify-center p-3 text-gray-400 border border-gray-400 rounded-lg cursor-not-allowed opacity-50">
                                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                                Deposit
                            </button>
                        <?php endif; ?>
                        <?php if($account['status'] == 'active'): ?>
                            <a href="/user/withdraw?id=<?= $account['id'] ?>" class="group flex items-center justify-center p-3 text-violet-600 border border-violet-600 rounded-lg transition-all duration-200 hover:bg-violet-600 hover:text-white bg-violet-500 text-white">
                                <i data-lucide="plus-circle" class="w-5 h-5 mr-2 transition-transform duration-200 group-hover:rotate-90"></i>
                                <?php echo ($account['account_type'] == 'epargne') ? 'Transfer' : 'Withdraw'; ?>
                            </a>
                        <?php else: ?>
                            <button disabled class="group flex items-center justify-center p-3 text-gray-400 border border-gray-400 rounded-lg cursor-not-allowed opacity-50">
                                <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                                <?php echo ($account['account_type'] == 'epargne') ? 'Transfer' : 'Withdraw'; ?>
                            </button>
                        <?php endif; ?>
                        

                    </div>
                    <!-- Account details with hover effect -->
                    <div class="pt-6 border-t border-gray-100">
                        <h4 class="font-medium text-gray-700 mb-4">Account Details</h4>
                        <dl class="grid grid-cols-2 gap-4">
                            <!-- Detail items with hover effect -->
                            <div class="p-3 rounded-lg transition-colors duration-200 hover:bg-gray-50">
                                <dt class="text-sm text-gray-500">Opening Date</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900"><?= $account["created_at"] ?></dd>
                            </div>
                            <!-- Add similar styling to other detail items -->
                        </dl>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <!-- Savings Account - Similar styling -->
    </div>
</div>

<?php
    require_once __DIR__.'/../partials/footer.php';
 
?>

