<?php

namespace PluginTemplate\Inc\Core\Database;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;

/**
 * Statyczna fasada na DatabaseInterface z kontenera.
 */
class DbHelper
{
    /**
     * Czyści ostatni błąd bazy danych
     */
    public static function clearError(): void
    {
        self::db()->clearError();
    }

    /**
     * Sprawdza, czy wystąpił ostatni błąd bazy danych
     */
    public static function hasError(): bool
    {
        return self::db()->lastError() !== '';
    }

    /**
     * Pobiera ostatni błąd bazy danych
     */
    public static function getError(): string
    {
        return self::db()->lastError();
    }

    /**
     * Pobiera ostatni błąd i jednocześnie czyści go
     */
    public static function popError(): string
    {
        $err = self::getError();
        self::clearError();
        return $err;
    }

    // --- Transakcje ---

    /**
     * Rozpoczyna transakcję
     */
    public static function beginTransaction(): void
    {
        self::db()->beginTransaction();
    }

    /**
     * Zatwierdza transakcję
     */
    public static function commit(): void
    {
        self::db()->commit();
    }

    /**
     * Wycofuje transakcję
     */
    public static function rollback(): void
    {
        self::db()->rollback();
    }

    private static function db(): DatabaseInterface
    {
        return AppContainer::get()->get(DatabaseInterface::class);
    }
}
