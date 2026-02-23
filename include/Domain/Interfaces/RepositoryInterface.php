<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

interface RepositoryInterface
{
    /**
     * Wstawia lub aktualizuje wiele rekordów naraz.
     *
     * @param array $items Tablica rekordów do zapisania. Każd
     */
    public function upsertMany(array $items);

    /**
     * Pobiera wszystkie rekordy.
     *
     * @param array $props Opcjonalne kryteria filtrowania, 
     * @return array
     */
    public function getAll(array $props): array;
}
