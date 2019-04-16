<?php

namespace Ghanem\LaravelSmsmisr;

class SmsmisrMessage
{
    /** @var string $message */
    protected $message;
    /** @var string $from */
    protected $sender;
    /** @var string $to */
    protected $to;
    /** @var boolean $unicode */
    protected $unicode = true;

    public function __construct(string $message = '', string $to = '')
    {
        $this->message = $message;
        $this->to = $to;
        $this->sender = config('smsmisr.sender');
    }

    public function message(string $message): SmsmisrMessage
    {
        $this->message = $message;
        return $this;
    }

    public function sender(string $sender): SmsmisrMessage
    {
        $this->sender = $sender;
        return $this;
    }

    public function to(string $to): SmsmisrMessage
    {
        $this->to = $to;
        return $this;
    }

    public function unicode(bool $unicode = true): SmsmisrMessage
    {
        $this->unicode = $unicode;
        return $this;
    }

    public function __get(string $name)
    {
        switch ($name) {
            case 'message':
                return $this->unicode ? $this->message : $this->messageToGsmFormat($this->message);
                break;
            case 'to':
                return $this->to;
                break;
            case 'from':
                return $this->from;
                break;
            default:
                throw new \InvalidArgumentException();
                break;
        }
    }

    protected function messageToGsmFormat(string $message, string $replace = '?'): string
    {
        $dict = [
            '@' => "\x00",
            '£' => "\x01",
            '$' => "\x02",
            '¥' => "\x03",
            'è' => "\x04",
            'é' => "\x05",
            'ù' => "\x06",
            'ì' => "\x07",
            'ò' => "\x08",
            'Ç' => "\x09",
            'Ø' => "\x0B",
            'ø' => "\x0C",
            'Å' => "\x0E",
            'å' => "\x0F",
            'Δ' => "\x10",
            '_' => "\x11",
            'Φ' => "\x12",
            'Γ' => "\x13",
            'Λ' => "\x14",
            'Ω' => "\x15",
            'Π' => "\x16",
            'Ψ' => "\x17",
            'Σ' => "\x18",
            'Θ' => "\x19",
            'Ξ' => "\x1A",
            'Æ' => "\x1C",
            'æ' => "\x1D",
            'ß' => "\x1E",
            'É' => "\x1F",
            'Ä' => "\x5B",
            'Ö' => "\x5C",
            'Ñ' => "\x5D",
            'Ü' => "\x5E",
            '§' => "\x5F",
            '¿' => "\x60",
            'ä' => "\x7B",
            'ö' => "\x7C",
            'ñ' => "\x7D",
            'ü' => "\x7E",
            'à' => "\x7F",
            '^' => "\x1B\x14",
            '{' => "\x1B\x28",
            '}' => "\x1B\x29",
            '\\' => "\x1B\x2F",
            '[' => "\x1B\x3C",
            '~' => "\x1B\x3D",
            ']' => "\x1B\x3E",
            '|' => "\x1B\x40",
            '€' => "\x1B\x65"
        ];

        $converted = strtr($message, $dict);

        return preg_replace('/([\\xC0-\\xDF].)|([\\xE0-\\xEF]..)|([\\xF0-\\xFF]...)/m', $replace, $converted);
    }
}
