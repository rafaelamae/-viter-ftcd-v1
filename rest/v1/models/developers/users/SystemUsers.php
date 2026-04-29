<?php

class SystemUsers
{
    public $sysuser_aid;
    public $sysuser_is_active;
    public $sysuser_full_name;
    public $sysuser_email;
    public $sysuser_role_id;
    public $sysuser_created;
    public $sysuser_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblSystemUsers;

    public function __construct($db)
    {
        $this->connection     = $db;
        $this->tblSystemUsers = "system_users";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblSystemUsers} (";
            $sql .= " sysuser_is_active, sysuser_full_name, sysuser_email,";
            $sql .= " sysuser_role_id, sysuser_created, sysuser_updated";
            $sql .= ") values (";
            $sql .= " :sysuser_is_active, :sysuser_full_name, :sysuser_email,";
            $sql .= " :sysuser_role_id, :sysuser_created, :sysuser_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sysuser_is_active" => $this->sysuser_is_active,
                "sysuser_full_name" => $this->sysuser_full_name,
                "sysuser_email"     => $this->sysuser_email,
                "sysuser_role_id"   => $this->sysuser_role_id,
                "sysuser_created"   => $this->sysuser_created,
                "sysuser_updated"   => $this->sysuser_updated,
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
            $sql  = " select s.*, r.role_name from {$this->tblSystemUsers} s ";
            $sql .= " left join roles r on r.role_aid = s.sysuser_role_id ";
            $sql .= " where true ";
            $sql .= $this->sysuser_is_active !== null && $this->sysuser_is_active !== ""
                ? " and s.sysuser_is_active = :sysuser_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " s.sysuser_full_name like :sysuser_full_name " : " ";
            $sql .= $this->search != "" ? " or s.sysuser_email    like :sysuser_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by s.sysuser_aid desc ";

            $query = $this->connection->prepare($sql);
            if ($this->sysuser_is_active !== null && $this->sysuser_is_active !== "") {
                $query->bindValue(":sysuser_is_active", $this->sysuser_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":sysuser_full_name", $search);
                $query->bindValue(":sysuser_email", $search);
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
            $sql  = " select s.*, r.role_name from {$this->tblSystemUsers} s ";
            $sql .= " left join roles r on r.role_aid = s.sysuser_role_id ";
            $sql .= " where true ";
            $sql .= $this->sysuser_is_active !== null && $this->sysuser_is_active !== ""
                ? " and s.sysuser_is_active = :sysuser_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " s.sysuser_full_name like :sysuser_full_name " : " ";
            $sql .= $this->search != "" ? " or s.sysuser_email    like :sysuser_email " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by s.sysuser_aid desc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->sysuser_is_active !== null && $this->sysuser_is_active !== "") {
                $query->bindValue(":sysuser_is_active", $this->sysuser_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":sysuser_full_name", $search);
                $query->bindValue(":sysuser_email", $search);
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
            $sql  = "update {$this->tblSystemUsers} set ";
            $sql .= "sysuser_is_active = :sysuser_is_active, ";
            $sql .= "sysuser_full_name = :sysuser_full_name, ";
            $sql .= "sysuser_email     = :sysuser_email, ";
            $sql .= "sysuser_role_id   = :sysuser_role_id, ";
            $sql .= "sysuser_updated   = :sysuser_updated ";
            $sql .= "where sysuser_aid = :sysuser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sysuser_is_active" => $this->sysuser_is_active,
                "sysuser_full_name" => $this->sysuser_full_name,
                "sysuser_email"     => $this->sysuser_email,
                "sysuser_role_id"   => $this->sysuser_role_id,
                "sysuser_updated"   => $this->sysuser_updated,
                "sysuser_aid"       => $this->sysuser_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblSystemUsers} set ";
            $sql .= "sysuser_is_active = :sysuser_is_active, ";
            $sql .= "sysuser_updated   = :sysuser_updated ";
            $sql .= "where sysuser_aid = :sysuser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sysuser_is_active" => $this->sysuser_is_active,
                "sysuser_updated"   => $this->sysuser_updated,
                "sysuser_aid"       => $this->sysuser_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblSystemUsers} ";
            $sql .= "where sysuser_aid = :sysuser_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["sysuser_aid" => $this->sysuser_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function checkEmail()
    {
        try {
            $sql  = " select sysuser_email from {$this->tblSystemUsers} ";
            $sql .= " where sysuser_email = :sysuser_email ";
            $query = $this->connection->prepare($sql);
            $query->execute(["sysuser_email" => $this->sysuser_email]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}
