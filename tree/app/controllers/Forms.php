<?php
class Forms extends Controller
{
    public function __construct() {
        $this->branchesModel = $this->model("Branches");
    }

    public function add(){
        $id = $this->branchesModel->add($_GET['parent_id'], $_GET['name_branch']);
        $data = [
            "id" => $id,
            "name" => $_GET['name_branch'],
        ];
        echo json_encode($data);
    }

    public function delete(){
        $this->branchesModel->delete($_GET['id']);
    }
}