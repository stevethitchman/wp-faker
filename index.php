<?php

require __DIR__. '/../wp-load.php';
include(ABSPATH.'wp-admin/includes/image.php');
require __DIR__ . '/vendor/autoload.php';

use App\Persistance\SaveTaxonomies;
use App\Persistance\SavePost;

$terms = false;
$posts = false;

$userId = config('first_run') ? wp_fake_create_user() : config('user_id');
$postTypes = config('posts');

if ($terms) {
    $taxonomies = wp_fake_generate_taxonomies($postTypes);
    $taxPersist = new SaveTaxonomies($taxonomies);
    $taxPersist->persist();
}

if ($posts) {
    foreach ($postTypes as $key => $postType) {
        $post = new $postType();
        $data = $post->generate();

//        print '<pre>';
//        var_dump($data);
//        print '</pre>';

        $postPersistor = new SavePost($data, $key, $userId);
        $postPersistor->persist();
    }
}

echo 'done';