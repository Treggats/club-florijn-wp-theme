<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <header class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-blue-600 transition-colors">
                    <?php bloginfo('name'); ?>
                </a>
            </h1>
            <?php if (get_bloginfo('description')) : ?>
                <p class="text-gray-600"><?php bloginfo('description'); ?></p>
            <?php endif; ?>
        </header>

        <main>
            <?php if (have_posts()) : ?>
                <div class="space-y-12">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" class="bg-white rounded-lg shadow-sm p-8">
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="text-sm text-gray-500 mb-6">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="prose prose-lg max-w-none text-gray-700">
                                <?php the_content(); ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="mt-12 flex justify-between items-center">
                    <div>
                        <?php previous_posts_link('&larr; Newer Posts', 0); ?>
                    </div>
                    <div>
                        <?php next_posts_link('Older Posts &rarr;', 0); ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <p class="text-gray-600">No posts found.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
