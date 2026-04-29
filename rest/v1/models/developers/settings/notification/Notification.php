<?php

class Notification
{
    public $noti_aid;
    public $noti_is_active;
    public $noti_name;
    public $noti_email;
    public $noti_phone;
    public $noti_purpose;
    public $noti_created;
    public $noti_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblNotification;

    public function __construct($db)
    {
        $this->connection      = $db;
        $this->tblNotification = "notification";
    }

    public function create()
    {
        try {
            $sql  = "insert into {$this->tblNotification} (";
            $sql .= " noti_is_active, noti_name, noti_email, noti_phone, noti_purpose,";
            $sql .= " noti_created, noti_updated";
            $sql .= ") values (";
            $sql .= " :noti_is_active, :noti_name, :noti_email, :noti_phone, :noti_purpose,";
            $sql .= " :noti_created, :noti_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "noti_is_active" => $this->noti_is_active,
                "noti_name"      => $this->noti_name,
                "noti_email"     => $this->noti_email,
                "noti_phone"     => $this->noti_phone,
                "noti_purpose"   => $this->noti_purpose,
                "noti_created"   => $this->noti_created,
                "noti_updated"   => $this->noti_updated,
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
            $sql  = " select * from {$this->tblNotification} where true ";
            $sql .= $this->noti_is_active !== null && $this->noti_is_active !== ""
                ? " and noti_is_active = :noti_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " noti_name like :noti_name " : " ";
            $sql .= $this->search != "" ? " or noti_email like :noti_email " : " ";
            $sql .= $this->search != "" ? " or noti_purpose like :noti_purpose " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by noti_aid asc ";

            $query = $this->connection->prepare($sql);
            if ($this->noti_is_active !== null && $this->noti_is_active !== "") {
                $query->bindValue(":noti_is_active", $this->noti_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":noti_name", $search);
                $query->bindValue(":noti_email", $search);
                $query->bindValue(":noti_purpose", $search);
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
            $sql  = " select * from {$this->tblNotification} where true ";
            $sql .= $this->noti_is_active !== null && $this->noti_is_active !== ""
                ? " and noti_is_active = :noti_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " noti_name like :noti_name " : " ";
            $sql .= $this->search != "" ? " or noti_email like :noti_email " : " ";
            $sql .= $this->search != "" ? " or noti_purpose like :noti_purpose " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by noti_aid asc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total, PDO::PARAM_INT);
            if ($this->noti_is_active !== null && $this->noti_is_active !== "") {
                $query->bindValue(":noti_is_active", $this->noti_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":noti_name", $search);
                $query->bindValue(":noti_email", $search);
                $query->bindValue(":noti_purpose", $search);
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
            $sql   = " select * from {$this->tblNotification} where noti_is_active = 1 order by noti_name asc ";
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
            $sql  = "update {$this->tblNotification} set ";
            $sql .= "noti_is_active = :noti_is_active, ";
            $sql .= "noti_name      = :noti_name, ";
            $sql .= "noti_email     = :noti_email, ";
            $sql .= "noti_phone     = :noti_phone, ";
            $sql .= "noti_purpose   = :noti_purpose, ";
            $sql .= "noti_updated   = :noti_updated ";
            $sql .= "where noti_aid = :noti_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "noti_is_active" => $this->noti_is_active,
                "noti_name"      => $this->noti_name,
                "noti_email"     => $this->noti_email,
                "noti_phone"     => $this->noti_phone,
                "noti_purpose"   => $this->noti_purpose,
                "noti_updated"   => $this->noti_updated,
                "noti_aid"       => $this->noti_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function active()
    {
        try {
            $sql  = "update {$this->tblNotification} set ";
            $sql .= "noti_is_active = :noti_is_active, ";
            $sql .= "noti_updated   = :noti_updated ";
            $sql .= "where noti_aid = :noti_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "noti_is_active" => $this->noti_is_active,
                "noti_updated"   => $this->noti_updated,
                "noti_aid"       => $this->noti_aid,
            ]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    public function delete()
    {
        try {
            $sql  = "delete from {$this->tblNotification} ";
            $sql .= "where noti_aid = :noti_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["noti_aid" => $this->noti_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}
