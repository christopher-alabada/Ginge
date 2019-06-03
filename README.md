# Ginge
A simple PHP template engine.

## Features
- [Simple syntax](#syntax)
- [Template variables](#variables)
- [If statements](#if-statement)
- [Foreach statements](#foreach-statement)
- [Nested statements](#nested-statements)
- [Functions](#functions)
- [Templates](#templates)
- [Cache](#cache)
- [Config settings](#config-settings)

## Installation
Clone repository
```sh
git clone https://github.com/christopher-alabada/Ginge.git
```
Move Ginge folder to your project.

## Usage
Require the autoloader, instantiate Ginge, and call render()
```php
<?php
require_once "/path/to/Ginge/src/Autoload.php"

$Ginge = new Ginge\Ginge();
$output = $Ginge->render($template, $data);
```

`$template` will contain your variables, statements, and functions.
`$data` is an array of the data for your template.


### Syntax
```
{! <variable|statement|function> }
```
Syntax is an open curly brace immediately followed by exclamation mark and an ending curly brace.


### Variables
```
{!variable_name}
```
Use `{!variable_name}` in your template and add that key, value pair in the data.
For example, if you have a template variable as 'name', and its value as 'Chris', your
template will look like this: `{!name}` and your data array will look like this:
`$data = ['name' => 'Chris']`.


### If Statement
```
{!if : expression}
  // do something
{!endif}
```
The expression can be a boolean, variable, conditional, or a function. Conditional expression looks like this:
```
{!if : name == 'Chris'}
  {!name}
{!endif}
```


### Foreach Statement
```
{!foreach : expression}
  // do something
{!endforeach}
```
The expression is similar to PHP's foreach, `{!foreach : array as variable}`. Here's an example:
```php
$data = [
  'names' => [
    'Chris',
    'Kim',
    'Joe'
  ]
];
```
```
{!foreach : names as name}
  {!name}
{!endforeach}
```

Foreach statements also include `_count` and `_index` variables. Count starts at 1, and index starts at 0.
```
{!foreach : names as name}
  {!_index} {!_count}
{!endforeach}
```


### Nested Statements
```
{!if : expression}
  {!foreach : expression}
    // do something
  {!endforeach}
{!endif}
```
You can nest statements too.


### Functions
You can define functions for use in the template engine. You can use it in the if statement expression,
foreach, or even by itself. Currently, it contains isEven, isOdd, and template functions.

To define a function, like `currentTime` that displays the current time:
1. Create a file named `CurrentTime.php` in `src/Functions`. The filename must be capitalized.
2. Create a class named `CurrentTime` and extend `Functions`.
3. Must define your function in `exec($arguments)`.
```php
<?php
namespace Ginge\Functions;

class CurrentTime extends Functions
{
  protected function exec($arguments) {
    return date("h:i a");
  }
}
```


### Templates
```
{!template : <path to template>}
```
Technically this is a function, but it outputs and parses other Ginge templates. You can pass it a path to a template
file, or add the path or the actual template content to the data array.



### Cache
Ginge uses a simple cacheing system that hashes the template and data to create the key. You can disable it in Config Settings.


### Config Settings
```php
$Ginge = Ginge\Ginge(['CACHE' => false]); 
```
You can overwrite or create your own config settings when you instantiate Ginge. The above example disables cacheing.


## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
