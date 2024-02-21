<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;

abstract class ErrorController extends Controller
{
    use Castable;

    public function __construct(
        ConfiguratorInterface $config,
    ) {
        parent::__construct($config);
    }
}