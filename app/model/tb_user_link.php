<?php
namespace App\Model\UserLink;
class UserLink
{
    public $model;
    public $id;
    public $link_user_id;
    public $link_icon_id;
    public $link_name;
    public $link_url;
    public $link_img;
    public $link_status;
    public $created_at;
    public $updated_at;
    public function __construct()
    {
        $this->model = 'tb_user_link';
        $this->id = 'id';
        $this->link_user_id = 'link_user_id';
        $this->link_icon_id = 'link_icon_id';
        $this->link_name = 'link_name';
        $this->link_url = 'link_url';
        $this->link_img = 'link_img';
        $this->link_status = 'link_status';
        $this->created_at = 'created_at';
        $this->updated_at = 'updated_at';
    } 
}
class Request extends UserLink
{
    public function __construct()
    {
        $userLink = new UserLink();
        $this->id = $_POST[$userLink->id];
        $this->link_user_id = $_POST[$userLink->link_user_id];
        $this->link_icon_id = $_POST[$userLink->link_icon_id];
        $this->link_name = $_POST[$userLink->link_name];
        $this->link_url = $_POST[$userLink->link_url];
        $this->link_img = $_POST[$userLink->link_img];
        $this->link_status = $_POST[$userLink->link_status];
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
    }
}
class RequestionItem extends UserLink
{
    public function __construct($conn, $sql)
    {
        $userLink = new UserLink();
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$userLink->id];
            $this->link_user_id = $result[$userLink->link_user_id];
            $this->link_icon_id = $result[$userLink->link_icon_id];
            $this->link_name = $result[$userLink->link_name];
            $this->link_url = $result[$userLink->link_url];
            $this->link_img = $result[$userLink->link_img];
            $this->link_status = $result[$userLink->link_status];
            $this->created_at = $result[$userLink->created_at];
            $this->updated_at = $result[$userLink->updated_at];
        }
    }
}