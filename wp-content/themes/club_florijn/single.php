<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?> - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <header class="mb-12">
            <h1 class="text-2xl font-bold text-gray-900">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-blue-600 transition-colors">
                    &larr; <?php bloginfo('name'); ?>
                </a>
            </h1>
        </header>

        <main>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="bg-white rounded-lg shadow-sm p-8">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">
                            <?php the_title(); ?>
                        </h2>
                        <div class="text-sm text-gray-500 mb-8">
                            <?php echo get_the_date(); ?>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-700">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </main>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
