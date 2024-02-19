<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Models\Model;

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