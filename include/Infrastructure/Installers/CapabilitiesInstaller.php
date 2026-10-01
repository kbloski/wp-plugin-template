<?php 

namespace PluginTemplate\Inc\Infrastructure\Installers;

use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;
use PluginTemplate\Inc\Domain\Security\Capabilities;

class CapabilitiesInstaller
{
    public function __construct(private readonly UsersInterface $users)
    {
    }

    public function install(): void
    {
        $this->users->grantCapability('administrator', Capabilities::ADMIN);
    }
}
