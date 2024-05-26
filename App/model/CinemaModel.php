<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Security;

class CinemaModel extends AbstractModel
{
    protected ?VilleModel $ville;
    protected int $ville_id;

    /**
     * @param array|null $data
     */
    public function __construct(?array $data)
    {
        parent::__construct($data);

        if(isset($data['ville'])) $this->ville = new VilleModel($data['ville']);

    }

    /**
     * @param $item
     *
     * @return mixed
     */
    public function __get($item): mixed
    {
        switch ($item) {
            case 'ville':
                $item = $this->$item;
                break;
            case 'ville_id':
                $item = $this->ville->id;
                break;
            default:
                $item = parent::__get($item);
                break;
        }
        return $item;
    }

    public function setVilleId(int $id): void
    {
        $this->ville_id = Security::sanitize($id);
    }

}