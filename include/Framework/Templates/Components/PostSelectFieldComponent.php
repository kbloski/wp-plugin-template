<?php

namespace AstraToolbox\Inc\Templates\Components;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Utils\LoggerX;
use AstraToolbox\Inc\Utils\PagesHelper;
use AstraToolbox\Inc\Utils\PostsHelper;
use Throwable;

class PostSelectFieldComponent extends AbstractSingleton
{
    public function render(array $props = [
        'name' => '',
        'value' => null,
        'onchange' => null
    ]): string
    {
        $pages = PostsHelper::getAll([
            'post_type'   => ['product', 'page'],

        ]);

        $fieldName    = $props['name'];
        $selectedPage = $props['value'];
        $onChange     = $props['onchange'];

        ob_start();
        ?>
        <p class="astra-field astra-field--page-select">
            <label for="<?= esc_attr($fieldName) ?>">
                <strong>Wybierz stronę:</strong>
            </label>

            <select
                name="<?= esc_attr($fieldName) ?>"
                id="<?= esc_attr($fieldName) ?>"
                <?= !empty($onChange) ? 'onchange='.$onChange : "" ?>
            >
                <option value="">-- wybierz stronę --</option>

                <?php foreach ($pages as $page): ?>
                    <option
                        value="<?= esc_attr($page->ID) ?>"
                        <?= selected($selectedPage, $page->ID, false) ?>
                    >
                        <?=  esc_html($page->post_type) ." - ". esc_html($page->post_title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php

        return ob_get_clean();
    }
}
