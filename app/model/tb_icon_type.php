<?php
namespace App\Model\IconType;
class IconType
{
    public $model;
    public $id;
    public $type_name;
    public $type_num;
    public function __construct()
    {
        $this->model = 'tb_icon_type';

        $this->id = 'id';
        $this->type_name = 'type_name';
        $this->type_num = 'type_num';
    } 
}
class Request extends IconType
{
    public function __construct()
    {
        $iconType = new IconType();
        $this->icon = $_POST[$iconType->type_name] ?? 'icon';
        $this->icon_name = $_POST[$iconType->type_num] ?? 1;
    }
}
class RequestionItem extends IconType
{
    public function __construct($conn, $id)
    {
        $iconType = new IconType();

        $sql = "SELECT * FROM $iconType->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$iconType->id];
            $this->type_name = $result[$iconType->type_name];
            $this->type_num = $result[$iconType->type_num];

        }
    }
}