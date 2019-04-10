<?php
App::uses('Parsedown', 'Utility');

class MarkdownHelper extends AppHelper {
    /**
     * @var $parsedown Parsedown
     */
    private $parsedown;

    /**
     * MarkdownHelper constructor.
     */
    public function __construct() {
        $this->parsedown = new Parsedown();
        $this->parsedown->setSafeMode(true);
    }


    public function text($text) {
        return $this->parsedown->text($text);
    }

    public function line($text) {
        return $this->parsedown->line($text);
    }
}
