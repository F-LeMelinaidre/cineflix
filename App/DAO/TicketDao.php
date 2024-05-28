<?php

    namespace Cineflix\App\DAO;

    class TicketDao extends AbstractDAO
    {

        public function count(): int
        {
            return $this->db->select('*')
                ->from($this->table)
                ->count();

        }
    }