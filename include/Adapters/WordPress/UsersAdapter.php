<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;

final class UsersAdapter implements UsersInterface
{
    public function currentUserId(): int
    {
        return (int) get_current_user_id();
    }

    public function isLoggedIn(): bool
    {
        return is_user_logged_in();
    }

    public function grantCapability(string $role, string $capability): void
    {
        $wpRole = get_role($role);

        if ($wpRole) {
            $wpRole->add_cap($capability);
        }
    }
}
