<?php

namespace Cineflix\App\model;

use Cineflix\Core\Util\Regex;

class AbstractModel
{


    protected array $validation_items;
    protected array $errors = [];
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
    public function addValidation(string $item, array $options): void
    {
        $this->validation_items[$item] = $options;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        foreach($this->validation_items as $item => $rule) {
            $this->validate($rule, $item);
        }

        return empty($this->errors);
    }

    /**
     * @param $rule
     * @param $item
     *
     * @return void
     */
    private function validate($rule, $item)
    {
        $require = in_array('require', $rule);
        $message = (isset($rule['message'])) ? $rule['message'] : null;
        $rule = (isset($rule['rule'])) ? $rule['rule'] : null;

        if($require && empty($this->$item)) {

            $this->errors[$item] = (isset($message['require']))? $message['require'] : "Champ requis !";

        } elseif(!empty($this->$item) && !is_null($rule) && !preg_match(Regex::getPattern($rule), $this->$item)) {
            $this->errors[$item] = (isset($message[$rule]))? $message[$rule] : Regex::getMessage($rule);
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}