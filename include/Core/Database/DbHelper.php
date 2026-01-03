<?php

namespace PluginTemplate\Inc\Core\Database;

class DbHelper
{
    /**
     * Czyści ostatni błąd bazy danych
     */
    public static function clearError(): void
    {
        global $wpdb;
        $wpdb->last_error = null;
    }

    /**
     * Sprawdza, czy wystąpił ostatni błąd bazy danych
     */
    public static function hasError(): bool
    {
        global $wpdb;
        return !empty($wpdb->last_error);
    }

    /**
     * Pobiera ostatni błąd bazy danych
     */
    public static function getError(): string
    {
        global $wpdb;
        return $wpdb->last_error ?? '';
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
        global $wpdb;
        $wpdb->query('START TRANSACTION');
    }

    /**
     * Zatwierdza transakcję
     */
    public static function commit(): void
    {
        global $wpdb;
        $wpdb->query('COMMIT');
    }

    /**
     * Wycofuje transakcję
     */
    public static function rollback(): void
    {
        global $wpdb;
        $wpdb->query('ROLLBACK');
    }
}
