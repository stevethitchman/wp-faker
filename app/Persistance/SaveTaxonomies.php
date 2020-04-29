<?php

namespace App\Persistance;

class SaveTaxonomies
{
    public $taxonomies = [];

    public function __construct($taxonomies)
    {
        $this->taxonomies = $taxonomies;
    }

    public function persist()
    {
        foreach ($this->taxonomies as $taxonomy) {
            $parent = wp_insert_term(
                $taxonomy['name'],
                $taxonomy['taxonomy']
            );
            if (!empty($taxonomy['children'])) {
                foreach ($taxonomy['children'] as $childTaxonomy) {
                    wp_insert_term(
                        $childTaxonomy['name'],
                        $taxonomy['taxonomy'],
                        [
                            'parent' => $parent['term_id']
                        ]
                    );
                }
            }
        }
    }
}