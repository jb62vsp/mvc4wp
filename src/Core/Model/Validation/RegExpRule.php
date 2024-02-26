<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Attribute;
use Mvc4Wp\Core\Language\MessagerInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\TypeUtils;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class RegExpRule extends Rule
{
    use Castable, AttributeTrait;

    public readonly string $value;

    public function __construct(
        public readonly string $pattern,
        public readonly string $message_key = 'validation.RegExpRule',
    ) {
    }

    public function validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $this->value = TypeUtils::untypedValue(gettype($value), $value);
        $matched = preg_match($this->pattern, $value);
        if (!$matched) {
            $result[] = new ValidationError($class_name, $property_name, $this->value, $this);
        }

        return $result;
    }

    public function getMessage(MessagerInterface $messager, array $args = []): string
    {
        $args['pattern'] = $this->pattern;
        $args['value'] = $this->value;
        return $messager->message($this->message_key, $args);
    }
}