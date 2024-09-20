<?php
namespace App\Model\Reacte;
class Reacte
{
    public $model;
    public $id;
    public $reate_type;
    public $post_id;
    public $user_reacte_id;
    public $user_post_id;
    public $reacte_status;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->model = 'tb_reacte';
        $this->id = 'id';
        $this->reate_type = 'reate_type';
        $this->post_id = 'post_id';
        $this->user_reacte_id = 'user_reacte_id';
        $this->user_post_id = 'user_post_id';
        $this->reacte_status = 'reacte_status';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';
    
    } 
}
class Request extends Reacte
{
    public function __construct()
    {
        $reacte = new Reacte();
        $this->id = $_POST[$reacte->id];
        $this->reate_type = $_POST[$reacte->reate_type];
        $this->post_id = $_POST[$reacte->post_id];
        $this->user_reacte_id = $_POST[$reacte->user_reacte_id];
        $this->user_post_id = $_POST[$reacte->user_reacte_id];
        $this->reacte_status = $_POST[$reacte->reacte_status];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends Reacte
{
    public function __construct($conn, $id)
    {
        $reate = new Reacte();

        $sql = "SELECT * FROM $reate->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$reate->id];
            $this->reate_type = $result[$reate->reate_type];
            $this->post_id = $result[$reate->post_id];
            $this->user_reacte_id = $result[$reate->user_reacte_id];
            $this->user_post_id = $result[$reate->user_reacte_id];
            $this->reacte_status = $result[$reate->reacte_status];
            $this->created_at = $result[$reate->created_at];
            $this->updated_at = $result[$reate->updated_at];
        }
    }
}