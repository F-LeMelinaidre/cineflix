<?php

    namespace Cineflix\App\model;

    use Cineflix\Core\Util\Regex;
    use Cineflix\Core\Util\Security;

    class AbstractModel
    {

        private array $validation_items;

        protected ?int $id = null;
        protected ?string $nom = null;
        protected string $created;
        protected string $modified;
        protected array $errors = [];



        /**
         * @param array|null $data
         */
        public function __construct(?array $data)
        {
            if(isset($data['id'])) $this->id = $data['id'];
            if(isset($data['created'])) $this->created = $data['created'];
            if(isset($data['modified'])) $this->modified = $data['modified'];
            if(isset($data['nom'])) $this->nom = $data['nom'];

        }

        public function __get(string $item): mixed
        {
            switch($item) {
                case 'id':
                case 'nom':
                case 'created':
                case 'modified':
                    $item = $this->$item;
                    break;

                case 'created_fr':
                    $item = $this->getDateHeureFr($this->created);
                    break;
                case 'modified_fr':
                    $item = $this->getDateHeureFr($this->modified);
                    break;

                default:
                    $item ='';
            }
            return $item;
        }

        /**
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }

        /**
         * @param int $id
         * @return void
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }

        /**
         * @param string $nom
         *
         * @return $this
         */
        public function setNom(string $nom): void
        {
            $this->nom = ucfirst(Security::sanitize($nom));
        }

        /**
         * @param string $date
         *
         * @return void
         */
        public function setCreated(string $date): void
        {
            $this->created = date("Y-m-d H:i:s", strtotime($date));
        }

        /**
         * @return string
         */
        public function getCreated(): string
        {
            return date("d-m-Y H:i:s", strtotime($this->created));
        }

        /**
         * @return string
         */
        public function getModified(): string
        {
            return date("d-m-Y H:i:s", strtotime($this->modified));
        }

        /**
         * @param string $date
         *
         * @return string
         */
        public function getDateFr(string $date): string
        {
            return date("d-m-Y", strtotime($date));
        }

        /**
         * @param string $date
         *
         * @return string
         */
        public function getDateHeureFr(string $date): string
        {
            return date("d-m-Y H:i:s", strtotime($date));
        }

        /**
         * @param string $item
         * @param array  $options
         *
         * @return void
         */
        public function addValidation(string $item, array $rules, array $custom_messages = null): void
        {
            $this->validation_items[$item] = [
                'rules'     => $rules,
                'messages'  => $custom_messages
            ];
        }

        /**
         * @return bool
         */
        public function isValid(): bool
        {
            foreach ($this->validation_items as $item => $rules) {
                $this->validate($item, $rules);
            }
            return empty($this->errors);
        }

        /**
         * @param $rule
         * @param $item
         *
         * @return void
         */
        private function validate(string $item, array $params)
        {
            $rules = $params['rules'];
            $messages = $params['messages'];
            $valid = true;

            foreach($rules as $rule) {

                if(!empty($this->$item) && $rule === 'equal') {
                    $item_confirm = $item."_confirm";
                    $valid = $this->$item == $this->$item_confirm;

                    $type = 'invalid';
                    $message = (isset($messages['equal']))? $messages['equal'] : "les champs ne sont pas identiques !";

                } elseif (!empty($this->$item) && $rule !== 'require') {

                    $pattern = Regex::getPattern($rule);
                    $valid = preg_match($pattern, $this->$item);

                    $type = 'error';
                    $message = (isset($messages[$rule]))? $messages[$rule] : Regex::getMessage($rule);

                } elseif(empty($this->$item) && $rule === 'require') {

                    $valid = false;
                    $type = 'invalid';
                    $message = (isset($messages['require']))? $messages['require'] : "Champ requis !";
                }

                if(!$valid ) $this->errors[$item] = ['type'   => $type,
                                                     'message' => $message];

            }
        }

        /**
         * @return array
         */
        public function getErrors(): array
        {
            return $this->errors;
        }

        public function objectToArrayWithValuesNotNull(object $model): array
        {
            return  array_filter(get_object_vars($model), function($var) {
                return !is_null($var);
            });
        }

        /**
         * @param array|null $data
         *
         * @return void
         */
        public function hydrate(array $data = null)
        {
            if(isset($data['id'])) $this->id = $data['id'];
            if(isset($data['created'])) $this->created = $data['created'];
            if(isset($data['modified'])) $this->modified = $data['modified'];
            if(isset($data['nom'])) $this->nom = $data['nom'];

        }
    }