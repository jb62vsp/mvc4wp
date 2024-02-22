<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

interface ControllerInterface
{
    public function init(array $args = []): void;

    public function index(array $args = []): void;
    
    public function view(string $view_name, array $data = []): static;
}