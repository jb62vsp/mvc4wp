<?php declare(strict_types=1);

define('__WPMVC_ROOT__', __DIR__);

require_once(__WPMVC_ROOT__ . '/vendor/autoload.php');

\Mvc4Wp\System\Service\WpCustomize::disableRedirectCanonical();
\Mvc4Wp\System\Service\WpCustomize::addCustomPostType(\App\Models\CustomPostModel::class);