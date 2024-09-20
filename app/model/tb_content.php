<?php
namespace App\Model\Content;
class Content
{
    public $model;
    public $id;
    public $user_post_id;
    public $post_type;
    public $post_status;
    public $post_title;
    public $post_des;
    public $post_img;
    public $post_like_count;
    public $post_save_count;
    public $post_comment_count;
    public $created_at;
    public $updated_at;
    public function __construct()
    {
        $this->model = 'tb_content';
        $this->id = 'id';
        $this->user_post_id = 'user_post_id';
        $this->post_type = 'post_type';
        $this->post_status = 'post_status';
        $this->post_title = 'post_title';
        $this->post_des = 'post_des';
        $this->post_img = 'post_img';
        $this->post_like_count = 'post_like_count';
        $this->post_save_count = 'post_save_count';
        $this->post_comment_count = 'post_comment_count';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';
    } 
}
class Request extends Content
{
    public function __construct()
    {
        $post = new Content();
        $this->id = $_POST[$post->id];
        $this->user_post_id = $_POST[$post->user_post_id];
        $this->post_type = $_POST[$post->post_type];
        $this->post_status = $_POST[$post->post_status];
        $this->post_title = $_POST[$post->post_title];
        $this->post_des = $_POST[$post->post_des];
        $this->post_img = $_POST[$post->post_img];
        $this->post_like_count = $_POST[$post->post_like_count];
        $this->post_save_count = $_POST[$post->post_save_count];
        $this->post_comment_count = $_POST[$post->post_comment_count];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends Content
{
    public function __construct($conn, $id)
    {
        $post = new Content();

        $sql = "SELECT * FROM $post->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$post->id];
            $this->user_post_id = $result[$post->user_post_id];
            $this->post_type = $result[$post->post_type];
            $this->post_status = $result[$post->post_status];
            $this->post_title = $result[$post->post_title];
            $this->post_des = $result[$post->post_des];
            $this->post_img = $result[$post->post_img];
            $this->post_like_count = $result[$post->post_like_count];
            $this->post_save_count = $result[$post->post_save_count];
            $this->post_comment_count = $result[$post->post_comment_count];
            $this->created_at = $result[$post->created_at];
            $this->updated_at = $result[$post->updated_at];
        }
    }
}