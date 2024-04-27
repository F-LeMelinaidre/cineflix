<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\Model\ProfilModel;
    use Cineflix\Core\Database\Database;

    class ProfilDao extends AbstractDAO
    {
        protected array $relations = [
            'hasOne' => [
                'user' => 'profil.user_id = user.id'
            ]
        ];

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

        public function update(object $profil, string $id_column = 'user_id'): Database
        {
            return parent::update($profil, $id_column);
        }
    }