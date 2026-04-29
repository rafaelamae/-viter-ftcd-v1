<?php

class Category
{
    public $cat_aid;
    public $cat_is_active;
    public $cat_name;
    public $cat_description;
    public $cat_created;
    public $cat_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblCategory;

    public function __construct($db)
    {
        $this->connection   = $db;
        $this->tblCategory  = "category";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblCategory} (";
            $sql .= " cat_is_active, cat_name, cat_description,";
            $sql .= " cat_created, cat_updated";
            $sql .= ") values (";
            $sql .= " :cat_is_active, :cat_name, :cat_description,";
            $sql .= " :cat_created, :cat_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "cat_is_active"   => $this->cat_is_active,
                "cat_name"        => $this->cat_name,
                "cat_description" => $this->cat_description,
                "cat_created"     => $this->cat_created,
                "cat_updated"     => $this->cat_updated,
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
            $sql  = " select * from {$this->tblCategory} where true ";
            $sql .= $this->cat_is_active !== null && $this->cat_is_active !== ""
                ? " and cat_is_active = :cat_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " cat_name like :cat_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by cat_aid asc ";

            $query = $this->connection->prepare($sql);
            if ($this->cat_is_active !== null && $this->cat_is_active !== "") {
                $query->bindValue(":cat_is_active", $this->cat_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
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
            $sql  = " select * from {$this->tblCategory} where true ";
            $sql .= $this->cat_is_active !== null && $this->cat_is_active !== ""
                ? " and cat_is_active = :cat_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " cat_name like :cat_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by cat_aid asc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->cat_is_active !== null && $this->cat_is_active !== "") {
                $query->bindValue(":cat_is_active", $this->cat_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
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
            $sql   = " select * from {$this->tblCategory} where cat_is_active = 1 order by cat_name asc ";
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
            $sql  = "update {$this->tblCategory} set ";
            $sql .= "cat_is_active   = :cat_is_active, ";
            $sql .= "cat_name        = :cat_name, ";
            $sql .= "cat_description = :cat_description, ";
            $sql .= "cat_updated     = :cat_updated ";
            $sql .= "where cat_aid   = :cat_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "cat_is_active"   => $this->cat_is_active,
                "cat_name"        => $this->cat_name,
                "cat_description" => $this->cat_description,
                "cat_updated"     => $this->cat_updated,
                "cat_aid"         => $this->cat_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblCategory} set ";
            $sql .= "cat_is_active = :cat_is_active, ";
            $sql .= "cat_updated   = :cat_updated ";
            $sql .= "where cat_aid = :cat_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "cat_is_active" => $this->cat_is_active,
                "cat_updated"   => $this->cat_updated,
                "cat_aid"       => $this->cat_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblCategory} ";
            $sql .= "where cat_aid = :cat_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["cat_aid" => $this->cat_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}