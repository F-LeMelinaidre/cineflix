<?php

namespace Cineflix\App\Model;

use Cineflix\App\Controller\Admin\Cinema;

class MovieModel extends AbstractModel
{


    private int $cinema_id = 0;
    private int $status = 0;
    public ?CinemaModel $cinema = null;
    public ?string $ville = null;

    public ?string $synopsis;
    public ?string $affiche;
    public ?string $date_sortie;
    public ?string $slug;


    /**
     * @param array|null $data
     */
    public function __construct(?array $data = null)
    {
        parent::__construct($data);

        if(isset($data['cinema_id'])) $this->cinema_id = $data['cinema_id'];
        if(isset($data['status'])) $this->status = $data['status'];
        if(isset($data['synopsis'])) $this->synopsis = $data['synopsis'];
        if(isset($data['affiche'])) $this->affiche = $data['affiche'];
        if(isset($data['date_sortie'])) $this->date_sortie = $data['date_sortie'];
        if(isset($data['slug'])) $this->slug = $data['slug'];

        if(isset($data['cinema'])) $this->setCinema($data['cinema']);
    }


    public function setCinema(array $data): void
    {
        $this->cinema = new CinemaModel($data);
    }

    /**
     * @return CinemaModel
     */
    public function getCinema(): CinemaModel
    {
        return $this->cinema;
    }

}
