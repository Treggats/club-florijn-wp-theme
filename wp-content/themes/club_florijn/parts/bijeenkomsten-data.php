<?php
// parts/bijeenkomsten-data.php
// Pure PHP: data retrieval and formatting helpers for 'bijeenkomsten' used by the template partial.

if ( ! function_exists( 'club_florijn_get_bijeenkomsten_query' ) ) {
	/**
	 * Return a WP_Query for 'bijeenkomst' posts.
	 *
	 * @param int $per_page
	 * @param int|null $paged
	 * @return WP_Query
	 */
	function club_florijn_get_bijeenkomsten_query( $per_page = 4, $paged = null ) {
		if ( null === $paged ) {
			$paged = get_query_var( 'paged' ) ?: 1;
		}

        return new WP_Query([
            'posts_per_page' => (int) $per_page,
            'post_type'      => 'bijeenkomst',
            'paged'          => (int) $paged,
            // Order by the event date saved in postmeta
            'meta_key'       => '_bijeenkomst_date',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        ]);
	}
}

if ( ! function_exists( 'club_florijn_get_bijeenkomsten_sidebar' ) ) {
	/**
	 * Return an array of sidebar items (simple arrays) for use in templates.
	 *
	 * @param int $number
	 * @return array
	 */
	function club_florijn_get_bijeenkomsten_sidebar( $number = 4 ) {
		$posts = get_posts([
			'post_type'   => 'bijeenkomst',
			'numberposts' => (int) $number,
			// Order sidebar list by the event date postmeta
			'meta_key'    => '_bijeenkomst_date',
			'orderby'     => 'meta_value',
			'order'       => 'ASC',
		]);

		$out = [];
		foreach ( $posts as $p ) {
			$ambassadors = get_post_meta( $p->ID, '_bijeenkomst_ambassadors', true );
			$raw_date     = get_post_meta( $p->ID, '_bijeenkomst_date', true );

			$formatted_date = false;
			if ( ! empty( $raw_date ) ) {
				$timestamp = strtotime( $raw_date );
				if ( false !== $timestamp ) {
					// Use date_i18n so translations/locales are respected
					$formatted_date = date_i18n( 'l d F Y', $timestamp );
				}
			}

			$out[] = [
				'ID'             => $p->ID,
				'title'          => $p->post_title,
				'permalink'      => get_permalink( $p->ID ),
				'ambassadors'    => $ambassadors,
				'raw_date'       => $raw_date,
				'formatted_date' => $formatted_date,
			];
		}

		return $out;
	}
}

if ( ! function_exists( 'club_florijn_get_bijeenkomsten_data' ) ) {
	/**
	 * Convenience wrapper returning both query and sidebar items.
	 *
	 * @param int $per_page
	 * @param int $sidebar_number
	 * @return array { 'query': WP_Query, 'sidebar': array }
	 */
	function club_florijn_get_bijeenkomsten_data( $per_page = 4, $sidebar_number = 4 ) {
		return [
			'query'   => club_florijn_get_bijeenkomsten_query( $per_page ),
			'sidebar' => club_florijn_get_bijeenkomsten_sidebar( $sidebar_number ),
		];
	}
}
