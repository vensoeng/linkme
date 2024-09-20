<?php
namespace App\Model\Follower;
class Follower
{
    public $model;
    public $id;
    public $user_follower_id;
    public $user_sand_follower_id;
    public $follower_status;
    public $created_at;
    public $updated_at;
    public function __construct()
    {
        $this->model = 'tb_follower';
        $this->id = 'id';
        $this->user_follower_id = 'user_follower_id';
        $this->user_sand_follower_id = 'user_sand_follower_id';
        $this->follower_status = 'follower_status';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';

    } 
}
class Request extends Follower
{
    public function __construct()
    {
        $follower = new Follower();
        $this->id = $_POST[$follower->id];
        $this->user_follower_id = $_POST[$follower->user_follower_id];
        $this->user_sand_follower_id = $_POST[$follower->user_sand_follower_id];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends Follower
{
    public function __construct($conn, $id)
    {
        $follower = new Follower();

        $sql = "SELECT * FROM $follower->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = [$follower->id];
            $this->user_follower_id = [$follower->user_follower_id];
            $this->user_sand_follower_id = [$follower->user_sand_follower_id];
            $this->created_at = [$follower->created_at];
            $this->updated_at =[$follower->updated_at];
        }
    }
}