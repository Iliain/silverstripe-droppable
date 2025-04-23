<?php

namespace Iliain\Droppable\Fields;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use Iliain\Droppable\Model\DroppableOption;
use SilverStripe\Forms\FormField;

/**
 * A textarea field that allows for buttons to be dragged and dropped into the textarea
 * 
 * <code>
 * DroppableField::create(
 *     $name = "description",
 *     $title = "Description",
 *     $field = "BlockTitle"
 * )->setButtonRow(1, [
 *     ['button1', 'Button 1'),
 *     ['button2', 'Button 2'),
 * ]);
 * </code>
 */
class DroppableField extends FormField
{
    /**
     * The field the buttons will be modiyfing
     *
     * @var string
     */
    protected $linkedField = null;

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
     * Set the the field to wrap an elemenet around the selected text
     *
     * @var bool
     */
    protected $wrapSelection = false;

    /**
     * The element to wrap around the selected text
     *
     * @var string
     */
    protected $wrapElement = '<span class="$2">$1</span>';

    public function __construct($name, $title = null, $field = null, $form = null)
    {
        if ($form) {
            $this->setForm($form);
        }

        if ($field) {
            $this->setLinkedField($field);
        }

        parent::__construct($name, $title);
    }

    /**
     * Set the field that the buttons will be modifying
     *
     * @param string $field
     * @return self
     */
    public function setLinkedField($field): self
    {
        $this->linkedField = $field;

        return $this;
    }

    /**
     * Get the field that the buttons will be modifying
     *
     * @return string
     */
    public function LinkedField()
    {
        return $this->linkedField;
    }

    /**
     * Tells the field to use a dropdown interface for the shortcode buttons. Useful for when there are a lot of buttons
     *
     * @param boolean $useDropdown
     * @return self
     */
    public function setUseDropdown(bool $useDropdown): self
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
     * Set the buttons to wrap the selected text
     *
     * @param string $wrapSelection
     * @return self
     */
    public function setWrapSelection(bool $wrapSelection): self
    {
        $this->wrapSelection = $wrapSelection;

        return $this;
    }

    /**
     * Get whether or not to wrap the selected text
     *
     * @return boolean
     */
    public function WrapSelection()
    {
        return $this->wrapSelection;
    }

    /**
     * Set the element to wrap around the selected text
     *
     * @param string $wrapElement
     * @return self
     */
    public function setWrapElement(string $wrapElement): self
    {
        $this->wrapElement = $wrapElement;

        return $this;
    }

    /**
     * Get the element to wrap around the selected text
     *
     * @return string
     */
    public function WrapElement($value = null)
    {
        return $this->wrapElement;
    }

    public function WrapElementValue($value)
    {
        $element = $this->wrapElement;

        if ($value) {
            $element = str_replace('$1', '', $element);
            $element = str_replace('$2', $value, $element);
        }

        return $element;
    }

    /**
     * Set selected row of buttons. If the user tries to skip row numbers, the row will be appended to the end
     *
     * @param int $row The row number being inserted into
     * @param array $buttons The array of buttons to insert
     * @return self
     */
    public function setButtonRow(int $row, array $buttons): self
    {   
        for ($i = 0; $i < count($buttons); $i++) {
            if (!$buttons[$i] instanceof DroppableOption) {
                $buttons[$i] = DroppableOption::create($buttons[$i][0], $buttons[$i][1]);
            }
        }

        $buttons = ArrayList::create($buttons);

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
    public function ButtonRows(): array
    {
        return $this->buttons;
    }

    /**
     * Get the array of buttons for a specific row
     *
     * @param int $row The row number to get
     * @return ArrayList|null
     */
    public function getButtonRow(int $row): ?ArrayList
    {
        return array_key_exists($row, $this->buttons) ? $this->buttons[$row] : null;
    }

    /**
     * Push a button to a specific row
     *
     * @param int $row The row number to push to
     * @param DroppableOption|array $button The button to push
     * @return self
     */
    public function pushButton(int $row, DroppableOption|array $button): self
    {
        $buttons = $this->getButtonRow($row);

        $button = DroppableOption::create($button[0], $button[1]);

        if (!$buttons) {
            $buttons = ArrayList::create();
            $buttons->push($button);

            $this->setButtonRow($row, $buttons->toArray());            
        } else {
            $buttons->push($button);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function Field($properties = []): string
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
    public function Type(): string
    {
        $type = 'droppable';

        return $type;
    }
}
