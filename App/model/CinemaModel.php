<?php

namespace Cineflix\App\Model;

class CinemaModel extends AbstractModel
{
    protected ?VilleModel $ville;


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
            default:
                $item = parent::__get($item);
                break;
        }
        return $item;
    }

}