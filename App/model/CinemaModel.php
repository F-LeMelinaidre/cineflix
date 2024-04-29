<?php

namespace Cineflix\App\Model;

class CinemaModel extends AbstractModel
{
    public ?VilleModel $ville;


    /**
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        $ville = [];
        foreach ($data as $col => $val) {
            $parts = explode('_', $col);
            if($parts[0] === 'ville') {
                $ville[$parts[1]] = $val;
            }
        }

        if(!empty($ville)) $this->ville = new VilleModel($ville);

    }

}