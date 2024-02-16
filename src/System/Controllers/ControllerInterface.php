<?php declare(strict_types=1);
namespace System\Controllers;

interface ControllerInterface
{
    public function view(string $view_name, array $data = []): static;
}