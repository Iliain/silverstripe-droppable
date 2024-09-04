<?php

namespace Iliain\Droppable\Model;

use SilverStripe\View\ViewableData;

class DroppableOption extends ViewableData
{
    /**
     * Label/description for the option
     * @var string
     */
    protected $label;

    /**
     * Value of the option
     * @var string
     */
    protected $value;

    /**
     * Set the ID and Value of the option, and optionally the label
     * @param string $value
     * @param string|null $label
     */
    public function __construct($value, $label = null)
    {
        $this->value = $value;

        if ($label === null) {
            $this->label = $this->value;
        } else {
            $this->label = $label;
        }
    }

    /**
     * Returns the label of the option
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the value of the option
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the label of the option
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Sets the value of the option
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
