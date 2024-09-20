<?php
namespace App\Model\Role;
class Role
{
    public $model;
    public $id;
    public $role_name;
    public function __construct()
    {
        $this->model = 'tb_role';
        $this->id = 'id';
        $this->role_name = 'role_name';
    } 
}
class Request extends Role
{
    public function __construct()
    {
        $role = new Role();
        $this->role_name = $_POST[$role->role_name] ?? 'title';
    }
}
class RequestionItem extends Role
{
    public function __construct($conn, $id)
    {
        $role = new Role();

        $sql = "SELECT * FROM $role->model WHERE id = '$id'";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();
        if($result){
            $this->id = $result[$role->id];
            $this->role_name = $result[$role->role_name];
        }
    }
}