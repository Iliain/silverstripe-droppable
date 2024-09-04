# Silverstripe Droppable Textarea

[![Latest Stable Version](https://poser.pugx.org/iliain/silverstripe-droppable/v)](https://packagist.org/packages/iliain/silverstripe-droppable) [![Total Downloads](https://poser.pugx.org/iliain/silverstripe-droppable/downloads)](https://packagist.org/packages/iliain/silverstripe-droppable) [![Latest Unstable Version](https://poser.pugx.org/iliain/silverstripe-droppable/v/unstable)](https://packagist.org/packages/iliain/silverstripe-droppable) [![License](https://poser.pugx.org/iliain/silverstripe-droppable/license)](https://packagist.org/packages/iliain/silverstripe-droppable) [![PHP Version Require](https://poser.pugx.org/iliain/silverstripe-droppable/require/php)](https://packagist.org/packages/iliain/silverstripe-droppable)

Provides a field that allows for clicking and dragging of shortcodes into a textarea. Useful for inserting shortcodes into a textarea without having to type them out.

NOTE: This only allows the insertion of shortcodes, it does not provide any functionality for parsing the shortcodes themselves.

## Installation (with composer)

	composer require iliain/silverstripe-droppable

## Requirements

* PHP 7.4+ or 8.0+
* Silverstripe 4+ or 5+

## Usage

The following is an example of creating the textarea, assigning buttons to the different rows, and pushing a button to an existing row. You can either provide each option as an array, or use the `DroppableOption::create()` method. Any array items will be automatically converted to a DroppableOption object.

```PHP
use Iliain\Droppable\Fields\DroppableTextareaField;

$droppable = DroppableTextareaField::create('Example', 'Example', 'This is an example')
    ->setRows(5)
    ->setButtonRow(0, ArrayList::create([
        DroppableOption::create('[OPTION_1]', 'Option 1'), // example of using DroppableOption
        ['[OPTION_2]', 'Option 2'], // example of using an array
    ]))
    ->setButtonRow(1, ArrayList::create([
        DroppableOption::create('[OPTION_3]', 'Option 3'),
    ]))
    ->pushButton(1, DroppableOption::create('[OPTION_4]', 'Option 4'))
    ->pushButton(1, ['[OPTION_5]', 'Option 5'])
```

 ![Animated example of the field being used](client/images/usage-example.gif)

You can also use the method `->setUseDropdown(true)` to use a dropdown instead of buttons. This will use the same data as the buttons, but will be displayed in a dropdown instead. This is useful when dealing with large amounts of buttons.

![Animated example of using the dropdown](client/images/usage-example-2.gif)

From here, the user can either:
 * Click on a button to insert the shortcode into the start of the textarea, or the current position if the field is currently selected
 * Drag a button into the textarea to insert the shortcode at the cursor position

## Functions

Has the usual functions available to a TextareaField, plus:

* `setButtonRow(int $row, ArrayList $buttons)` - Sets the buttons for a particular row. The buttons are an ArrayList of DroppableOption objects. Will overwrite any existing buttons in that row.

* `pushButton(int $row, DroppableOption $button)` - Pushes a DroppableOption button to the end of a particular row. 

* `setUseDropdown(bool $useDropdown)` - Sets whether to use a dropdown instead of rows of buttons. Defaults to false. The dropdown will use the row order as the order of the dropdown items.

* `setLeftDescription(string $description)` - Sets the description to the left of the textarea that appears under the title. Defaults to null.

## TODO

* Minify the JS and CSS
* Allow setting of default dropdown text
* Add HTMLEditorField support
