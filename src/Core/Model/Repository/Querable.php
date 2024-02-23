<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
trait Querable
{
    protected array $expressions = [];

    public function getExpressions(): array
    {
        return $this->expressions;
    }

    protected function addExpression(string $class, int|string|array $value): void
    {
        if ($this->exists($class) && is_array($value)) {
            $this->expressions[$class] = array_merge($this->expressions[$class], $value);
        } elseif ($this->exists($class)) {
            $this->expressions[$class] = array_merge($this->expressions[$class], [$value]);
        } else {
            $this->setExpression($class, $value);
        }
    }

    protected function setExpression(string $class, int|string|array $value): void
    {
        if (is_array($value)) {
            $this->expressions[$class] = $value;
        } else {
            $this->expressions[$class] = [$value];
        }
    }

    protected function exists(string $class): bool
    {
        return array_key_exists($class, $this->expressions);
    }
}