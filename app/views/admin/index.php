<?php 
$title = "Dashboard Admin | EasyBank";
require_once(__DIR__ . '/../partials/header.php'); 
require_once(__DIR__ . '/../partials/sidebar.php'); 
?>

<!-- Content -->
<div class="flex-1 p-8 mt-14">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h2>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Clients -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-violet-100 bg-opacity-75">
                        <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Clients</h3>
                        <p class="text-2xl font-bold text-gray-800">1,482</p>
                        <p class="text-sm text-green-500">+12% ce mois</p>
                    </div>
                </div>
            </div>

            <!-- Comptes Actifs -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 bg-opacity-75">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Comptes Actifs</h3>
                        <p class="text-2xl font-bold text-gray-800">3,274</p>
                        <p class="text-sm text-green-500">+8% ce mois</p>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Transactions</h3>
                        <p class="text-2xl font-bold text-gray-800">12,821</p>
                        <p class="text-sm text-blue-500">+23% ce mois</p>
                    </div>
                </div>
            </div>

            <!-- Solde Total -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-violet-100 bg-opacity-75">
                        <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Solde Total</h3>
                        <p class="text-2xl font-bold text-gray-800">275,000 €</p>
                        <p class="text-sm text-green-500">+7% ce mois</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Latest Transactions -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold">Dernières Transactions</h3>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Dépôt - Jean Dupont</p>
                                <p class="text-sm text-gray-500">Il y a 2 heures</p>
                            </div>
                            <span class="text-green-600 font-semibold">+1,500 €</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Retrait - Marie Martin</p>
                                <p class="text-sm text-gray-500">Il y a 3 heures</p>
                            </div>
                            <span class="text-red-600 font-semibold">-500 €</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">Transfert - Pierre Durand</p>
                                <p class="text-sm text-gray-500">Il y a 5 heures</p>
                            </div>
                            <span class="text-violet-600 font-semibold">2,000 €</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Accounts -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-semibold">Nouveaux Comptes</h3>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">JD</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">Jean Dupont</p>
                                <p class="text-sm text-gray-500">Compte Courant</p>
                            </div>
                            <span class="ml-auto text-green-600">Actif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">MM</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">Marie Martin</p>
                                <p class="text-sm text-gray-500">Compte Épargne</p>
                            </div>
                            <span class="ml-auto text-green-600">Actif</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-600 font-semibold">PD</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold">Pierre Durand</p>
                                <p class="text-sm text-gray-500">Compte Courant</p>
                            </div>
                            <span class="ml-auto text-green-600">Actif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 