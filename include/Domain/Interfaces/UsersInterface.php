<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na użytkowników i uprawnienia hosta.
 */
interface UsersInterface
{
    /**
     * @return int 0, gdy nikt nie jest zalogowany
     */
    public function currentUserId(): int;

    public function isLoggedIn(): bool;

    public function grantCapability(string $role, string $capability): void;
}
