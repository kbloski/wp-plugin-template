<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

use RuntimeException;

/**
 * Port na bazę danych. Zapytania używają placeholderów %d, %f, %s.
 */
interface DatabaseInterface
{
    /**
     * Prefix tabel hosta
     */
    public function prefix(): string;

    public function usersTable(): string;

    public function usermetaTable(): string;

    public function charsetCollate(): string;

    /**
     * Wykonuje zapytanie modyfikujące dane.
     *
     * @return int Liczba zmienionych wierszy
     * @throws RuntimeException
     */
    public function execute(string $sql, array $params = []): int;

    /**
     * @return array<int, array<string, mixed>>
     * @throws RuntimeException
     */
    public function select(string $sql, array $params = []): array;

    public function lastInsertId(): int;

    /**
     * Tworzy lub aktualizuje strukturę tabel na podstawie CREATE TABLE.
     *
     * @throws RuntimeException
     */
    public function applySchema(string $sql): void;

    public function lastError(): string;

    public function clearError(): void;

    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}
