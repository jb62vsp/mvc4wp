<?php declare(strict_types=1);

use App\Models\ExampleModel;
use System\Helper\WpCustomHelper;

/*
 * --------------------------------------------------------------------
 * init scripts
 * --------------------------------------------------------------------
 */
WpCustomHelper::addCustomPostType(ExampleModel::class);