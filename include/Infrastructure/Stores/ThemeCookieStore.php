<?php 

namespace AstraToolbox\Inc\Stores;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\DTOs\CookieColorDTO;
use AstraToolbox\Inc\DTOs\CookieDTO;
use AstraToolbox\Inc\Enums\CookiesMeta;
use AstraToolbox\Inc\Enums\PostMetaColorEnum;
use AstraToolbox\Inc\Enums\PostMetaEnum;
use AstraToolbox\Inc\Utils\LoggerX;
use AstraToolbox\Inc\Utils\PostsHelper;
use InvalidArgumentException;
use Throwable;

class ThemeCookieStore extends AbstractSingleton
{
    protected function __construct()
    {
        return parent::__construct();
    }

    
    public function getSettingsForPost( int $postId) : CookieDTO
    {
        try 
        {            
            $cookie = $_COOKIE[CookiesMeta::OVERRIDE_THEME_VARIABLES_JSON()];
            if (empty($cookie))
            {
                return $this->createCookieDtoByPostId($postId);
            }

            $dto = $this->getCookies($postId);

            return $dto;
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }


    

    public function udpateCookies(int $postId) : void 
    {
        try {
            $override_enabled = !empty(get_post_meta($postId, PostMetaEnum::THEME_STYLE_OVERRIDE_ENABLED(), true));
            if (empty(!$override_enabled)) return;

            $cookieDTO = $this->createCookieDtoByPostId($postId);

            // error_log(json_encode($cookieDTO));

            setcookie(
                CookiesMeta::OVERRIDE_THEME_VARIABLES_JSON(),
                json_encode($cookieDTO),
                time() + DAY_IN_SECONDS,
                COOKIEPATH,
                COOKIE_DOMAIN
            );
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }





    private function getCookies(int $postId) : CookieDTO
    {
        try {
            $cookie = $_COOKIE[CookiesMeta::OVERRIDE_THEME_VARIABLES_JSON()];
            
            if ( !empty($cookie))
            {
                $cookie = wp_unslash($cookie);
                $cookie = json_decode($cookie, true);

                $dto = new CookieDTO($cookie);

                return $dto;
            }

            return new CookieDTO([]);
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }  

    public function setColor(int $postId, CookieColorDTO $colorDTO) : void
    {
        try {
            $errors = PostsHelper::validatePost($postId);

            if (!empty($errors)) {
                throw new InvalidArgumentException(implode(' ', $errors));
            }

            update_post_meta($postId, $colorDTO->meta_key, $colorDTO->toArray());
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }






    private function createCookieDtoByPostId( int $postId) : CookieDTO
    {
        try {
            $astra_colors = $this->getAstraColors($postId);
            $custom_colors = $this->getCustomColors($postId);

            $cookieDTO = new CookieDTO([
                'post_id' => $postId,
                'astra_colors' => $astra_colors,
                'custom_colors' => $custom_colors,
            ]);

            return $cookieDTO;
        } catch ( Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }

    private function getCustomColors( $postId) : array 
    {
        try {
            $metaKeys = [
                PostMetaColorEnum::FOOTER_BACKGROUND(),
                PostMetaColorEnum::FOOTER_COLOR()
            ];

            $colors = [];
            foreach ($metaKeys as $key) {
                $meta = get_post_meta($postId, $key, true);
                $colors[$key] = $meta;
            }

            return $colors;
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }

    private function getAstraColors( $postId ) : array 
    {
        try {
            $metaKeys = [
                PostMetaColorEnum::BRAND(),
                PostMetaColorEnum::ALT_BRAND(),
                PostMetaColorEnum::HEADING(),
                PostMetaColorEnum::TEXT(),
                PostMetaColorEnum::PRIMARY(),
                PostMetaColorEnum::SECONDARY(),
                PostMetaColorEnum::BORDER(),
                PostMetaColorEnum::SUBTLE_BACKGROUND(),
                PostMetaColorEnum::ACCENT(),
            ];

            $colors = [];
            foreach ($metaKeys as $index => $key) {
                $meta = get_post_meta($postId, $key, true);
                $colors[] = $meta;
            }

            return $colors;

        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
    }

    
}