<?php 

namespace PluginTemplate\Inc\Core\Abstracts;

use RuntimeException;

abstract class AbstractShortcode
{
    /**
     * Domyślne atrybuty shortcode’a.
     *
     * Struktura każdego atrybutu:
     * - 'default'     => wartość domyślna (używana, gdy atrybut nie zostanie podany)
     * - 'description' => krótki opis atrybutu
     * - 'example'     => (opcjonalnie) przykład użycia atrybutu
     *
     * Przykład:
     * [
     *     'text' => [
     *         'default' => 'Hello',
     *         'description' => 'Tekst wyświetlany w shortcode',
     *         'example' => 'Witaj świecie!'
     *     ],
     *     'color' => [
     *         'default' => '#000',
     *         'description' => 'Kolor tekstu',
     *         'example' => '#ff0000'
     *     ]
     * ]
     *
     * @var array<string, array<string, mixed>>
     */
    protected array $atts = [];

    /**
     * Zwraca nazwę shortcode’a.
     */
    abstract public function name(): string;

    /**
     * Zwraca definicję atrybutów.
     */
    public function getAttributes(): array 
    {
        return $this->atts;
    }

    /**
     * Render shortcode (implementacja w child class).
     */
    abstract protected function render_shortcode(array $atts = []): string;

    protected function boot(): void {}

    public function enqueue_assets(): void {}

    /**
     * Rejestracja shortcode.
     */
    final public function register(): void
    {
        add_action('wp_enqueue_scripts', fn() => $this->enqueue_assets());
        add_action('admin_enqueue_scripts', fn() => $this->enqueue_assets());

        $this->boot();
        $this->validate_atts();

        add_shortcode($this->name(), fn($atts = [], $content = null, $tag = null) =>
            $this->handle_shortcode($atts, $content, $tag)
        );
    }

    /**
     * Walidacja definicji atts.
     */
    final function validate_atts(): void
    {
        $errors = [];

        if (!is_array($this->atts)) {
            throw new RuntimeException('Atrybuty muszą być tablicą.');
        }

        foreach ($this->atts as $name => $attr) {
            if (!is_array($attr)) {
                $errors[] = "Atrybut '{$name}' musi być tablicą.";
                continue;
            }

            if (!array_key_exists('default', $attr)) {
                $errors[] = "Atrybut '{$name}' musi mieć klucz 'default'.";
            }

            if (!array_key_exists('description', $attr)) {
                $errors[] = "Atrybut '{$name}' musi mieć klucz 'description'.";
            }

            if (isset($attr['example']) && !is_scalar($attr['example'])) {
                $errors[] = "Atrybut '{$name}': 'example' musi być skalarem.";
            }
        }

        if (!empty($errors)) {
            throw new RuntimeException(implode("; ", $errors));
        }
    }

    /**
     * Entry point shortcode.
     */
    final public function handle_shortcode(array $atts = [], ?string $content = null, ?string $tag = null): string
    {
        $merged = $this->merge_atts($atts);

        return $this->render_shortcode($merged);
    }

    /**
     * Merge default + user atts.
     */
    protected function merge_atts(array $atts = []): array
    {
        $merged = [];

        foreach ($this->atts as $key => $attr) {
            $merged[$key] = $attr['default'] ?? null;
        }

        return array_merge($merged, $atts);
    }

    /**
     * Magic override (bez psucia $this->atts!)
     */
    final public function __call(string $name, array $arguments)
    {
        throw new \BadMethodCallException(
            "Method {$name} does not exist in " . static::class
        );
    }
}