<?php

namespace PluginTemplate\Inc\Presentation\React;

class ReactRootRenderer
{
    /**
     * Renderuje div do podpięcia React rootu
     * @param string $rootName Nazwa rootu Reacta (np. 'hello_react')
     * @return string
     */
    public static function renderRoot(string $rootName): string
    {
        ob_start() 
        ?>
            <div data-react-root="<?=$rootName ?>">
                React
            </div>
        <?php
        return ob_get_clean();
    }
}
