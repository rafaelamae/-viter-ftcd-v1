<?php

class Designation
{
    public $des_aid;
    public $des_is_active;
    public $des_name;
    public $des_category_id;
    public $des_created;
    public $des_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblDesignation;
    public $tblCategory;

    public function __construct($db)
    {
        $this->connection     = $db;
        $this->tblDesignation = "designation";
        $this->tblCategory    = "category";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblDesignation} (";
            $sql .= " des_is_active, des_name, des_category_id,";
            $sql .= " des_created, des_updated";
            $sql .= ") values (";
            $sql .= " :des_is_active, :des_name, :des_category_id,";
            $sql .= " :des_created, :des_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "des_is_active"  => $this->des_is_active,
                "des_name"       => $this->des_name,
                "des_category_id" => $this->des_category_id,
                "des_created"    => $this->des_created,
                "des_updated"    => $this->des_updated,
            ]);
            $this->lastInsertedId = $this->connection->lastInsertId();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function readAll()
    {
        try {
            $sql  = " select designation.*, category.cat_name ";
            $sql .= " from {$this->tblDesignation} as designation ";
            $sql .= " left join {$this->tblCategory} as category ";
            $sql .= " on designation.des_category_id = category.cat_aid ";
            $sql .= " where true ";
            $sql .= $this->des_is_active !== null && $this->des_is_active !== ""
                ? " and designation.des_is_active = :des_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " designation.des_name like :des_name " : " ";
            $sql .= $this->search != "" ? " or category.cat_name like :cat_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by designation.des_aid asc ";

            $query = $this->connection->prepare($sql);
            if ($this->des_is_active !== null && $this->des_is_active !== "") {
                $query->bindValue(":des_is_active", $this->des_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":des_name", $search);
                $query->bindValue(":cat_name", $search);
            }
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function readLimit()
    {
        try {
            $sql  = " select designation.*, category.cat_name ";
            $sql .= " from {$this->tblDesignation} as designation ";
            $sql .= " left join {$this->tblCategory} as category ";
            $sql .= " on designation.des_category_id = category.cat_aid ";
            $sql .= " where true ";
            $sql .= $this->des_is_active !== null && $this->des_is_active !== ""
                ? " and designation.des_is_active = :des_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " designation.des_name like :des_name " : " ";
            $sql .= $this->search != "" ? " or category.cat_name like :cat_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by designation.des_aid asc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->des_is_active !== null && $this->des_is_active !== "") {
                $query->bindValue(":des_is_active", $this->des_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":des_name", $search);
                $query->bindValue(":cat_name", $search);
            }
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function readAllActive()
    {
        try {
            $sql  = " select designation.*, category.cat_name ";
            $sql .= " from {$this->tblDesignation} as designation ";
            $sql .= " left join {$this->tblCategory} as category ";
            $sql .= " on designation.des_category_id = category.cat_aid ";
            $sql .= " where designation.des_is_active = 1 ";
            $sql .= " order by designation.des_name asc ";
            $query = $this->connection->prepare($sql);
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function update()
    {
        try {
            $sql  = "update {$this->tblDesignation} set ";
            $sql .= "des_is_active  = :des_is_active, ";
            $sql .= "des_name       = :des_name, ";
            $sql .= "des_category_id = :des_category_id, ";
            $sql .= "des_updated    = :des_updated ";
            $sql .= "where des_aid  = :des_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "des_is_active"  => $this->des_is_active,
                "des_name"       => $this->des_name,
                "des_category_id" => $this->des_category_id,
                "des_updated"    => $this->des_updated,
                "des_aid"        => $this->des_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblDesignation} set ";
            $sql .= "des_is_active = :des_is_active, ";
            $sql .= "des_updated   = :des_updated ";
            $sql .= "where des_aid = :des_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "des_is_active" => $this->des_is_active,
                "des_updated"   => $this->des_updated,
                "des_aid"       => $this->des_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblDesignation} ";
            $sql .= "where des_aid = :des_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["des_aid" => $this->des_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}
