<?php

namespace Cineflix\App\Model;

class VilleModel extends AbstractModel
{
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

    }

    /**
     * @param string $item
     *
     * @return mixed
     */
    public function __get(string $item): mixed
    {
        switch($item) {
            case 'nom':
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