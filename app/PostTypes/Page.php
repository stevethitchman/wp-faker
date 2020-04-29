<?php

namespace App\PostTypes;

use App\Generators\Accordion5050;
use App\Generators\Hero;
use App\Generators\TextAndImage5050;
use App\Generators\Base\Title;
use App\Generators\Base\Thumbnail;

class Page {

    public $post = [];

    protected $layouts = [
        'text_&_image_5050' => TextAndImage5050::class,
        'accordion_5050' => Accordion5050::class,
    ];

    public function generate($random = true, $thumbnail = false)
    {
        $post['title'] = generate(Title::class);

        $post['acf']['hero'] = generate(Hero::class);
        $post['acf']['flexible_content'] = flexi_generator($this->layouts, $random);

        if ($thumbnail) {
            $post['thumbnail'] = generate(Thumbnail::class);
        }

        return $post;
    }

}

