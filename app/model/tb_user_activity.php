<?php
namespace App\Model\UserActivity;
class UserActivity
{
    public $model;
    public $id;
    public $activity_user_id;
    public $activity_content_id;
    public $activity_type_id;
    public $created_at;
    public $updated_at;
    public function __construct()
    {
        $this->model = 'tb_user_activity';
        $this->id = 'id';
        $this->activity_user_id = 'activity_user_id';
        $this->activity_content_id = 'activity_content_id';
        $this->activity_type_id = 'activity_type_id';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';
    } 
}
class Request extends UserActivity
{
    public function __construct()
    {
        $userActivity = new UserActivity();
        $this->id = $_POST[$userActivity->id];
        $this->activity_user_id = $_POST[$userActivity->activity_user_id];
        $this->activity_content_id = $_POST[$userActivity->activity_content_id];
        $this->activity_type_id = $_POST[$userActivity->activity_type_id];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends UserActivity
{
    public function __construct($conn, $id)
    {
        $userActivity = new UserActivity();

        $sql = "SELECT * FROM $userActivity->model WHERE id = $id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$userActivity->id];
            $this->activity_user_id = $result[$userActivity->activity_user_id];
            $this->activity_content_id = $result[$userActivity->activity_content_id];
            $this->activity_type_id = $result[$userActivity->activity_type_id];
            $this->created_at = $result[$userActivity->created_at];
            $this->updated_at = $result[$userActivity->updated_at];
        }
    }
}