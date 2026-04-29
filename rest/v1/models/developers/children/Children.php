<?php

class Children
{
    public $children_aid;
    public $children_is_active;
    public $children_full_name;
    public $children_birth_date;
    public $children_my_story;
    public $children_donation_limit;
    public $children_is_resident;
    public $children_created;
    public $children_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblChildren;

    public function __construct($db)
    {
        $this->connection   = $db;
        $this->tblChildren  = "children";
    }

    // CREATE
    public function create()
    {
        try {
            $sql  = "insert into {$this->tblChildren} (";
            $sql .= " children_is_active, children_full_name, children_birth_date,";
            $sql .= " children_my_story, children_donation_limit, children_is_resident,";
            $sql .= " children_created, children_updated";
            $sql .= ") values (";
            $sql .= " :children_is_active, :children_full_name, :children_birth_date,";
            $sql .= " :children_my_story, :children_donation_limit, :children_is_resident,";
            $sql .= " :children_created, :children_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_is_active"      => $this->children_is_active,
                "children_full_name"      => $this->children_full_name,
                "children_birth_date"     => $this->children_birth_date,
                "children_my_story"       => $this->children_my_story,
                "children_donation_limit" => $this->children_donation_limit,
                "children_is_resident"    => $this->children_is_resident,
                "children_created"        => $this->children_created,
                "children_updated"        => $this->children_updated,
            ]);
            $this->lastInsertedId = $this->connection->lastInsertId();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // READ ALL (for total count in pagination)
    public function readAll()
    {
        try {
            $sql  = " select * from {$this->tblChildren} where true ";
            $sql .= $this->children_is_active !== null && $this->children_is_active !== ""
                ? " and children_is_active = :children_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " children_full_name like :children_full_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by children_aid desc ";

            $query = $this->connection->prepare($sql);
            if ($this->children_is_active !== null && $this->children_is_active !== "") {
                $query->bindValue(":children_is_active", $this->children_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":children_full_name", $search);
            }
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // READ LIMIT (paginated)
    public function readLimit()
    {
        try {
            $sql  = " select * from {$this->tblChildren} where true ";
            $sql .= $this->children_is_active !== null && $this->children_is_active !== ""
                ? " and children_is_active = :children_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " children_full_name like :children_full_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by children_aid desc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total,     PDO::PARAM_INT);
            if ($this->children_is_active !== null && $this->children_is_active !== "") {
                $query->bindValue(":children_is_active", $this->children_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":children_full_name", $search);
            }
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // UPDATE
    public function update()
    {
        try {
            $sql  = "update {$this->tblChildren} set ";
            $sql .= "children_is_active      = :children_is_active, ";
            $sql .= "children_full_name      = :children_full_name, ";
            $sql .= "children_birth_date     = :children_birth_date, ";
            $sql .= "children_my_story       = :children_my_story, ";
            $sql .= "children_donation_limit = :children_donation_limit, ";
            $sql .= "children_is_resident    = :children_is_resident, ";
            $sql .= "children_updated        = :children_updated ";
            $sql .= "where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_is_active"      => $this->children_is_active,
                "children_full_name"      => $this->children_full_name,
                "children_birth_date"     => $this->children_birth_date,
                "children_my_story"       => $this->children_my_story,
                "children_donation_limit" => $this->children_donation_limit,
                "children_is_resident"    => $this->children_is_resident,
                "children_updated"        => $this->children_updated,
                "children_aid"            => $this->children_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // ARCHIVE / RESTORE
    public function active()
    {
        try {
            $sql  = "update {$this->tblChildren} set ";
            $sql .= "children_is_active = :children_is_active, ";
            $sql .= "children_updated   = :children_updated ";
            $sql .= "where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "children_is_active" => $this->children_is_active,
                "children_updated"   => $this->children_updated,
                "children_aid"       => $this->children_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // DELETE
    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblChildren} ";
            $sql .= "where children_aid = :children_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["children_aid" => $this->children_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}