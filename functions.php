<?php declare(strict_types=1);
use App\Model\CustomTaxEntity;

define('__MVC4WP_ROOT__', __DIR__);
require_once (__MVC4WP_ROOT__ . '/vendor/autoload.php');

use App\Controller\LoginController;
use App\Logger\LogEntityLoggerFactory;
use App\Model\CustomCatEntity;
use App\Model\CustomTagEntity;
use App\Model\ExampleEntity;
use App\Model\LogEntity;
use App\Model\LogLevelTagEntity;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Logger\Default\DefaultFileLoggerFactory;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;

\Mvc4Wp\Core\Service\Helper::load('Debug');

App::get()->config()->set('js.use_minify', 'false');
App::get()->config()->set('css.use_cache', 'false');
App::get()->config()->set('css.use_minify', 'false');
App::get()->config()->set('logger.loggers.app.log_level', 'debug');
App::get()->config()->set('logger.loggers.core.log_level', 'debug');
App::get()->config()->set('logger.loggers.log_model', [
    'logger_factory' => LogEntityLoggerFactory::class,
    'log_level' => 'info',
]);
App::get()->config()->set('logger.loggers.sql', [
    'logger_factory' => DefaultFileLoggerFactory::class,
    'directory' => __MVC4WP_ROOT__ . '/log/',
    'basefilename' => 'sql',
    'file_date_format' => 'Ymd',
    'datetime_format' => 'Y-m-d H:i:s',
    'timezone' => 'Asia/Tokyo',
    'log_level' => 'debug',
]);
Logging::configure(App::get()->config());
WordPressCustomize::enableTraceSQL(function ($q) {
    Logging::get('sql')->debug($q);
    return $q;
});
WordPressCustomize::addCustomPostType(ExampleEntity::class);
WordPressCustomize::addCustomTaxonomy(CustomCatEntity::class);
WordPressCustomize::addCustomTaxonomy(CustomTagEntity::class);
WordPressCustomize::addCustomPostType(LogEntity::class);
WordPressCustomize::addCustomTaxonomy(LogLevelTagEntity::class);
WordPressCustomize::disableRedirectCanonical();
WordPressCustomize::changeLoginUrl(LoginController::class);