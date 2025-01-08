<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'EasyBank Admin' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/js/alerts.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-violet-600 text-white shadow-lg absolute w-full z-10">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">EasyBank Admin</h1>
                <div class="space-x-4">
                    <a href="/admin/accounts" class="hover:text-violet-200">Comptes</a>
                    <a href="/admin/reports" class="hover:text-violet-200">Rapports</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Ajout d'un div pour créer l'espace sous la navbar -->
    <div class="">
        <div class="flex min-h-screen">
</body>
</html> 