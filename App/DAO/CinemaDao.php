<?php

namespace Cineflix\App\Model\DAO;

class CinemaDao
{
    protected array $relations = [
        'hasOne' => [
            'ville' => 'cinema.ville_id = ville.id'
        ]
    ];

}