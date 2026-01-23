<?php

namespace PluginTemplate\Inc\Presentation\React;

class ReactRootRenderer
{
    /**
     * Renderuje kontener HTML dla React rootu.
     *
     * `$data` zostaje zamienione na atrybuty `data-*`,
     * które są dostępne w JS/React przez `el.dataset`.
     *
     * Przykład:
     * renderRoot('company_panel', [
     *   'user-id' => 42,
     *   'start-counter' => 0,
     * ]);
     *
     * JS:
     * el.dataset.userId        // "42"
     * el.dataset.startCounter // "0"
     *
     * @param string $rootName Nazwa React rootu
     * @param array<string, scalar> $data Dane przekazywane jako data-*
     * @return string HTML kontenera React
     */
    public static function renderRoot(string $rootName, array $data = []): string
    {
        ob_start() 
        ?>
            <div 
                data-react-root="<?=$rootName ?>"
                <?php
                    foreach($data as $key => $value)
                    {
                        echo "data-".$key."='".$value."'";   
                    }
                ?>
            >
                React
            </div>
        <?php
        return ob_get_clean();
    }
}
