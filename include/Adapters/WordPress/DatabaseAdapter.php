<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use RuntimeException;
use wpdb;

final class DatabaseAdapter implements DatabaseInterface
{
    public function prefix(): string
    {
        return $this->wpdb()->prefix;
    }

    public function usersTable(): string
    {
        return $this->wpdb()->users;
    }

    public function usermetaTable(): string
    {
        return $this->wpdb()->usermeta;
    }

    public function charsetCollate(): string
    {
        return $this->wpdb()->get_charset_collate();
    }

    public function execute(string $sql, array $params = []): int
    {
        $wpdb = $this->wpdb();
        $result = $wpdb->query($this->prepare($sql, $params));

        if ($result === false) {
            throw new RuntimeException($wpdb->last_error ?: 'Database query failed');
        }

        return (int) $result;
    }

    public function select(string $sql, array $params = []): array
    {
        $wpdb = $this->wpdb();
        $rows = $wpdb->get_results($this->prepare($sql, $params), ARRAY_A);

        if ($rows === null && !empty($wpdb->last_error)) {
            throw new RuntimeException($wpdb->last_error);
        }

        return $rows ?? [];
    }

    public function lastInsertId(): int
    {
        return (int) $this->wpdb()->insert_id;
    }

    public function applySchema(string $sql): void
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $this->clearError();
        dbDelta($sql);

        $error = $this->lastError();
        if ($error !== '') {
            $this->clearError();
            throw new RuntimeException($error);
        }
    }

    public function lastError(): string
    {
        return (string) ($this->wpdb()->last_error ?? '');
    }

    public function clearError(): void
    {
        $this->wpdb()->last_error = '';
    }

    public function beginTransaction(): void
    {
        $this->wpdb()->query('START TRANSACTION');
    }

    public function commit(): void
    {
        $this->wpdb()->query('COMMIT');
    }

    public function rollback(): void
    {
        $this->wpdb()->query('ROLLBACK');
    }

    private function prepare(string $sql, array $params): string
    {
        // wpdb::prepare() bez placeholderów zgłasza _doing_it_wrong.
        return empty($params) ? $sql : $this->wpdb()->prepare($sql, ...$params);
    }

    private function wpdb(): wpdb
    {
        global $wpdb;

        return $wpdb;
    }
}
