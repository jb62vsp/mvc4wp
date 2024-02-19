<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models\Repository;

use Wp4Mvc\System\Models\Model;

/**
 * @template TModel of Model
 * @template TQuery of QueryInterface<TModel>
 */
interface RepositoryInterface
{
    /**
     * @return TQuery
     */
    public static function find(): QueryInterface;
    
    /**
     * @return int
     */
    public function register(): int;

    /**
     * @return void
     */
    public function update(): void;

    /**
     * @return bool
     */
    public function delete(bool $force_delete = false): bool;
}