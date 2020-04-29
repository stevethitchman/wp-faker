<?php

namespace App\Persistance;

class SavePost
{
    public $postId = null;
    public $userId = null;
    public $postType = null;
    public $postData = [];

    public function __construct($postData, $postType, $userId)
    {
        $this->userId = $userId;
        $this->postType = $postType;
        $this->postData = $postData;
    }

    public function persist()
    {
        $this->savePost();

        if (!empty($this->postData['thumbnail'])) {
            $this->saveThumbnail($this->postData['thumbnail']);
        }

        if (!empty($this->postData['acf'])) {
            $this->saveAcf($this->postData['acf']);
        }

        $this->saveTerms();
    }

    private function savePost()
    {
        $this->postId = wp_insert_post(array(
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            'post_author' => $this->userId,
            'post_name' => sanitize_title($this->postData['title']),
            'post_title' => $this->postData['title'],
            'post_content' => '', // never use post content
            'post_status' => 'publish',
            'post_type' => $this->postType,
        ));
    }

    private function saveAcf($values)
    {
        foreach ($values as $key => $value) {
            update_field($key, $value, $this->postId);
        }
    }

    public function saveTerms()
    {
        $taxonomies = get_object_taxonomies($this->postType);
        if ($taxonomies) {
            foreach ($taxonomies as $taxonomy) {
                $terms = get_terms($taxonomy, 'hide_empty=0');
                if ($terms) {
                    wp_set_object_terms($this->postId, $terms[rand(0,(count($terms)-1))]->slug, $taxonomy);
                }
            }
        }
    }

    public function saveThumbnail($attachmentId)
    {
        update_post_meta($this->postId, '_thumbnail_id', $attachmentId);
    }
}