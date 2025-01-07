<?php 
$title = "Gestion des Comptes Clients | Admin";
require_once(__DIR__ . '/../partials/header.php'); 
require_once(__DIR__ . '/../partials/sidebar.php'); 
?>

<!-- Content -->
<div class="flex-1 p-8 mt-16">
    <div class="max-w-7xl mx-auto">
        <!-- Header avec recherche -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Comptes Clients</h2>
            <div class="flex gap-4">
                <!-- Barre de recherche -->
                <form method="GET" action="/admin/accounts" class="flex gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher un client..." 
                           class="px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <button type="submit" 
                            class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                        Rechercher
                    </button>
                </form>
                <!-- Bouton Nouveau Compte -->
                <button class="bg-violet-600 text-white px-4 py-2 rounded hover:bg-violet-700">
                    + Nouveau Compte
                </button>
            </div>
        </div>

        <!-- Clients Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type de Compte</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Solde</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4">Jean Dupont</td>
                        <td class="px-6 py-4">jean.dupont@email.com</td>
                        <td class="px-6 py-4">Courant</td>
                        <td class="px-6 py-4">1500 €</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Actif</span>
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-violet-600 hover:text-violet-800 mr-2">Modifier</button>
                            <button class="text-red-600 hover:text-red-800">Désactiver</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . '/../partials/footer.php'); ?> 