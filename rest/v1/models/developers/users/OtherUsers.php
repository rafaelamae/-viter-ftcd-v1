<?php

class OtherUsers
{
    public $otheruser_aid;
    public $otheruser_is_active;
    public $otheruser_full_name;
    public $otheruser_email;
    public $otheruser_role_id;
    public $otheruser_created;
    public $otheruser_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblOtherUsers;

    public function __construct($db)
    {
        $this->connection    = $db;
        $this->tblOtherUsers = "other_users";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblOtherUsers} (";
            $sql .= " otheruser_is_active, otheruser_full_name, otheruser_email,";
            $sql .= " otheruser_role_id, otheruser_created, otheruser_updated";
            $sql .= ") values (";
            $sql .= " :otheruser_is_active, :otheruser_full_name, :otheruser_email,";
            $sql .= " :otheruser_role_id, :otheruser_created, :otheruser_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "otheruser_is_active" => $this->otheruser_is_active,
                "otheruser_full_name" => $this->otheruser_full_name,
                "otheruser_email"     => $this->otheruser_email,
                "otheruser_role_id"   => $this->otheruser_role_id,
                "otheruser_created"   => $this->otheruser_created,
                "otheruser_updated"   => $this->otheruser_updated,
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
            $sql  = " select o.*, r.role_name from {$this->tblOtherUsers} o ";
            $sql .= " left join roles r on r.role_aid = o.otheruser_role_id ";
            $sql .= " where true ";
            $sql .= $this->otheruser_is_active !== null && $this->otheruser_is_active !== ""
                ? " and o.otheruser_is_active = :otheruser_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " o.otheruser_full_name like :otheruser_full_name " : " ";
            $sql .= $this->search != "" ? " or o.otheruser_email    like :otheruser_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by o.otheruser_aid desc ";

            $query = $this->connection->prepare($sql);
            if ($this->otheruser_is_active !== null && $this->otheruser_is_active !== "") {
                $query->bindValue(":otheruser_is_active", $this->otheruser_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":otheruser_full_name", $search);
                $query->bindValue(":otheruser_email", $search);
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
            $sql  = " select o.*, r.role_name from {$this->tblOtherUsers} o ";
            $sql .= " left join roles r on r.role_aid = o.otheruser_role_id ";
            $sql .= " where true ";
            $sql .= $this->otheruser_is_active !== null && $this->otheruser_is_active !== ""
                ? " and o.otheruser_is_active = :otheruser_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " o.otheruser_full_name like :otheruser_full_name " : " ";
            $sql .= $this->search != "" ? " or o.otheruser_email    like :otheruser_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by o.otheruser_aid desc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->otheruser_is_active !== null && $this->otheruser_is_active !== "") {
                $query->bindValue(":otheruser_is_active", $this->otheruser_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":otheruser_full_name", $search);
                $query->bindValue(":otheruser_email", $search);
            }
            $query->execute();
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function update()
    {
        try {
            $sql  = "update {$this->tblOtherUsers} set ";
            $sql .= "otheruser_is_active = :otheruser_is_active, ";
            $sql .= "otheruser_full_name = :otheruser_full_name, ";
            $sql .= "otheruser_email     = :otheruser_email, ";
            $sql .= "otheruser_role_id   = :otheruser_role_id, ";
            $sql .= "otheruser_updated   = :otheruser_updated ";
            $sql .= "where otheruser_aid = :otheruser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "otheruser_is_active" => $this->otheruser_is_active,
                "otheruser_full_name" => $this->otheruser_full_name,
                "otheruser_email"     => $this->otheruser_email,
                "otheruser_role_id"   => $this->otheruser_role_id,
                "otheruser_updated"   => $this->otheruser_updated,
                "otheruser_aid"       => $this->otheruser_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblOtherUsers} set ";
            $sql .= "otheruser_is_active = :otheruser_is_active, ";
            $sql .= "otheruser_updated   = :otheruser_updated ";
            $sql .= "where otheruser_aid = :otheruser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "otheruser_is_active" => $this->otheruser_is_active,
                "otheruser_updated"   => $this->otheruser_updated,
                "otheruser_aid"       => $this->otheruser_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblOtherUsers} ";
            $sql .= "where otheruser_aid = :otheruser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["otheruser_aid" => $this->otheruser_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function checkEmail()
    {
        try {
            $sql  = " select otheruser_email from {$this->tblOtherUsers} ";
            $sql .= " where otheruser_email = :otheruser_email ";
            $query = $this->connection->prepare($sql);
            $query->execute(["otheruser_email" => $this->otheruser_email]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}
