<?php
namespace App\Model\PostType;
class PostType
{
    public $model;
    public $id;
    public $post_type_title;
    public function __construct()
    {
        $this->model = 'tb_post_type';
        $this->id = 'id';
        $this->post_type_title = 'post_type_title';
    } 
}