<?php

namespace Iliain\Droppable\Fields;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\FieldType\DBField;
use Iliain\Droppable\Model\DroppableOption;

/**
 * A textarea field that allows for buttons to be dragged and dropped into the textarea
 * 
 * <code>
 * DroppableTextareaField::create(
 *     $name = "description",
 *     $title = "Description",
 *     $value = "This is the default description"
 * )->setButtonRow(1, [
 *     DroppableOption::create('button1', 'Button 1'),
 * ])
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

    /**
     * Whether or not to use a dropdown for the buttons
     *
     * @var boolean
     */
    protected $useDropdown = false;

    /**
     * Description to appear to the left of the textarea, beneath the title
     *
     * @var string
     */
    protected $leftDescription;

    public function __construct($name, $title = null, $value = null, $form = null)
    {
        if ($form) {
            $this->setForm($form);
        }

        parent::__construct($name, $title, $value);
    }

    /**
     * Tells the field to use a dropdown interface for the shortcode buttons. Useful for when there are a lot of buttons
     *
     * @param boolean $useDropdown
     * @return self
     */
    public function setUseDropdown(bool $useDropdown)
    {
        $this->useDropdown = $useDropdown;

        return $this;
    }

    /**
     * Get whether or not to use a dropdown interface for the shortcode buttons
     *
     * @return boolean
     */
    public function UseDropdown()
    {
        return $this->useDropdown;
    }

    /**
     * Set the description to appear to the left of the textarea, beneath the title
     *
     * @param string|DBField $leftDescription
     * @return self
     */
    public function setLeftDescription(string $leftDescription)
    {
        $this->leftDescription = $leftDescription;

        return $this;
    }

    /**
     * Get the description to appear to the left of the textarea, beneath the title
     *
     * @return string
     */
    public function LeftDescription()
    {
        return $this->leftDescription;
    }

    /**
     * Set selected row of buttons. If the user tries to skip row numbers, the row will be appended to the end
     *
     * @param int $row The row number being inserted into
     * @param array $buttons The array of buttons to insert
     * @return self
     */
    public function setButtonRow(int $row, ArrayList $buttons)
    {   
        if (array_key_exists($row - 1, $this->buttons)) {
            $this->buttons[$row] = $buttons;
        } else {
            $this->buttons[] = $buttons;
        }

        return $this;
    }

    /**
     * Get the array of button rows
     *
     * @return array
     */
    public function ButtonRows()
    {
        return $this->buttons;
    }

    /**
     * Get the array of buttons for a specific row
     *
     * @param int $row The row number to get
     * @return ArrayList|null
     */
    public function getButtonRow(int $row)
    {
        return array_key_exists($row, $this->buttons) ? $this->buttons[$row] : null;
    }

    /**
     * Push a button to a specific row
     *
     * @param int $row The row number to push to
     * @param DroppableOption $button The button to push
     * @return self
     */
    public function pushButton(int $row, DroppableOption $button)
    {
        $buttons = $this->getButtonRow($row);

        if (!$buttons) {
            $buttons = ArrayList::create();
            $buttons->push($button);

            $this->setButtonRow($row, $buttons);            
        } else {
            $buttons->push($button);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function Field($properties = [])
    {
        $buttonRows = $this->ButtonRows();

        if (count($buttonRows)) {
            $data = ArrayList::create();

            for ($i = 0; $i < count($buttonRows); $i++) {
                $data->push(ArrayData::create([
                    'RowNumber' => $i,
                    'Buttons' => $buttonRows[$i]
                ]));
            }
            
            $properties = array_merge($properties, [
                'UseDropdown'       => $this->UseDropdown(),
                'LeftDescription'   => $this->LeftDescription(),
                'ButtonRows'        => $data
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
