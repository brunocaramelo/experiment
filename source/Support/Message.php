<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * FSPHP | Class Message
 *
 * @author Robson V. Leite <cursos@upinside.com.br>
 * @package Source\Core
 */
class Message {

    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var type */
    private $before;

    /** @var type */
    private $after;

    /**
     * @return string
     */
    public function __toString() {
        return $this->render();
    }

    /**
     * @return string
     */
    public function getText(): ?string {
        return $this->before . $this->text . $this->after;
    }

    /**
     * @return string
     */
    public function getType(): ?string {
        return $this->type;
    }

    /**
     * 
     * @param string $text
     * @return \Source\Support\Message
     */
    public function before(string $text): Message {
        $this->before = $text;
        return $this;
    }

    /**
     * 
     * @param string $text
     * @return \Source\Support\Message
     */
    public function after(string $text): Message {
        $this->after = $text;
        return $this;
    }

    /**
     * @param string $message
     * @return Message
     */
    public function info(string $message): Message {
        $this->text = $this->filter($message);
        return $this;
    }


    /**
     * @return string
     */
    public function render(): string {
        return "{$this->getText()}";
    }

    /**
     * @return string
     */
    public function json(): string {
        return json_encode(["error" => $this->getText()]);
    }

    /**
     * Set flash Session Key
     */
    public function flash(): void {
        (new Session())->set("flash", $this);
    }

    /**
     * @param string $message
     * @return string
     */
    private function filter(string $message): string {
        return filter_var($message, FILTER_SANITIZE_STRIPPED);
    }

}
