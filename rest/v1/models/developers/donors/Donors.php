<?php

class Donors
{
    public $donor_aid;
    public $donor_is_active;
    public $donor_full_name;
    public $donor_email;
    public $donor_contact;
    public $donor_address;
    public $donor_city;
    public $donor_state;
    public $donor_country;
    public $donor_zip;
    public $donor_created;
    public $donor_updated;

    public $start;
    public $total;
    public $search;

    public $connection;
    public $lastInsertedId;

    public $tblDonors;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblDonors  = "donors";
    }

    // CREATE
    public function create()
    {
        try {
            $sql  = "insert into {$this->tblDonors} (";
            $sql .= " donor_is_active, donor_full_name, donor_email,";
            $sql .= " donor_contact, donor_address, donor_city,";
            $sql .= " donor_state, donor_country, donor_zip,";
            $sql .= " donor_created, donor_updated";
            $sql .= ") values (";
            $sql .= " :donor_is_active, :donor_full_name, :donor_email,";
            $sql .= " :donor_contact, :donor_address, :donor_city,";
            $sql .= " :donor_state, :donor_country, :donor_zip,";
            $sql .= " :donor_created, :donor_updated";
            $sql .= ")";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_full_name" => $this->donor_full_name,
                "donor_email"     => $this->donor_email,
                "donor_contact"   => $this->donor_contact,
                "donor_address"   => $this->donor_address,
                "donor_city"      => $this->donor_city,
                "donor_state"     => $this->donor_state,
                "donor_country"   => $this->donor_country,
                "donor_zip"       => $this->donor_zip,
                "donor_created"   => $this->donor_created,
                "donor_updated"   => $this->donor_updated,
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
            $sql  = " select * from {$this->tblDonors} where true ";
            $sql .= $this->donor_is_active !== null && $this->donor_is_active !== ""
                ? " and donor_is_active = :donor_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " donor_full_name like :donor_full_name " : " ";
            $sql .= $this->search != "" ? " or donor_email    like :donor_email " : " ";
            $sql .= $this->search != "" ? " or donor_city     like :donor_city " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_aid desc ";

            $query = $this->connection->prepare($sql);
            if ($this->donor_is_active !== null && $this->donor_is_active !== "") {
                $query->bindValue(":donor_is_active", $this->donor_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":donor_full_name", $search);
                $query->bindValue(":donor_email",     $search);
                $query->bindValue(":donor_city",      $search);
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
            $sql  = " select * from {$this->tblDonors} where true ";
            $sql .= $this->donor_is_active !== null && $this->donor_is_active !== ""
                ? " and donor_is_active = :donor_is_active " : " ";
            $sql .= $this->search != "" ? " and ( " : " ";
            $sql .= $this->search != "" ? " donor_full_name like :donor_full_name " : " ";
            $sql .= $this->search != "" ? " or donor_email    like :donor_email " : " ";
            $sql .= $this->search != "" ? " or donor_city     like :donor_city " : " ";
            $sql .= $this->search != "" ? " ) " : " ";
            $sql .= " order by donor_aid desc ";
            $sql .= " limit :start, :total ";

            $query = $this->connection->prepare($sql);
            $query->bindValue(":start", (int) $this->start - 1, PDO::PARAM_INT);
            $query->bindValue(":total", (int) $this->total,     PDO::PARAM_INT);
            if ($this->donor_is_active !== null && $this->donor_is_active !== "") {
                $query->bindValue(":donor_is_active", $this->donor_is_active);
            }
            if ($this->search != "") {
                $search = "%{$this->search}%";
                $query->bindValue(":donor_full_name", $search);
                $query->bindValue(":donor_email",     $search);
                $query->bindValue(":donor_city",      $search);
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
            $sql  = "update {$this->tblDonors} set ";
            $sql .= "donor_is_active = :donor_is_active, ";
            $sql .= "donor_full_name = :donor_full_name, ";
            $sql .= "donor_email     = :donor_email, ";
            $sql .= "donor_contact   = :donor_contact, ";
            $sql .= "donor_address   = :donor_address, ";
            $sql .= "donor_city      = :donor_city, ";
            $sql .= "donor_state     = :donor_state, ";
            $sql .= "donor_country   = :donor_country, ";
            $sql .= "donor_zip       = :donor_zip, ";
            $sql .= "donor_updated   = :donor_updated ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_full_name" => $this->donor_full_name,
                "donor_email"     => $this->donor_email,
                "donor_contact"   => $this->donor_contact,
                "donor_address"   => $this->donor_address,
                "donor_city"      => $this->donor_city,
                "donor_state"     => $this->donor_state,
                "donor_country"   => $this->donor_country,
                "donor_zip"       => $this->donor_zip,
                "donor_updated"   => $this->donor_updated,
                "donor_aid"       => $this->donor_aid,
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
            $sql  = "update {$this->tblDonors} set ";
            $sql .= "donor_is_active = :donor_is_active, ";
            $sql .= "donor_updated   = :donor_updated ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "donor_is_active" => $this->donor_is_active,
                "donor_updated"   => $this->donor_updated,
                "donor_aid"       => $this->donor_aid,
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
            $sql  = "delete from {$this->tblDonors} ";
            $sql .= "where donor_aid = :donor_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute(["donor_aid" => $this->donor_aid]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }

    // CHECK EMAIL (duplicate validation)
    public function checkEmail()
    {
        try {
            $sql  = " select donor_email from {$this->tblDonors} ";
            $sql .= " where donor_email = :donor_email ";
            $query = $this->connection->prepare($sql);
            $query->execute(["donor_email" => $this->donor_email]);
        } catch (PDOException $e) {
            $query = false;
        }
        return $query;
    }
}