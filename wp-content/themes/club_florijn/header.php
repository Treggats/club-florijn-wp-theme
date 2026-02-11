<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-white text-gray-900 antialiased">
    <div id="main-container" class="flex flex-col min-h-screen">
        <!-- Header -->
        <header id="header" class="border-b border-gray-200 sticky top-0 z-50 bg-white shadow-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo/Site Title -->
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-gray-900 hover:text-blue-600 transition-colors">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                    </div>

                    <!-- Navigation Menu -->
                    <nav class="hidden md:flex space-x-8">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'fallback_cb' => 'wp_page_menu',
                            'container_class' => 'flex space-x-6',
                            'link_before' => '<span class="text-gray-700 hover:text-blue-600 transition-colors">',
                            'link_after' => '</span>',
                            'depth' => 2
                        ));
                        ?>
                    </nav>

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition-colors" aria-expanded="false">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>
