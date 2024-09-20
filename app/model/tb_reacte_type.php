<?php
namespace App\Model\ReatType;
class ReateType
{
    public $model;
    public $id;
    public $reacte_type_title;
    public function __construct()
    {
        $this->model = 'tb_reate_type_title';
        $this->id = 'id';
        $this->reacte_type_title = 'reacte_type_title';
    } 
}
