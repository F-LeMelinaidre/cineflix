<?php
    namespace Cineflix\App\DAO\List;
    enum StatusFilm: int {
        case INDISPONIBLE = 0;
        case EN_SALLE = 1;
        case EN_STREAMING = 2;
        case PROCHAINEMENT_EN_SALLE = 3;

        case PROCHAINEMENT_EN_STREAMING = 4;
        case BIENTOT_DEPROGRAMME = 5;

        /**
         * @param int $id
         *
         * @return string
         */
        public static function toString(self $status): string
        {
            return match($status)
            {
                self::INDISPONIBLE => 'Indisponibles',
                self::EN_SALLE => 'En salle',
                self::EN_STREAMING => 'En streaming',
                self::PROCHAINEMENT_EN_SALLE => 'Prochainement en salle',
                self::PROCHAINEMENT_EN_STREAMING => 'Prochainement en streaming',
                self::BIENTOT_DEPROGRAMME => 'Bientôt déprogrammé',
                default => 'Statut inconnu'
            };
        }

        /**
         * @param string $status
         *
         * @return int
         */
        public static function getStatusId(string $status): int
        {
            $status = strtoupper(str_replace(['-',' '], '_', $status));
            return match($status)
            {
                'INDISPONIBLE' => 0,
                'EN_SALLE' => 1,
                'EN_STREAMING' => 2,
                'PROCHAINEMENT_EN_SALLE' => 3,
                'PROCHAINEMENT_EN_STREAMING' => 4,
                'BIENTOT_DEPROGRAMME' => 5,
                default => 0
            };
        }

        /**
         * @param int $id
         *
         * @return StatusFilm
         */
        public static function getStatusByName(string $status): StatusFilm
        {
            $status = strtoupper(str_replace(['-',' '], '_', $status));
            return match($status)
            {
                'INDISPONIBLE' => self::INDISPONIBLE,
                'EN_SALLE' => self::EN_SALLE,
                'EN_STREAMING' => self::EN_STREAMING,
                'PROCHAINEMENT_EN_SALLE' => self::PROCHAINEMENT_EN_SALLE,
                'PROCHAINEMENT_EN_STREAMING' => self::PROCHAINEMENT_EN_STREAMING,
                'BIENTOT_DEPROGRAMME' => self::BIENTOT_DEPROGRAMME,
                default => self::INDISPONIBLE
            };
        }

        /**
         * @param int $id
         *
         * @return StatusFilm
         */
        public static function getStatusById(int $id): StatusFilm
        {
            return match($id)
            {
                0 => self::INDISPONIBLE,
                1 => self::EN_SALLE,
                2 => self::EN_STREAMING,
                3 => self::PROCHAINEMENT_EN_SALLE,
                4 => self::PROCHAINEMENT_EN_STREAMING,
                5 => self::BIENTOT_DEPROGRAMME,
                default => self::INDISPONIBLE
            };
        }

        public static function getUrlById(int $id): string
        {
            return match($id)
            {
                0 => 'Indisponible',
                1 => 'En-Salle',
                2 => 'En-Streaming',
                3 => 'Prochainement-En-Salle',
                4 => 'Prochainement-En-Streaming',
                5 => 'Bientot-Deprogramme',
                default => ''
            };
        }

        /**
         * @param StatusFilm $const
         *
         * @return string
         */
        public static function getUrlByName(self $const): string
        {
            return match($const)
            {
                self::INDISPONIBLE => 'Indisponible',
                self::EN_SALLE => 'En-Salle',
                self::EN_STREAMING => 'En-Streaming',
                self::PROCHAINEMENT_EN_SALLE => 'Prochainement-En-Salle',
                self::PROCHAINEMENT_EN_STREAMING => 'Prochainement-En-Streaming',
                self::BIENTOT_DEPROGRAMME => 'Bientot-Deprogramme',
                default => 'En-Salle'
            };
        }

        /**
         * Renvoie un tableau des status
         * index valeur de la constante
         * valeur nom de la constante en minuscule sans _
         * @return array
         */
        public static function statusToArray(): array
        {
            $constants = [];
            foreach (self::cases() as $constant) {
                $name = str_replace('_', ' ', strtolower($constant->name));

                $key = $constant->value;
                $value = $name;

                $constants[$key] = $value;
            }
            return $constants;

        }

        /**
         * @return array
         */
        public static function getUrlArray(): array
        {
            $constantNames = [];
            foreach (self::cases() as $constant) {
                $name = str_replace('_', ' ', strtolower($constant->name));

                $formattedKey = ucfirst($name);
                $formattedValue = str_replace(' ', '-', ucwords($name));
                $constantNames[$formattedKey] = $formattedValue;
            }
            return $constantNames;
        }

    }
