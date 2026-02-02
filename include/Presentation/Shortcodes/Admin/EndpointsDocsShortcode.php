<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use Throwable;

class EndpointsDocsShortcode extends AbstractShortcode
{
    public function getShortcodeName(): string 
    {
        return ShortcodesNamesEnum::ENDPOINTS_DOCS();
    }

    public function render_shortcode(array $atts = []): string
    {
        try 
        {
            $routes = rest_get_server()->get_routes();

            // Filtrujemy tylko te z namespace /finance
            $financeRoutes = array_filter(
                $routes,
                fn($handlers, $route) => str_starts_with($route, PluginConfig::NAMESPACE),
                ARRAY_FILTER_USE_BOTH
            );

        } catch (Throwable $e)
        {
            Logger::error($e);
            return "Błąd podczas pobierania dokumentacji endpointów: " . esc_html($e->getMessage());
        }

        ob_start();
        ?>
              <div class="finance-endpoints-docs">
                <section>
                    <?php if (!empty($financeRoutes)): ?>
                        <ul>
                        <?php foreach ($financeRoutes as $route => $handlers): ?>
                            <li>
                                <strong>Path:</strong> <?php echo esc_html(rest_url($route)); ?><br>
                                <strong>Methods:</strong> 
                                <?php 
                                    $methods = array_map(fn($h) => implode(', ', array_keys($h['methods'])), $handlers);
                                    echo esc_html(implode(', ', $methods));
                                ?><br>
                                <strong>Args:</strong>
                                <ul>
                                    <?php
                                    foreach ($handlers as $handler) {
                                        if (!empty($handler['args'])) {
                                            foreach ($handler['args'] as $arg => $settings) {
                                                echo '<li>' . esc_html($arg) . ' (' . esc_html(json_encode($settings)) . ')</li>';
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No endpoints found for namespace <code>/finance</code>.</p>
                    <?php endif; ?>
                </section>
            </div>

        <?php
        return ob_get_clean();
    }
}