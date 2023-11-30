# Silverstripe Droppable Textarea

[![Latest Stable Version](http://poser.pugx.org/iliain/silverstripe-droppable/v)](https://packagist.org/packages/iliain/silverstripe-droppable) 
[![Total Downloads](http://poser.pugx.org/iliain/silverstripe-droppable/downloads)](https://packagist.org/packages/iliain/silverstripe-droppable) 
[![Latest Unstable Version](http://poser.pugx.org/iliain/silverstripe-droppable/v/unstable)](https://packagist.org/packages/iliain/silverstripe-droppable) 
[![License](http://poser.pugx.org/iliain/silverstripe-droppable/license)](https://packagist.org/packages/iliain/silverstripe-droppable) 
[![PHP Version Require](http://poser.pugx.org/iliain/silverstripe-droppable/require/php)](https://packagist.org/packages/iliain/silverstripe-droppable)

Provides a field that allows for clicking and dragging of shortcodes into a textarea

## Installation (with composer)

	composer require iliain/silverstripe-droppable

## Requirements

* PHP 7.4+ or 8.0+
* Silverstripe 4+ or 5+

## Usage

The following is an example of creating the textarea, assigning buttons to the different rows, and pushing a button to an existing row. 

```PHP
use Iliain\Droppable\Fields\DroppableTextareaField;

$droppable = DroppableTextareaField::create('Example', 'Example', 'This is an example')
    ->setRows(5)
    ->setButtonRow(0, [
        '[value,id=25]' => 'Test Value 25',
    ])
    ->setButtonRow(1, [
        '[value,id=50]' => 'Test Value 50',
    ])
    ->pushButton(1, [
        '[value,id=100]' => 'Test Value 100',
    ])
```

![Visual example of the above code](client/images/example.png)

From here, the user can either:
 * Click on a button to insert the shortcode into the start of the textarea, or the current position if the field is currently selected
 * Drag a button into the textarea to insert the shortcode at the cursor position

## License

See the [License](LICENSE).
