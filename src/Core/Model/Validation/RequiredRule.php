<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Attribute;
use Mvc4Wp\Core\Language\MessagerInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\TypeUtils;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class RequiredRule extends Rule
{
    use Castable, AttributeTrait;

    private const DEFAULT_MESSAGE_KEY = 'validation.RequiredRule';

    private const DEFAULT_MESSAGE = '';

    public readonly string $value;

    public function __construct(
        public readonly string $message_key = self::DEFAULT_MESSAGE_KEY,
        public readonly string $message = self::DEFAULT_MESSAGE,
    ) {
    }

    public function validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $this->value = TypeUtils::untypedValue(gettype($value), $value);
        $length = strlen($this->value);
        if ($length <= 0) {
            $result[] = new ValidationError($class_name, $property_name, $this->value, $this);
        }

        return $result;
    }

    public function getMessage(MessagerInterface $messager, array $args = []): string
    {
        return $messager->message($this->message_key, $args, $this->message);
    }
}