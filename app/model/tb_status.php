<?php
namespace App\Model\Status;
class Status
{
    public $model;
    public $id;
    public $status_name;
    public $status_num;
    public function __construct()
    {
        $this->model = 'tb_status';
        $this->id = 'id';
        $this->status_name = 'status_name';
        $this->status_num = 'status_num';
    } 
}
class Request extends Status
{
    public function __construct()
    {
        $status = new Status();
        $this->status_name = $_POST[$status->status_name];
        $this->status_num = $_POST[$status->status_num];
    }
}
class RequestionItem extends Status
{
    public function __construct($conn, $id)
    {
        $status = new Status();

        $sql = "SELECT * FROM $status->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$status->id];
            $this->role_name = $result[$status->status_name];
            $this->role_name = $result[$status->status_num];
        }
    }
}