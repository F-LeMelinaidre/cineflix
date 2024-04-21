<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\DAO\AbstractDAO;
    use Cineflix\App\Model\ProfilModel;

    class ProfilDao extends AbstractDAO
    {
        protected array $relations = [
            'hasOne' => [
                'user' => 'profil.user_id = user.id'
            ]
        ];

        public function findByUserToken(string $token, array $options = null)
        {
            $test = ['connect', 'modified'];
            $options['hasOne'] =  [
                    'user' => [
                        'select' => (isset($options['user']['select'])) ? array_merge($options['user']['select'],$test) : ['*']
                    ]
            ];

            if(isset($options['user']['select'])) unset($options['user']);


            $result = $this->findOneBy(['token' => $token], $options);

            return $result;

        }

        public function update(object $profil): void
        {

            $sql = "UPDATE $this->table SET modified = CURRENT_TIMESTAMP";
            foreach ($profil as $key => $val) {
                if(!is_object($val) && $key != 'table' && $key != 'email' && $key != 'user_id') {
                    $sql .= ", $key = :$key";
                    $bindValues[] = ['col' => $key, 'val' => $val];
                }
            }
            $sql .= " WHERE user_id = :user_id";
            $bindValues[] = ['col' => 'user_id', 'val' => $profil->user_id];
            $req = $this->db->prepare($sql, $bindValues);
        }
    }