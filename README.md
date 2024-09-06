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

The following is an example of creating the textarea, assigning buttons to the different rows, and pushing a button to an existing row. Each option/button will be an array, with the first element being the shortcode to insert, and the second being the text to display on the button.

```PHP
use Iliain\Droppable\Fields\DroppableTextareaField;

$droppable = DroppableTextareaField::create('Example', 'Example', 'This is an example')
    ->setRows(5)
    ->setButtonRow(0, [
        ['[OPTION_1]', 'Option 1'],
        ['[OPTION_2]', 'Option 2'],
    ])
    ->setButtonRow(1, [
        ['[OPTION_3]', 'Option 3']
    ])
    ->pushButton(1, ['[OPTION_4]', 'Option 4']);
```

 ![Animated example of the field being used](client/images/usage-example.gif)

You can also use the method `->setUseDropdown(true)` to use a dropdown instead of buttons. This will use the same data as the buttons, but will be displayed in a dropdown instead. This is useful when dealing with large amounts of buttons.

![Animated example of using the dropdown](client/images/usage-example-2.gif)

From here, the user can either:
 * Click on a button to insert the shortcode into the start of the textarea, or the current position if the field is currently selected
 * Drag a button into the textarea to insert the shortcode at the cursor position

## Functions

Has the usual functions available to a TextareaField, plus:

* `setButtonRow(int $row, ArrayList $buttons)` - Sets the buttons for a particular row. The buttons are an array of arrays. Will overwrite any existing buttons in that row.

* `getButtonRow(int $row)` - Gets the buttons for a particular row. Useful for modifying an existing row without just appending to the end.

* `pushButton(int $row, array $button)` - Pushes a button to the end of a particular row. Will append to an existing row, or create a new row if it doesn't exist.

* `setUseDropdown(bool $useDropdown)` - Sets whether to use a dropdown instead of rows of buttons. Defaults to false. The dropdown will use the row order as the order of the dropdown items.

* `setLeftDescription(string $description)` - Sets the description to the left of the textarea that appears under the title. Defaults to null.

## TODO

* Minify the JS and CSS
* Allow setting of default dropdown text
* Add HTMLEditorField support
