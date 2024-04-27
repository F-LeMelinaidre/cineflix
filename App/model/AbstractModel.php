<?php

    namespace Cineflix\App\model;

    use Cineflix\Core\Util\Regex;

    class AbstractModel
    {


        private array $validation_items;

        protected array $errors = [];
        protected ?int $id = null;

        public string $created;
        public string $modified;

        public ?string $nom = null;

        public function __construct(?array $data)
        {
            if(isset($data['id'])) $this->id = $data['id'];
            if(isset($data['created'])) $this->created = $data['created'];
            if(isset($data['modified'])) $this->modified = $data['modified'];
            if(isset($data['nom'])) $this->nom = $data['nom'];

        }
        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function setCreated(string $date): void
        {
            $this->created = date("Y-m-d H:i:s", strtotime($date));
        }
        public function getDateFr(string $date): string
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

            foreach($rules as $rule) {

                switch ($rule) {
                    case 'equal':
                        $item_confirm = $item."_confirm";
                        $valid = $this->$item == $this->$item_confirm;
                        $message = (isset($messages['equal']))? $messages['equal'] : "les champs ne sont pas identiques !";
                        break;

                    case 'require':
                        $valid = !empty($this->$item);
                        $message = (isset($messages['require']))? $messages['require'] : "Champ requis !";
                        break;

                    default:
                        $pattern = Regex::getPattern($rule);
                        $valid = preg_match($pattern, $this->$item);
                        $message = (isset($messages[$rule]))? $messages[$rule] : Regex::getMessage($rule);
                        break;
                }

                if(!$valid) $this->errors[$item] = $message;

            }
        }

        /**
         * @return array
         */
        public function getErrors(): array
        {
            return $this->errors;
        }

        /**
         * @param array|null $data
         *
         * @return void
         */
        public function hydrate(?array $data)
        {
            if(isset($data['id'])) $this->id = $data['id'];
            if(isset($data['created'])) $this->created = $data['created'];
            if(isset($data['modified'])) $this->modified = $data['modified'];
            if(isset($data['nom'])) $this->nom = $data['nom'];

        }
    }