<?php 

namespace AstraToolbox\Inc\Core\Abstracts;

use RuntimeException;

/**
 * Abstrakcyjna klasa bazowa dla shortcode’ów.
 *
 * Odpowiada za:
 * - rejestrację shortcode’a w WordPressie,
 * - automatyczne scalanie atrybutów z domyślnymi,
 * - wywoływanie właściwej metody renderującej w klasach potomnych.
 *
 * @since 1.0.0
 */
abstract class AbstractShortcode extends AbstractSingleton
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
     * Zwraca nazwę shortcode’a (np. 'my_shortcode').
     *
     * @return string
     */
    abstract public function getShortcodeName(): string;

    /**
     * Zwraca atrybuty shortcode’a.
     *
     * @return string
     */
    public function getAttributes() : array 
    {
        return $this->atts;
    }

    /**
     * Renderuje treść shortcode’a (implementowana przez klasę potomną).
     *
     * @param array $atts Atrybuty shortcode’a.
     * @return string HTML wynikowy.
     */
    abstract protected function render_shortcode(array $atts = []): string;

    
    /**
     * Metoda uruchamiana po rejestracji shortcode’a.
     * Klasa potomna może w niej dodać swoje hooki, enqueue’y, akcje itp.
     *
     * @return void
     */
    protected function boot(): void
    {
        // Do nadpisania w klasie potomnej
    }


    /**
     * Rejestruje skrypty i style dla shortcode'a.
     * Klasa potomna może nadpisać, żeby wczytać własne zasoby.
     */
    public function enqueue_assets(): void
    {
        // Domyślnie nic nie robi
    }


    /**
     * Rejestruje shortcode w WordPressie.
     *
     * @return void
     */
    final public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);

        $this->boot();
        $this->validateAttsStructure();
        add_shortcode($this->getShortcodeName(), [$this, 'handle_shortcode']);

    }


    /**
     * Waliduje strukturę atrybutów shortcode’a.
     *
     * Każdy atrybut powinien być tablicą z kluczami:
     * 'default' i 'description'.  
     * Opcjonalnie może zawierać 'example' (prosta wartość: string, int, float, bool).
     *
     * @return array Lista błędów. Pusta, jeśli wszystko poprawne.
     */
    final function validateAttsStructure()
    {
        $atts = $this->atts;
        $errors = [];

        // Sprawdzenie czy $atts jest tablicą
        if (!is_array($atts)) {
            $errors[] = 'Atrybuty muszą być tablicą.';
        }

        // Iteracja po każdym atrybucie
        foreach ($atts as $name => $attr) {
            // Każdy atrybut musi być tablicą
            if (!is_array($attr)) {
                $errors[] = "Atrybut '{$name}' musi być tablicą.";
                continue;
            }

            // Sprawdzenie kluczy 'default' i 'description'
            if (!array_key_exists('default', $attr)) {
                $errors[] = "Atrybut '{$name}' musi mieć klucz 'default'.";
            }

            if (!array_key_exists('description', $attr)) {
                $errors[] = "Atrybut '{$name}' musi mieć klucz 'description'.";
            }

            // Sprawdzenie opcjonalnego 'example'
            if (isset($attr['example']) && !is_scalar($attr['example'])) {
                $errors[] = "Atrybut '{$name}': 'example' powinien być wartością prostą (string, int, float, bool).";
            }
        }

        if (!empty($errors))
        {
            throw new RuntimeException(implode("; ", $errors));
        }
    }

        
    /**
     * Funkcja pośrednicząca obsługująca shortcode.
     *
     * @param array       $atts    Atrybuty shortcode’a.
     * @param string|null $content Zawartość pomiędzy znacznikami shortcode’a (jeśli istnieje).
     * @param string|null $tag     Nazwa shortcode’a.
     * @return string
     */

    final public function handle_shortcode(array $atts = [], ?string $content = null, ?string $tag = null): string
    {
        // Jawne wywołanie __call, aby automatycznie połączyć atrybuty
        return $this->__call('render_shortcode', [$atts]);
    }

    /**
     * Pobiera atrybuty shortcode z uwzględnieniem wartości domyślnych.
     *
     * @param array $atts Atrybuty przekazane w shortcode.
     * @return array Atrybuty z uwzględnieniem defaultów
     */
    protected function getMergedAttributes(array $atts = []): array
    {
        $merged = [];

        // 1. Pobieramy wartości domyślne
        foreach ($this->atts as $key => $attr) {
            $merged[$key] = $attr['default'] ?? null;
        }

        // 2. Nadpisujemy wartościami z shortcode
        $merged = array_merge($merged, $atts);

        return $merged;
    }




    /**
     * Magiczna metoda wywoływana, gdy metoda nie istnieje.
     * Obsługuje automatyczne łączenie atrybutów i deleguje renderowanie.
     *
     * @param string $name      Nazwa wywoływanej metody.
     * @param array  $arguments Argumenty przekazane do metody.
     * @return string
     *
     * @throws \BadMethodCallException Jeśli metoda nie istnieje.
     */
    final public function __call(string $name, array $arguments)
    {
        if ($name === 'render_shortcode') {
            $atts = $arguments[0] ?? [];

            // Scal atrybuty z domyślnymi
            $merged = $this->getMergedAttributes($atts);
            $this->atts = $merged;

            // Wywołaj faktyczne renderowanie
            return $this->render_shortcode($merged);
        }

        throw new \BadMethodCallException("Method {$name} does not exist in " . static::class);
    }
}