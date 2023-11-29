<?php

namespace Iliain\Droppable\Fields;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\TextareaField;

/**
 * A textarea field that allows for buttons to be dragged and dropped into the textarea
 * 
 * <code>
 * DroppableTextareaField::create(
 *     $name = "description",
 *     $title = "Description",
 *     $value = "This is the default description"
 * )->setButtonRow(1, [
 *     [
 *         'Value' => '{{SHORTCODE_1}}', 
 *         'Label' => 'Custom Shortcode 1'
 *     ]
 * ]);
 * </code>
 */
class DroppableTextareaField extends TextareaField
{
    /**
     * Array of buttons that will appear above the textarea
     *
     * @var array
     */
    protected $buttons = [];

    public function __construct($name, $title = null, $value = null, $form = null)
    {
        if ($form) {
            $this->setForm($form);
        }

        parent::__construct($name, $title, $value);
    }

    /**
     * Set selected row of buttons. 
     * 
     * Example of a button array
     * <code>
     * [
     *     [
     *         'Value' => '{{SHORTCODE_1}}',
     *         'Label' => 'Custom Shortcode 1'
     *     ]
     * ]
     * </code>
     *
     * @param int $row The row number being inserted into
     * @param array $buttons The array of buttons to insert
     * @return self
     */
    public function setButtonRow(int $row, array $buttons)
    {   
        $this->buttons[$row] = $buttons;

        return $this;
    }

    /**
     * Get the array of button rows
     *
     * @return array
     */
    public function getButtonRows()
    {
        return $this->buttons;
    }

    /**
     * Get the array of buttons for a specific row
     *
     * @param int $row The row number to get
     * @return array|null
     */
    public function getButtonRow(int $row)
    {
        return array_key_exists($row, $this->buttons) ? $this->buttons[$row] : null;
    }

    /**
     * Push a button to a specific row
     *
     * @param int $row The row number to push to
     * @param array $button The button to push
     * @return self
     */
    public function pushButton(int $row, array $button)
    {
        $buttons = $this->getButtonRow($row);

        if (!$buttons) {
            $buttons = [];
        }

        $buttons[] = $button;

        $this->setButtonRow($row, $buttons);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function Field($properties = [])
    {
        $buttons = $this->getButtonRows();

        if (count($buttons)) {
            $data = ArrayList::create();

            foreach ($buttons as $row => $buttons) {
                $data->push([
                    'Buttons' => ArrayList::create($buttons),
                ]);
            }

            $properties = array_merge($properties, [
                'ButtonRows' => $data,
            ]);

            Requirements::javascript('iliain/silverstripe-droppable: client/javascript/droppable.js');
            Requirements::css('iliain/silverstripe-droppable: client/css/droppable.css');
        }

        return parent::Field($properties);
    }

    /**
     * {@inheritdoc}
     */
    public function Type()
    {
        $type = 'textarea droppable';

        if ($this->readonly) {
            return $type . ' readonly';
        }

        return $type;
    }
}
