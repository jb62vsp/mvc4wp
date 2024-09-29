<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Attribute;
use Mvc4Wp\Core\Library\Castable;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CustomField extends Field
{
    use Castable, AttributeTrait;

    public const TEXT = 'TEXT';

    public const TEXTAREA = 'TEXTAREA';

    public const INTEGER = 'INTEGER';

    public const UINTEGER = 'UINTEGER';

    public const FLOAT = 'FLOAT';

    public const UFLOAT = 'UFLOAT';

    public const BOOL = 'BOOL';

    public const DATE = 'DATE';

    public const TIME = 'TIME';

    public const DATETIME = 'DATETIME';

    public function __construct(
        public string|array $title,
        public string $type = CustomField::TEXT,
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