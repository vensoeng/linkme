<?php
namespace App\Model\UserDetail;
class UserDetail
{
    public $model;
    public $id;
    public $user_detail_id;
    public $first_name;
    public $last_name;
    public $gender;
    public $profile;
    public $bio;
    public $cover;
    public $img_share;
    public $user_birthday;
    public $user_address;
    public function __construct()
    {
        $this->model = 'tb_user_detail';
        $this->id = 'id';
        $this->user_detail_id = 'user_detail_id';
        $this->first_name ='first_name';
        $this->last_name = 'last_name';
        $this->gender = 'gender';
        $this->profile = 'profile';
        $this->bio = 'bio';
        $this->cover = 'cover';
        $this->img_share = 'img_share';
        $this->user_birthday = 'user_birthday';
        $this->user_address = 'user_address';
    } 
}
class Request extends UserDetail
{
    public function __construct()
    {
        $user = new UserDetail();
        $this->id = $_POST[$user->id];
        $this->user_detail_id = $_POST[$user->user_detail_id];
        $this->first_name = $_POST[$user->first_name];
        $this->last_name = $_POST[$user->last_name];
        $this->gender = $_POST[$user->gender];
        $this->profile = $_FILES[$user->profile]['name'];
        $this->bio = $_POST[$user->bio];
        $this->cover = $_FILES[$user->cover]['name'];
        $this->img_share = $_FILES[$user->img_share]['name'];
        $this->user_birthday = $_POST[$user->user_birthday];
        $this->user_address = $_POST[$user->user_birthday];
    }
}
class RequestionItem extends UserDetail
{
    public function __construct($conn, $id)
    {
        $user = new UserDetail();

        $sql = "SELECT * FROM $user->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$user->id];
            $this->user_detail_id = $result[$user->user_detail_id];
            $this->first_name = $result[$user->first_name];
            $this->last_name = $result[$user->last_name];
            $this->gender = $result[$user->gender];
            $this->profile = $result[$user->profile];
            $this->bio = $result[$user->bio];
            $this->cover = $result[$user->cover];
            $this->img_share = $result[$user->img_share];
            $this->user_birthday = $result[$user->user_birthday];
            $this->user_address = $result[$user->user_birthday];
        }
    }
}

// $this->first_name ='first_name';
// $this->last_name = 'last_name';
// $this->profile = 'profile';
// $this->cover = 'cover';
// $this->bio = 'bio';