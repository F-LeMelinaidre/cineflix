<?php

    namespace Cineflix\App\Model;

    class TicketModel extends AbstractModel
    {

        protected string $ticket_id;
        private ?FilmModel $film = null;
        private ProfilModel $profil;


        public function __construct($data)
        {

            $this->film = new FilmModel($data);

            parent::__construct($data);

        }

        public function getTicketId():string
        {
            return $this->ticket_id;
        }

        public function setTicketId(int $id): void
        {
            $cid = $this->film->cinema->id;
            $vid = $this->film->cinema->ville->id;
            $fid = $this->film->id;

            $ccode = $this->film->cinema->getCode(false);
            $vcode = $this->film->cinema->ville->getCode(false);
            $fcode = $this->film->getCode(false);

            $code = [
                $id.$fid.$cid.$vid,
                $fcode.$ccode.$vcode,
                date('d-m-Y')
            ];

            $this->ticket_id = implode('_',$code);
        }
    }