<?php

    namespace Cineflix\Core\Util;

    class GenerateIdentifiant
    {
        private string $prefix;
        private string $separator;
        private int $length;

        private array $additional_prefix = [];

        public function __construct(string $prefix = null, string $separator = null, int $length = 10)
        {
            $this->prefix = $prefix;
            $this->separator = $separator;
            $this->length = $length;
        }

        public function additionalPrefix(string $prefix, int $length = 1): self
        {
            $this->additional_prefix[] = [ 'value' =>str_replace(' ', '', $prefix),
                                            'length' => $length ];
            return $this;
        }

        public function getIdentifiant(): string
        {

            return $this->generate();
        }

        private function generate(): string
        {
            $id = [];

            if(!is_null($this->prefix)) $id[] = $this->prefix;
            if(!is_null($this->additional_prefix)) {

                $prefix_add = '';
                foreach ($this->additional_prefix as $prefix) {
                    $prefix_add .= strtoupper(substr($prefix['value'], 0, $prefix['length']));
                }
                $id[] = $prefix_add;
            }

            $id[] = $this->createId();

            $separator = ($this->separator) ?? '';

            return implode($separator, $id) ;
        }

        private function createId(): string
        {
            $id = sha1(uniqid(microtime(), true).$_SERVER['REMOTE_ADDR']);
            return substr($id, 0, $this->length);
        }

    }