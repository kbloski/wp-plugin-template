<?php

namespace AstraToolbox\Inc\DTOs;

final class CookieDTO
{
    public int $post_id;
    public array $astra_colors;
    public array $custom_colors;

    public function __construct(array $data = [
        'post_id' => null,
        'astra_colors' => [],
        'custom_colors' => []
    ])
    {

        $this->post_id = isset($data['post_id']) ? (int) $data['post_id'] : 0;
        $this->astra_colors = isset($data['astra_colors']) && is_array($data['astra_colors'])
            ? $data['astra_colors'] : [];
        $this->custom_colors = isset($data['custom_colors']) && is_array($data['custom_colors'])
            ? $data['custom_colors'] : [];
    }

    public function toArray() : array 
    {
        return [
            'post_id' => $this->post_id,
            'astra_colors' => $this->astra_colors,
            'custom_colors'=> $this->custom_colors
        ];
    }

}
