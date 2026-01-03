<?php 

namespace AstraToolbox\Inc\DTOs;

class BaseCookieVariableDTO
{
    public string $meta_key;
    public bool $is_active;
    public string $value;

    public function __construct(array $data = [
        'meta_key' => null,
        'is_active' => true,
        'value' => true
    ])
    {
        $this->meta_key = $data['meta_key'];
        $this->is_active = $data['is_active'];
        $this->value = $data['value'];
    }

    public function toArray() : array 
    {
        return [
            'meta_key' => $this->meta_key,
            'is_active' => $this->is_active,
            'value' => $this->value
        ];
    }
}