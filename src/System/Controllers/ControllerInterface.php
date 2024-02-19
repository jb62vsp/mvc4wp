<?php declare(strict_types=1);
namespace Wp4Mvc\System\Controllers;

interface ControllerInterface
{
    public function view(string $view_name, array $data = []): static;
}