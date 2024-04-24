<?php

namespace Cineflix\App\Model;

class MovieModel extends AbstractModel
{

    private int $status = 0;

    public ?string $synopsis;
    public ?string $affiche;
    public ?string $date_sortie;
    public ?string $slug;


    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }
    public function getStatus(): string
    {
        return $this->status_list[$this->status];
    }

    public function setStatus(int $status_id): void
    {
        $this->status = (array_key_exists($status_id, $this->status_list))? $this->status_list[$status_id] : $this->status_list[0];
    }


}
