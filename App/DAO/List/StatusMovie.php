<?php
    namespace Cineflix\App\DAO\List;
    enum StatusMovie: int {
        case INDISPONIBLE = 0;
        case EN_SALLE = 1;
        case EN_STREAMING = 2;
        case PROCHAINEMENT_EN_SALLE = 3;

        case PROCHAINEMENT_EN_STREAMING = 4;

        /**
         * @param int $id
         *
         * @return string
         */
        public static function toString(int $id): string
        {
            return match($id)
            {
                0 => 'Indisponibles',
                1 => 'en Salle',
                2 => 'en Streaming',
                3 => 'prochainement en Salle',
                4 => 'prochainement en Streaming',
                default => 'statut inconnu'
            };
        }

        /**
         * @param int $id
         *
         * @return self
         */
        public static function getStatus(string $status): int
        {
            $status = strtoupper(str_replace(['-',' '], '_', $status));
            return match($status)
            {
                'INDISPONIBLE' => 0,
                'EN_SALLE' => 1,
                'EN_STREAMING' => 2,
                'PROCHAINEMENT_EN_SALLE' => 3,
                'PROCHAINEMENT_EN_STREAMING' => 4,
                default => 0
            };
        }

        public static function getUrl(int $id): string
        {
            return match($id)
            {
                0 => 'Indisponible',
                1 => 'En-Salle',
                2 => 'En-Streaming',
                3 => 'Prochainement-En-Salle',
                4 => 'Prochainement-En-Streaming',
                default => ''
            };
        }
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
