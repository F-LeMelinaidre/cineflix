<?php

namespace Cineflix\App\Model;

class CinemaModel extends AbstractModel
{
    public ?VilleModel $ville;


    /**
     * @param array|null $data
     */
    public function __construct(?array $data)
    {
        parent::__construct($data);

        if(isset($data['ville'])) $this->ville = new VilleModel($data['ville']);

    }

}