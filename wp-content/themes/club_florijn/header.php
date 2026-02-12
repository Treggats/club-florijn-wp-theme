<!-- Header -->
<header id="header" class="bg-blue-900 text-white sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-16 gap-4">
            <!-- Logo/Site Title -->
            <div class="flex-shrink-0">
                <h1 class="text-2xl font-bold">
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                       class="text-white hover:text-blue-100 transition-colors">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            </div>

            <!-- Separator -->
            <span class="hidden md:block text-gray-400 text-xl">|</span>

            <!-- Navigation Menu -->
            <nav class="hidden md:flex items-center">
                <?php
                wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '<ul class="flex space-x-6 list-none m-0 p-0">%3$s</ul>',
                        'link_before' => '',
                        'link_after' => '',
                        'link_class' => 'text-white hover:text-blue-600 transition-colors',
                        'depth' => 2,
                ]);
                ?>
            </nav>

            <!-- Mobile Menu Button -->
            <button class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-800 transition-colors"
                    aria-expanded="false">
                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</header>
