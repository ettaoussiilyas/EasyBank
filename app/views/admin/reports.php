<?php 
$title = "Financial Reports | Admin";
require_once(__DIR__ . '/../partials/header.php'); 
require_once(__DIR__ . '/../partials/sidebar.php'); 
?>

<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Financial Reports</h2>
            <p class="text-gray-600">Overview of global transactions and balances</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Deposits -->
            <div class="bg-white rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="rounded-full p-3 bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-700">Total Deposits</h3>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-green-600"><?= number_format($totaldeposit ?? 0, 2) ?> €</p>
                </div>
                <p class="mt-3 text-sm text-gray-500">All time customer deposits</p>
            </div>

            <!-- Total Withdrawals -->
            <div class="bg-white rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="rounded-full p-3 bg-red-100">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-700">Total Withdrawals</h3>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-red-600"><?= number_format($totalwithdrawal ?? 0, 2) ?> €</p>
                </div>
                <p class="mt-3 text-sm text-gray-500">All time customer withdrawals</p>
            </div>

            <!-- Global Balance -->
            <div class="bg-white rounded-lg shadow-lg p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="rounded-full p-3 bg-violet-100">
                            <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-700">Global Balance</h3>
                    </div>
                </div>
                <div class="flex items-baseline">
                    <p class="text-3xl font-bold text-violet-600"><?= number_format($totalBalance ?? 0, 2) ?> €</p>
                </div>
                <p class="mt-3 text-sm text-gray-500">Total balance across all accounts</p>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700">Monthly Transaction History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deposits</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Withdrawals</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Flow</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($monthlyStats)): ?>
                            <?php foreach ($monthlyStats as $stat): ?>
                                <?php 
                                    $netFlow = $stat['deposits'] - $stat['withdrawals'];
                                    $netFlowColor = $netFlow >= 0 ? 'text-green-600' : 'text-red-600';
                                    $month = date('F Y', strtotime($stat['month'] . '-01'));
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= $month ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                        <?= number_format($stat['deposits'], 2) ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        <?= number_format($stat['withdrawals'], 2) ?> €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm <?= $netFlowColor ?>">
                                            <?= number_format($netFlow, 2) ?> €
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No transaction history available
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 