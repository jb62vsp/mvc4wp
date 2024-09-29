<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Attribute;
use Mvc4Wp\Core\Library\Castable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class UserCustomField extends Field
{
    use Castable, AttributeTrait;

    public function __construct(
        public string|array $title,
    ) {
    }

    public function getTitle(string $locale = ''): string
    {
        $result = $this->title;
        if (is_array($this->title)) {
            if (count($this->title) > 0) {
                if (key_exists($locale, $this->title)) {
                    $result = $this->title[$locale];
                } else {
                    $result = current(array_slice($this->title, 0, 1, true));
                }
            } else {
                $result = '';
            }
        }
        return $result;
    }
}