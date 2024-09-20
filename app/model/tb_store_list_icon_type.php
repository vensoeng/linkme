<?php
namespace App\Model\ListIconType;
class ListIconType
{
    public $model;
    public $id;
    public $icon_id;
    public $type_id;
    public function __construct()
    {
        $this->model = 'tb_store_list_icon_type';

        $this->id = 'id';
        $this->icon_id = 'icon_id';
        $this->type_id = 'type_id';

    } 
}
class Request extends ListIconType
{
    public function __construct()
    {
        $storelistIcon = new ListIconType();
        $this->icon_id = $_POST[$storelistIcon->icon_id];
        $this->type_id = $_POST[$storelistIcon->type_id];
    }
}
class RequestionItem extends ListIconType
{
    public function __construct($conn, $id)
    {
        $storelistIcon = new ListIconType();

        $sql = "SELECT * FROM $storelistIcon->model $id";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$storelistIcon->id];
            $this->icon_id = $result[$storelistIcon->icon_id];
            $this->type_id = $result[$storelistIcon->type_id];
        }
    }
}