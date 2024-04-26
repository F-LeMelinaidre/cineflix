<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\App\DAO\AbstractDAO;

class CinemaDao extends AbstractDAO
{
    protected array $relations = [
        'hasOne' => [
            'ville' => 'cinema.ville_id = ville.id'
        ]
    ];

}