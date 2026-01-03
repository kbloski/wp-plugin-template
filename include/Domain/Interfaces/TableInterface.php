<?php 

namespace PluginTemplate\Inc\Domain\Interfaces;

interface TableInterface
{
    public function create() : void;
    public function drop() : void;
}