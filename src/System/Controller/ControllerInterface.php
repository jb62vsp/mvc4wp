<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

interface ControllerInterface
{
    public function view(string $view_name, array $data = []): static;
}