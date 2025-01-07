<?php 
$title = "Rapports Financiers | Admin";
require_once(__DIR__ . '/../partials/header.php'); 
require_once(__DIR__ . '/../partials/sidebar.php'); 
?>

<!-- Content -->
<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Rapports Financiers</h2>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-gray-500 text-sm mb-2">Total des Dépôts</h3>
                <p class="text-2xl font-bold text-green-600">150,000 €</p>
                <p class="text-sm text-gray-400 mt-2">+12% ce mois</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-gray-500 text-sm mb-2">Total des Retraits</h3>
                <p class="text-2xl font-bold text-red-600">75,000 €</p>
                <p class="text-sm text-gray-400 mt-2">-5% ce mois</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-gray-500 text-sm mb-2">Solde Global</h3>
                <p class="text-2xl font-bold text-violet-600">275,000 €</p>
                <p class="text-sm text-gray-400 mt-2">+7% ce mois</p>
            </div>
        </div>

        <!-- Transactions Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Évolution des Transactions</h3>
            <div class="h-64 bg-gray-50 rounded">
                <div class="flex items-center justify-center h-full text-gray-400">
                    Graphique des transactions
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 