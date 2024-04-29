<?php
    namespace Cineflix\App\DAO\List;
    enum Role: int {
        case ADHERENT = 0;
        case ADMINISTRATEUR = 1;
        case SUPER_ADMINISTRATEUR = 2;

        /**
         * @param int $id
         *
         * @return string
         */
        public static function toString(int $id): string
        {
            return match($id)
            {
                0 => 'Adhérent',
                1 => 'Administrateur',
                2 => 'Super Administrateur'
            };
        }

        /**
         * @param int $id
         *
         * @return self
         */
        public static function getRole(string $status): int
        {
            $status = strtoupper(str_replace(['-',' '], '_', $status));
            return match($status)
            {
                'ADHERENT' => 0,
                'ADMINISTRATEUR' => 1,
                'SUPER_ADMINISTRATEUR' => 2,
                default => 0
            };
        }

        /**
         * @param int $id
         *
         * @return bool
         */
        public static function exist(int $id): int {
            return in_array($id, self::getValues(), true);
        }

        private static function getValues(): array
        {
            return [
                self::ADHERENT->value,
                self::ADMINISTRATEUR->value,
                self::SUPER_ADMINISTRATEUR->value,
            ];
        }

    }
