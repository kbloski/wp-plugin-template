<?php 

namespace PluginTemplate\Inc\Core\Container;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    /**
     * @template T
     * @param class-string<T> $id
     * @param callable(self): T $factory
     */
    public function set(string $id, callable $factory): void
    {
        $this->bindings[$id] = $factory;
    }

    
    /**
     * @template T
     * @param class-string<T> $id
     * @return T
     */
    public function get(string $id): mixed
    {
        // singleton cache (opcjonalne, ale bardzo przydatne)
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->bindings[$id])) {
            throw new ContainerException("Service not found: $id");
        }

        $this->instances[$id] = $this->bindings[$id]($this);

        return $this->instances[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }
}