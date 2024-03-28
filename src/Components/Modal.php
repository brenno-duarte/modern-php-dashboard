<?php

namespace Dashboard\Components;

use Dashboard\Template\Template;

class Modal
{
    private string $body;
    private string $size = '';

    public function body(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function size(string $size)
    {
        $this->size = $size;
        return $this;
    }

    public function render()
    {
        echo Template::getTemplate('components/modal.php', [
            'body' => $this->body,
            'size' => $this->size
        ]);
    }
}