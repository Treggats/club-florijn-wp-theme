<?php

declare(strict_types=1);

namespace App;

use DateTime;
use Exception;
use WP_Post;

final class Bijeenkomst
{
    public WP_Post $post;
    public string $permalink;
    public ?string $ambassadors = null;
    public ?DateTime $date = null;

    public function __construct(WP_Post $post, string $permalink, ?string $ambassadors, ?string $date)
    {
        $this->post = $post;
        $this->permalink = $permalink;
        $this->ambassadors = $ambassadors;

        try {
            if ($date !== null) {
                $this->date = new DateTime($date);
            }
        } catch (Exception $e) {
            //
        }
    }
}
