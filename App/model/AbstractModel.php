<?php

namespace Cineflix\App\model;

class AbstractModel
{


    protected function setDateFr(string $date): string
    {
        return date("d-m-Y H:i:s", strtotime($date));
    }
}