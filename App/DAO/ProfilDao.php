<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\DAO\AbstractDAO;

    class ProfilDao extends AbstractDAO
    {
        protected array $foreign_keys = [
            'user' => 'profil.user_id = user.id'
        ];

        public function findByUserToken(string $token, array $options = null)
        {
            $select = (is_null($options))? '*' : $options['select'];

            $query = "SELECT $select FROM $this->table JOIN user ON {$this->foreign_keys['user']}  WHERE user.token = :token";

            $bindValues[] = ['col' => 'token', 'val' => $token];

            $req = $this->db->prepare($query, $bindValues);

            return $req->fetch();

        }
    }