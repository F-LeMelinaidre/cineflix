<?php

namespace Cineflix\App\DAO;

use Cineflix\Core\Util\MessageFlash;

class VilleDao extends AbstractDAO
{

    public function create(object $ville)
    {
        try {
            $this->db->beginTransaction();

            $data = [
                'nom'     => $ville->nom,
            ];


            $this->db->insert($this->table,$data);

            $this->last_id = $this->db->getLastInsertId();

            $this->db->commit();

            $result = true;

        } catch (\PDOException $e) {
            $result = false;

            $this->db->rollback();


            MessageFlash::create("PDOException: " . $e->getMessage(),'erreur');
        }

        return $result;

    }
}