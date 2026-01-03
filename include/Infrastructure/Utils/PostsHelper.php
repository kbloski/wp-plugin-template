<?php

namespace AstraToolbox\Inc\Utils;

use Throwable;

class PostsHelper
{
    private function __construct()
    {
      
    }

    public static function validatePost(int $postId): array
    {
        $errors = [];

        try {
            if (empty($postId) || $postId <= 0) {
                $errors[] = "ID postu nie może być puste ani ujemne";
                return $errors;
            }

            $post = get_post($postId);
            if (!$post) {
                $errors[] = "Post o ID {$postId} nie istnieje";
            }

            return $errors;
        } catch (Throwable $e) {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }


    public static function getAll( array $props = 
        [
            'post_type'   => 'page',
            'numberposts' => -1,
            'orderby'     => 'title',
            'order'       => 'ASC',
        ]) : array
    {
        try {
            $pages = get_posts($props);

            return $pages;
        } catch (Throwable $e) {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }


}
