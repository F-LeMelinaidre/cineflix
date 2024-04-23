<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\Model\ProfilModel;

    class ProfilDao extends AbstractDAO
    {
        protected array $relations = [
            'hasOne' => [
                'user' => 'profil.user_id = user.id'
            ]
        ];

        public function findOneBy(array $params, array $options = null): object
        {
            $result = parent::findOneBy($params,$options);

            return new ProfilModel($result);
        }
        public function findByUserToken(string $token, array $options = null)
        {
            if(isset($options['user']['select'])) {
                $options['hasOne']['user']['select'] = array_merge($options['user']['select'], ['token']);
                unset($options['user']);
            } else {
                $options['hasOne']['user']['select'] = ['id','email','token','connect','last_connect','created','modified'];
            }

            $result = $this->findOneBy(['token' => $token], $options);
            return $result;

        }

        public function update(object $profil)
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
            return $this->db->prepare($sql, $bindValues);

        }
    }