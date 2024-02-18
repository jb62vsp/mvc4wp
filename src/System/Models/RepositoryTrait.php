<?php declare(strict_types=1);
namespace System\Models;

trait RepositoryTrait
{
    public function register(): int
    {
        $this->ID = wp_insert_post($this);
        $fields = CustomField::getAttributedProperties(get_class($this));
        foreach ($fields as $field) {
            $untypedValue = self::reverseProperty($this, $field);
            $property = $field->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
        return $this->ID;
    }

    public function update(): void
    {
        wp_update_post($this);
        $fields = CustomField::getAttributedProperties(get_class($this));
        foreach ($fields as $field) {
            $untypedValue = self::reverseProperty($this, $field);
            $property = $field->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
    }

    public function delete(bool $force_delete = false): bool
    {
        if ($force_delete) {
            $result = wp_delete_post($this->ID, force_delete: $force_delete);
        } else {
            $result = wp_trash_post($this->ID);
        }
        if (!$result) {
            return false;
        }
        return true;
    }
}