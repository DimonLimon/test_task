<?php

  class Index extends Controller {
    public function __construct() {
      $this->branchesModel = $this->model("Branches");
    }

    public function index() {
      $branches = $this->branchesModel->getBranches();
      foreach ($branches as $branch){
        if($branch->parent_id == 0){
          $parents[$branch->id] = ["name" => $branch->name, "hasChildren" => false];
        }else{
            $parents[$branch->parent_id]["hasChildren"] = true;
        }
      }

      $data = [
        "title" => "Tree View",
        "branches" => $branches,
        "parents" => $parents
      ];

      $this->view("pages/index", $data);
    }

    public function child() {
      $children = $this->branchesModel->getChildrenBranch($_GET['id']);
      foreach ($children as $child) {
        $childrenBranch[$child->id] = ["name" => $child->name, "hasChildren" => false];
        if($child->child > 0){
            $childrenBranch[$child->id]["hasChildren"] = true;
        }
      }

      $data = [
          "branches" => $childrenBranch
      ];

      echo json_encode($data);
    }
  }

?>
