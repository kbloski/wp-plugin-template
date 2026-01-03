<?php 

namespace AstraToolbox\Inc\DTOs;

class CookieColorDTO extends BaseCookieVariableDTO
{
    public int $alpha;

    public function __construct(array $data = [
        'meta_key' => null,
        'is_active' => true,
        'value' => true,
        'alpha' => 1
    ])
    {
        $this->alpha = $data['alpha'];
        return parent::__construct($data);
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'alpha' => $this->alpha
            ]); 
    }
}