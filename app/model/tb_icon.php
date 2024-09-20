<?php
namespace App\Model\Icon;
class Icon
{
    public $model;
    public $id;
    public $icon;
    public $icon_name;
    public $icon_img;
    public function __construct()
    {
        $this->model = 'tb_icon';

        $this->id = 'id';
        $this->icon = 'icon';
        $this->icon_name = 'icon_name';
        $this->icon_img = 'icon_img';
    } 
}
class Request extends Icon
{
    public function __construct()
    {
        $icon = new Icon();
        $this->icon = $_POST[$icon->icon] ?? '<i>icon</i>';
        $this->icon_name = $_POST[$icon->icon_name] ?? 'title';
        $this->icon_img =  $_FILES[$icon->icon_img]['name'];
    }
}
class RequestionItem extends Icon
{
    public function __construct($conn, $id)
    {
        $icon = new Icon();

        $sql = "SELECT * FROM $icon->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$icon->id];
            $this->role_name = $result[$icon->icon];
            $this->role_num = $result[$icon->icon_name];
            $this->role_num = $result[$icon->icon_img];
        }
    }
}