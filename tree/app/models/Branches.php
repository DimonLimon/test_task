<?php

  class Branches {
    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    public function getBranches() {
      $this->db->query("SELECT * FROM tree");
      return $this->db->resultGet();
    }

    public function getChildrenBranch($parent) {
        $this->db->query("SELECT main.id AS id, main.name AS name, child.id AS child 
                              FROM tree AS main
                              LEFT JOIN tree AS child ON child.parent_id = main.id
                              WHERE main.parent_id =:parent_id"
        );
        $this->db->bind(":parent_id", $parent);
        return $this->db->resultGet();
    }

    public function add($parent, $name) {
        $this->db->query("INSERT INTO tree SET parent_id=:parent_id, name=:name");
        $this->db->bind(":parent_id", $parent);
        $this->db->bind(":name", htmlspecialchars(strip_tags($name)));
        if($this->db->execute()) {
            return $this->db->getLastInsertId();
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM tree WHERE id=:id");
        $this->db->bind(":id", $id);
        $this->db->execute();
    }
  }

?>
