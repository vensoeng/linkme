<?php
namespace App\Model\User;
class User
{
    public $model;
    public $id;
    public $user_role;
    public $policy_status;
    public $user_status;
    public $email;
    public $password;
    public $user_name;
    public $verify_status;
    public $created_at;
    public $updated_at;
    public function __construct()
    {
        $this->model = 'tb_user';
        $this->id = 'id';
        $this->user_role = 'user_role';
        $this->policy_status = 'policy_status';
        $this->user_status = 'user_status';
        $this->verify_status = 'verify_status';
        $this->email = 'email';
        $this->password = 'password';
        $this->user_name = 'user_name';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';
    } 
}
class Request extends User
{
    public function __construct()
    {
        $user = new User();
        $this->id = $_POST[$user->id];
        $this->user_role = $_POST[$user->user_role];
        $this->policy_status = $_POST[$user->policy_status];
        $this->user_status = $_POST[$user->user_status];
        $this->verify_status = $_POST[$user->verify_status];
        $this->email = $_POST[$user->email];
        $this->password =  $_POST[$user->password];
        $this->user_name = $_POST[$user->user_name];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends User
{
    public function __construct($conn, $sql)
    {
        $user = new User();
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$user->id];
            $this->user_role = $result[$user->user_role];
            $this->policy_status = $result[$user->policy_status];
            $this->user_status = $result[$user->user_status];
            $this->verify_status = $result[$user->verify_status];
            $this->email = $result[$user->email];
            $this->password = $result[$user->password];
            $this->user_name = $result[$user->user_name];
            $this->created_at = $result[$user->created_at];
            $this->updated_at = $result[$user->updated_at];
        }
        echo $sql;
    }
}
