<?php

function repeater($class, $times = 2)
{
    $data = [];

    for ($i = 0; $i < $times; $i++) {
        $data[] = (new $class())();
    }

    return $data;
}

function generate($class)
{
    return (new $class())();
}

function flexi_generator($options, $random)
{
    if (!$random) {
        return flexi_generate_sequential($options);
    }

    return flexi_generate_random($options);
}

function flexi_generate_random($options)
{
    $content = [];

    $passes = rand(count($options), count($options) * 3);

    for ($i = 0; $i <= $passes; $i++) {
        $layout = array_rand($options);
        $option = $options[$layout];

        $piece = generate($option);
        $piece['acf_fc_layout'] = $layout;
        $content[] = $piece;
    }

    return $content;
}

function flexi_generate_sequential($options)
{
    $content = [];

    foreach ($options as $layout => $option) {
        $piece = generate($option);
        $piece['acf_fc_layout'] = $layout;
        $content[] = $piece;
    }

    return $content;
}

function config($key, $value = '')
{
    $configContents = json_decode(file_get_contents('config.json'), true);

    if ($value != '') {
        $configContents[$key] = $value;
        file_put_contents('config.json', json_encode($configContents));
    }

    return isset($configContents[$key]) ? $configContents[$key] : null;
}

function wp_fake_create_user()
{
    $password = wp_generate_password(36, true);
    $userId = wp_create_user('DummyContent', $password, 'DummyContent@DummyEmail.local');

    $user = get_user_by('id', $userId);
    $user->remove_role('subscriber');
    $user->add_role('administrator');

    // todo: fix this, it's not setting....
    config('first_run', false);

    return config('user_id', $userId);
}

function wp_fake_generate_taxonomies($postTypes)
{
    $generatedTaxonomies = [];

    foreach ($postTypes as $key => $postType) {
        $taxonomies = get_object_taxonomies($key, 'objects');

        if ($taxonomies) {
            foreach ($taxonomies as $innerKey => $taxonomy) {
                for ($o = 0; $o <= rand(2, 4); $o++) {
                    $childTax = [];

                    $generatedTax = generate(App\Generators\Base\Taxonomy::class);

                    if ($taxonomy->hierarchical) {
                        for ($i = 0; $i <= rand(1, 5); $i++) {
                            $childTax[] = ['name' => generate(App\Generators\Base\Taxonomy::class)];
                        }
                    }

                    $generatedTaxonomies[] = [
                        'name' => $generatedTax,
                        'taxonomy' => $innerKey,
                        'children' => $childTax,
                    ];
                }
            }
        }
    }

    return $generatedTaxonomies;
}