<?php include_once 'partials/headerHome.php'; ?>

<!-- Hero Section -->
<div class="relative bg-violet-800">
    <div class="absolute inset-0">
        <img src="https://raw.githubusercontent.com/bradtraversy/tailwind-landing-page/master/img/bg-tablet-pattern.svg" class="w-full h-full object-cover opacity-10">
    </div>
    <div class="relative max-w-[1400px] mx-auto px-6 lg:px-8 py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-5xl lg:text-7xl font-bold text-white mb-8 leading-tight">
                    Next Generation Digital Banking
                </h1>
                <p class="text-violet-100 text-xl lg:text-2xl mb-10 leading-relaxed">
                    Take your financial life online. Your Easy Bank account will be your one-stop-shop for spending, saving, investing, and more.
                </p>
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="#" class="bg-white text-violet-800 px-10 py-5 rounded-xl font-semibold hover:bg-violet-100 transition duration-300 text-center text-lg">
                        Get Started
                    </a>
                    <a href="#" class="text-white border-2 border-white px-10 py-5 rounded-xl font-semibold hover:bg-white hover:text-violet-800 transition duration-300 text-center text-lg">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <img src="https://raw.githubusercontent.com/bradtraversy/tailwind-landing-page/master/img/illustration-intro.svg" class="w-full h-auto max-w-2xl mx-auto" alt="Digital Banking">
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="bg-gray-50 py-20">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Easy Bank?</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                We leverage cutting-edge technology to provide you with the best banking experience possible.
            </p>
        </div>
        
        <div class="flex flex-col items-center gap-6 max-w-md mx-auto">
            <!-- Feature Cards -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center text-center w-full group">
                <div class="bg-violet-50 w-20 h-20 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-violet-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Online Banking</h3>
                <p class="text-gray-600 text-base leading-relaxed">
                    Modern web and mobile applications to track your finances anywhere in the world.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 flex flex-col items-center text-center w-full group">
                <div class="bg-violet-50 w-20 h-20 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-violet-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Fast Onboarding</h3>
                <p class="text-gray-600 text-base leading-relaxed">
                    Open an account in minutes and start taking control of your finances.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-violet-800 py-32">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-8 text-center">
        <h2 class="text-5xl font-bold text-white mb-8">
            Start your financial journey today
        </h2>
        <p class="text-violet-100 text-xl lg:text-2xl mb-12 max-w-3xl mx-auto leading-relaxed">
            Join thousands of users who are already experiencing the future of banking with Easy Bank.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6">
            <a href="#" class="bg-white text-violet-800 px-10 py-5 rounded-xl font-semibold hover:bg-violet-100 transition duration-300 text-lg">
                Open Account
            </a>
            <a href="#" class="text-white border-2 border-white px-10 py-5 rounded-xl font-semibold hover:bg-white hover:text-violet-800 transition duration-300 text-lg">
                Contact Us
            </a>
        </div>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>