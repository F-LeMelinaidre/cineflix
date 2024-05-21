<?php

    namespace Cineflix\App\Model;

    class SeanceModel extends AbstractModel
    {

        private string $date;
        private string $horaire;

        /**
         * @param array|null $data
         */
        public function __construct(?array $data = null)
        {
            parent::__construct($data);

            if(isset($data['date'])) $this->date = $data['date'];
            if(isset($data['horaire'])) $this->horaire = $data['horaire'];

        }

        public function __get($item): mixed
        {

            switch ($item) {
                case 'date':
                case 'horaire':
                    $item = $this->$item;
                    break;
                case 'date_fr':
                    $item = date("d-m-Y", strtotime($this->date));
                    break;
                default:
                    $item = parent::__get($item);
            }

            return $item;
        }
    }