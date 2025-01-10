<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EasyBank</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-violet-950 via-violet-900 to-violet-800">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-transparent to-black/40">
        <div class="max-w-md w-full space-y-8 p-8 bg-white/85 backdrop-blur-sm rounded-lg shadow-2xl">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-violet-600">Welcome to EasyBank</h2>
                <p class="mt-2 text-sm text-gray-600">Please sign in to your account</p>
            </div>

            <?php if (isset($emptyError)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?php echo $emptyError; ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($notFoundError)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?php echo $notFoundError; ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($invalidPasswordError)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?php echo $invalidPasswordError; ?></p>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" method="POST" action="/login">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-violet-500 focus:border-violet-500">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                            name="login" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>