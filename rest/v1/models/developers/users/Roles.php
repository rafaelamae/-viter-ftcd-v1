<?php

class Roles
{
    public $role_aid;
    public $role_is_active;
    public $role_name;
    public $role_description;
    public $role_created;
    public $role_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblRoles;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblRoles   = "roles";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblRoles} (";
            $sql .= " role_is_active, role_name, role_description,";
            $sql .= " role_created, role_updated";
            $sql .= ") values (";
            $sql .= " :role_is_active, :role_name, :role_description,";
            $sql .= " :role_created, :role_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_is_active"   => $this->role_is_active,
                "role_name"        => $this->role_name,
                "role_description" => $this->role_description,
                "role_created"     => $this->role_created,
                "role_updated"     => $this->role_updated,
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
            $sql  = " select * from {$this->tblRoles} where true ";
            $sql .= $this->role_is_active !== null && $this->role_is_active !== ""
                ? " and role_is_active = :role_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " role_name like :role_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by role_aid asc ";

            $query = $this->connection->prepare($sql);
            if ($this->role_is_active !== null && $this->role_is_active !== "") {
                $query->bindValue(":role_is_active", $this->role_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":role_name", $search);
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
            $sql  = " select * from {$this->tblRoles} where true ";
            $sql .= $this->role_is_active !== null && $this->role_is_active !== ""
                ? " and role_is_active = :role_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " role_name like :role_name " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by role_aid asc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->role_is_active !== null && $this->role_is_active !== "") {
                $query->bindValue(":role_is_active", $this->role_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":role_name", $search);
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
            $sql   = " select * from {$this->tblRoles} where role_is_active = 1 order by role_name asc ";
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
            $sql  = "update {$this->tblRoles} set ";
            $sql .= "role_is_active   = :role_is_active, ";
            $sql .= "role_name        = :role_name, ";
            $sql .= "role_description = :role_description, ";
            $sql .= "role_updated     = :role_updated ";
            $sql .= "where role_aid   = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_is_active"   => $this->role_is_active,
                "role_name"        => $this->role_name,
                "role_description" => $this->role_description,
                "role_updated"     => $this->role_updated,
                "role_aid"         => $this->role_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblRoles} set ";
            $sql .= "role_is_active = :role_is_active, ";
            $sql .= "role_updated   = :role_updated ";
            $sql .= "where role_aid = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "role_is_active" => $this->role_is_active,
                "role_updated"   => $this->role_updated,
                "role_aid"       => $this->role_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblRoles} ";
            $sql .= "where role_aid = :role_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["role_aid" => $this->role_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}
