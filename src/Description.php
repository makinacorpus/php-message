<?php

declare(strict_types=1);

namespace MakinaCorpus\Message;

/**
 * Formatted message description.
 */
class Description
{
    private string $text;
    /** @var mixed[] */
    private array $variables = [];

    public function __construct(string $text, array $variables = [])
    {
        $this->text = $text;
        $this->variables = $variables;
    }

    /**
     * Get text message.
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Get text variables.
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Default formatting procedure.
     */
    public function format(): string
    {
        if (!$this->variables) {
            return $this->text;
        }

        $replacements = [];
        foreach ($this->variables as $name => $value) {
            // We support two different formalisms:
            //   - Either "[variable]" (monolog).
            //   - Either "%variable%" (symfony translation, legacy).
            // Default being "[variable]", if enclosing parameters are missing
            // we are going to use this convention to fix it.
            if (!\str_starts_with($name, '[') && !\str_starts_with($name, '%')) {
                $replacements['[' . $name . ']'] = $value;
            } else {
                $replacements[$name] = $value;
            }
        }

        return \strtr($this->text, $replacements);
    }

    /**
     * Alias of the format() method.
     */
    public function __toString()
    {
        return $this->format();
    }
}
