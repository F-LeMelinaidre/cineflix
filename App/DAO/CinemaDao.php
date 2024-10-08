<?php

namespace Cineflix\App\DAO;

use Cineflix\Core\Util\MessageFlash;

class CinemaDao extends AbstractDAO
{

    public function create(object $cinema)
    {
        try {

            $this->db->beginTransaction();

            $data = [
                'nom'      => $cinema->nom,
                'ville_id' => $cinema->ville_id,
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