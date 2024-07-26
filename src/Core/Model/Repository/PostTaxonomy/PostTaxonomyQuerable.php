<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostTaxonomy;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\TaxQueryFieldInQuery;
use Mvc4Wp\Core\Model\Repository\TaxQueryOperatorInQuery;
use Mvc4Wp\Core\Model\TermEntity;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
 */
trait PostTaxonomyQuerable
{
    use Castable;

    /**
     * @param string $taxonomy Taxonomy.
     * @param string|int|array $terms Taxonomy term(s).
     * @param TaxQueryFieldInQuery $field Select taxonomy term by.
     *  Default value is TaxQueryFieldInQuery::TERM_ID.
     * @param TaxQueryOperatorInQuery $operator Operator to test.
     * Default value is OperatorInQuery::IN.
     * @param bool $include_children  Whether or not to include children for hierarchical taxonomies.
     * Defaults to true.
     */
    public function byTaxonomy(string $taxonomy, string|int|array $terms, TaxQueryFieldInQuery $field = TaxQueryFieldInQuery::TERM_ID, TaxQueryOperatorInQuery $operator = TaxQueryOperatorInQuery::IN, bool $include_children = true): static
    {
        $new = clone $this;

        $new->addExpression(TaxQueryExpr::class, [[$taxonomy, $field->value, $terms, $include_children, $operator->value]]);

        return $new;
    }

    /**
     * @param TermEntity $term Term entity.
     * @param TaxQueryOperatorInQuery $operator Operator to test.
     * Default value is OperatorInQuery::IN.
     * @param bool $include_children  Whether or not to include children for hierarchical taxonomies.
     * Defaults to true.
     */
    public function byTerm(TermEntity $term, TaxQueryOperatorInQuery $operator = TaxQueryOperatorInQuery::IN, bool $include_children = true): static
    {
        return $this->byTaxonomy($term->taxonomy, $term->term_id, TaxQueryFieldInQuery::TERM_ID, $operator, $include_children);
    }
}