php-sbdata
==========
In nearly all web applications that I have developed so far, I often have to
display (collections of) data as well as giving users the option to modify it.

Implementing such features is often more complicated than expected. For example,
data might have to be presented in mutiple ways, we need to define forms that
give users the ability to submit data, submitted data must checked and validated,
and we need proper error reporting.

This library provides abstractions to make the development of such features more
convenient.

Installation
============
This package can be embedded in any PHP project by using
[PHP composer](https://getcomposer.org). Add the following items to your
project's `composer.json` file:

```json
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/svanderburg/php-sbdata.git"
    }
  ],

  "require": {
    "svanderburg/php-sbdata": "@dev",
  }
}
```

and run:

```bash
$ composer install
```

Installing development dependencies
===================================
When it is desired to modify the code or run the examples inside this
repository, the development dependencies must be installed by opening
the base directory and running:

```bash
$ composer install
```

Usage
=====
The abstactions in this library can be used in a straight forward way. First,
you must define a _model_ for either a field that encodes a single data element,
a form that encodes multiple fields, or a table that encodes multiple forms.

The model can be used for two purposes -- it can be used to *check* and validate
whether data is correct and be used to *view* collections of data in various ways,
such as a collection of input fields.

Defining a field model
----------------------
Every data element can be encoded as a `Field` instance. For example, the
following code example defines an e-mail field meaning that a data element should
be validated and displayed as such:

```php
use SBData\Model\Field\EmailField;

$field = new EmailField("Email"); // Defines an e-mail field with title: 'Email'
```

Checking the validity of a value
--------------------------------
One of the use cases of an `Field` instance is to validate values. We can use the
earlier `EmailField` instance to check whether a provided e-mail adresses is
valid:

```php
$field->value = "hello@world.com";
$valid = $field->checkField("email"); // Returns true, since it's valid
```

Displaying a field
------------------
Another use case is to display a field, which can be done in various ways. The
following code fragment simply displays a field in an appropriate way:

```php
\SBData\View\HTML\Field\displayField($field); // Displays an e-mail hyperlink
```

Another option is to generate an editable field so that a user can provide his
own value for it through a web browser. The following code fragment generates an
input element from the `EmailField` object:

```php
\SBData\View\HTML\Field\displayEditableField("email", $field); // Displays a text input field with name: 'email'
```

Defining a form model
---------------------
Usually fields are not very useful on their own. One of the primary goals of this
library is to encapsulate multiple fields into forms. For example:

```php
use SBData\Model\Form;
use SBData\Model\Field\CheckBoxField;
use SBData\Model\Field\DateField;
use SBData\Model\Field\EmailField;
use SBData\Model\Field\NumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\TextAreaField;
use SBData\Model\Field\URLField;
use SBData\Model\Field\ComboBoxField\ArrayComboBoxField;

$form = new Form(array(
    "firstname" => new TextField("First name", true),
    "lastname" => new TextField("Last name", true),
    "address" => new TextField("Street", true),
    "number" => new NumericIntTextField("House number", true),
    "zipcode" => new TextField("Zipcode", true, 6, 6),
    "phone" => new TextField("Phone", false, 10, 10),
    "city" => new TextField("City", true),
    "country" => new ArrayComboBoxField("Country", array("Netherlands", "Belgium"), true),
    "email" => new EmailField("Email"),
    "homepage" => new URLField("Homepage"),
    "birthdate" => new DateField("Birth date", true, true),
    "drivinglicense" => new CheckBoxField("Driving license", false, "1"),
    "comments" => new TextAreaField("Comments", false, 30, 15)
));
```

The above fragment defines a form that is used to encode a person and his
address. As can be observed, it encapsulates various kinds of fields each having
their own validation and display procedures.

Some fields in the above example are considered mandatory, which means that their
values cannot be empty or `null`. Moreover, some fields have a preferred and
maximum length.

Checking object validity
------------------------
A `Form` instance can be used to check whether some aribitrary object (actually
an associative array) is valid. For example, the following example yields false:

```php
$address = array(
    "firstname" => "Sander",
    "lastname" => "van der Burg",
    "address" => "Some street",
    "number" => "1",
    "zipcode" => "1234AB",
    "phone" => "0123456789",
    "city" => "Some city",
    "country" => "Netherlands",
    "email" => "foo", // Invalid email address
    "homepage" => "http://foo.bar",
    "birthdate" => "1984-01-01",
    "drivinglicense" => "1",
    "comments" => ""
);

$form->importValues($address); // Set all the values of the fields in the form
$form->checkFields(); // Check the validity of every field in the form
$valid = $form->checkValid(); // Yields false, because the email address is not valid
```

The fact that the `Form::importValues()` function takes an associative array as
parameter is quite convenient. For example, we can also do the following:

```php
$form->importValues($_POST);
```

to set the applicable values in the form to those that have been provided through
`POST` parameters and to check them.

Displaying a form
-----------------
After setting the values in a form (and after optionally checking them), we can
display a form including the data. The following function invocation simply
displays the form values:

```php
\SBData\View\HTML\displayForm($form);
```

The above function also automatically formats the fields. For example, the
`homepage` value is displayed as a hyperlink.

Displaying an editable form
---------------------------
We can also display an editable variant of the same form:

```php
\SBData\View\HTML\displayEditableForm($form,
    "Submit",
    "One or more fields are incorrectly specified and marked with a red color!",
    "This field is incorrectly specified!");
```

The above function invocation generates a `form` element which action URL points
to the same page. The form contains the corresponding `input` elements generated
from the fields and displays the field values so that they can be modified.

If any of the form fields are not valid, then an error message is displayed that
is provided through the third function parameter. For each invalid field, the
error message provided by the fourth parameter is shown.

Defining an array table model
-----------------------------
We can also construct `Table` objects to validate and display data collections.

There are two kinds of tables supported by this library. The following example
implements an object that is an instance of `ArrayTable` that can be used to
validate and display arrays of objects:

```php
use SBData\Model\Table\ArrayTable;

$table = new ArrayTable(array(
    "firstname" => new TextField("First name", true),
    "lastname" => new TextField("Last name", true),
    "address" => new TextField("Street", true),
    "number" => new NumericIntTextField("House number", true),
    "zipcode" => new TextField("Zipcode", true, 6, 6),
    "phone" => new TextField("Phone", false, 10, 10),
    "city" => new TextField("City", true),
    "country" => new ArrayComboBoxField("Country", array("Netherlands", "Belgium"), true),
    "email" => new EmailField("Email"),
    "homepage" => new URLField("Homepage"),
    "birthdate" => new DateField("Birth date", true, true),
    "drivinglicense" => new CheckBoxField("Driving license", false, "1"),
    "comments" => new TextAreaField("Comments", false, 30, 15)
));
```

The above model is a table equivalent of the form shown earlier uses exactly the
same fields.

To be able to actually show data, we must configure the table by setting the
`$rows` attribute:

```php
$table->setRows(array(
    array("firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some street", "number" => "1", "zipcode" => "1234AB", "phone" => "0123456789", "city" => "Some city", "country" => "Netherlands", "email" => "sander@sander.com", "homepage" => "http://foo.bar", "comments" => ""),
    array("firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some street", "number" => "2", "zipcode" => "1234AB", "phone" => "0123456789", "city" => "Some city", "country" => "Netherlands", "email" => "sander@sander.com", "homepage" => "http://foo.bar", "comments" => ""),
    array("firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some street", "number" => "3", "zipcode" => "1234AB", "phone" => "0123456789", "city" => "Some city", "country" => "Netherlands", "email" => "sander@sander.com", "homepage" => "http://foo.bar", "comments" => "")
));
```

The `rows` attribute refers to an array consisting of arrays that encodes cell
values for each row.

Defining a database table model
-------------------------------
Besides arrays we can also construct a table (objects that are instances of
`DBTable` that work on records stored in a relational database:

```php
use SBData\Model\Table\DBTable;

$table = new DBTable(array(
    "PERSON_ID" => new HiddenField("Id", true),
    "firstname" => new TextField("First name", true),
    "lastname" => new TextField("Last name", true),
    "address" => new TextField("Street", true),
    "number" => new NumericIntTextField("House number", true),
    "zipcode" => new TextField("Zipcode", true, 6, 6),
    "phone" => new TextField("Phone", false, 10, 10),
    "city" => new TextField("City", true),
    "country" => new ArrayComboBoxField("Country", array("Netherlands", "Belgium"), true),
    "email" => new EmailField("Email"),
    "homepage" => new URLField("Homepage"),
    "birthdate" => new DateField("Birth date", true, true),
    "drivinglicense" => new CheckBoxField("Driving license", false, "1"),
    "comments" => new TextAreaField("Comments", false, 30, 15)
));
```

The above example is nearly identical to the `ArrayTable`, except that it adds
the `PERSON_ID` column that serves as a primary key.

The schema of the relational database that this example works on, could have the
following structure:

```sql
create table persons
( PERSON_ID      INTEGER      NOT NULL,
  firstname      VARCHAR(255) NOT NULL check(firstname <> ''),
  lastname       VARCHAR(255) NOT NULL check(lastname <> ''),
  address        VARCHAR(255) NOT NULL check(address <> ''),
  number         INTEGER      NOT NULL,
  zipcode        VARCHAR(6)   NOT NULL check(zipcode <> ''),
  city           VARCHAR(255) NOT NULL check(city <> ''),
  country        VARCHAR(255) NOT NULL check(country in ('Netherlands', 'Belgium')),
  email          VARCHAR(255) NOT NULL check(email <> ''),
  homepage       VARCHAR(255),
  birthdate      DATE         NOT NULL,
  drivinglicense TINYINT      NOT NULL,
  comments       TEXT,
  PRIMARY KEY(PERSON_ID)
);
```

By composing a [PDOStatement](http://www.php.net/manual/en/class.pdostatement.php),
executing it, and attaching it to the table, you can display the results from the
database:

```php
/* Do some database intialisation first somewhere */

/* Compose a statment that queries the persons */
$stmt = $dbh->prepare("select * from persons order by PERSON_ID");
$stmt->execute();

/* Attach the statement to the table */
$table->stmt = $stmt;
```

Displaying a table
------------------
A table including its records can be displayed in a straight forward way:

```php
\SBData\View\HTML\displayTable($table);
```

The above function invocation composes a `table` element with rows, headers and
table cells. It also formats each cell according to their type.

Displaying a table with basic editing capablities
-------------------------------------------------
We may also want to add basic editing capabilities to a table, such as a delete
link for each table row. However, there is no way to implement a generic delete
operation.

To support deletes we must implement an *action* function that returns a string
representing the link to a delete URL:

```php
function deletePersonLink(Form $form)
{
    return "?__operation=delete&amp;PERSON_ID=".$form->fields["PERSON_ID"]->value;
}
```

An action function is a function taking a `Form` as parameter, which can be used
to retrieve the values of the corresponding table row. In this example, we return
a link to the same page that sets the `__operation` and `PERSON_ID` `GET`
parameters.

Action links can be attached to a table by providing a second array parameter:

```php
$table = new DBTable(array(
    "PERSON_ID" => new HiddenField("Id", true),
    "firstname" => new TextField("First name", true),
    "lastname" => new TextField("Last name", true),
    "address" => new TextField("Street", true),
    "number" => new NumericIntTextField("House number", true),
    "zipcode" => new TextField("Zipcode", true, 6, 6),
    "phone" => new TextField("Phone", false, 10, 10),
    "city" => new TextField("City", true),
    "country" => new ArrayComboBoxField("Country", array("Netherlands", "Belgium"), true),
    "email" => new EmailField("Email"),
    "homepage" => new URLField("Homepage"),
    "birthdate" => new DateField("Birth date", true, true),
    "drivinglicense" => new CheckBoxField("Driving license", false, "1"),
    "comments" => new TextAreaField("Comments", false, 30, 15)
), array(
    "Delete" => "deletePersonLink"
));
```

In the above example, we create a link with label: "Delete" that refers to a
page executing the delete operation.

To display a table with action links, you must use the following function
invocation:

```php
\SBData\View\HTML\displaySemiEditableTable($table);
```

In addition to a delete link, we can use the action array to define other kinds
of operations as well.

Displaying an editable table
----------------------------
We can also compose an editable grid to make every cell in the table editable:

```php
\SBData\View\HTML\displayEditableTable($table, $submittedForm);
```

The above function composes `div` elements with classes corresponding to table
rows, headers and cells. With some CSS code
(e.g. `.td { display: table-cell; }`) you can make the resulting code look like a
table.

Every virtual table row is in fact a form that passes its values to the same page
as `POST` parameters. The `$submittedForm` parameter refers to the form that is
used to process and validate these values.

If the provided `$submittedForm` is an invalid form, then the invalid table cells
are marked as such, using the `invalid` style class. You can use CSS to give it a
visually distinct appearance, such as a red border. If `$submittedForm` is `null`
then the table is just being rendered without any error markings.

Furthermore, the view function adds an additional hidden input field to each
table row named `__id` so that you know which row has been modified.

Constructing a form from a table definition
--------------------------------------------
After submitting changes through a form in a table row, you may want to validate
the user's input before doing anything with it, like ordinary forms. To perform
validation, you can construct a form out of the table's column definition:

```php
$submittedForm = $table->constructForm();
```

After constructing the form you can, for example, import the `$_POST` object into
it and check its validity. The recipe is exactly the same as described earlier in
the form examples shown earlier.

Displaying links for foreign keys
---------------------------------
Some entities may have relationships with other entities. For a record having a
relation with another record (typically through a foreign key), you may want to
display a link that redirects the user to the related record.

By constructing a `KeyLinkField` we can compose such a link, for example:

```php
function composeBookLink(KeyLinkField $field, Form $form)
{
    return "book.php?BOOK_ID=".$field->value;
}

function composePublisherLink(KeyLinkField $field, Form $form)
{
    if($form->fields["PUBLISHER_ID"]->value === null)
        return null;
    else
        return "publisher.php?PUBLISHER_ID=".$form->fields["PUBLISHER_ID"]->value;
}

$table = new DBTable(array(
    "BOOK_ID" => new KeyLinkField("Id", "composeBookLink", true, 20, 255),
    "Title" => new TextField("Title", true, 30, 255),
    "Subtitle" => new TextField("Subtitle", false, 30, 255),
    "PUBLISHER_ID" => new MetaDataField(true, 10, 10),
    "PublisherName" => new KeyLinkField("Id", "composePublisherLink", true, 20, 255)
));
```

The above example defines a table with two key link fields:

* The `BOOK_ID` field corresponds to a hyperlink of the book id redirecting the
  user to the book page displaying an individual book. It uses the
  `composeBookLink` function to construct the book's URL from the field value
  (that contains the key value).
* The `PublisherName` field corresponds to a hyperlink displaying the publisher
  name redirecting the user to a page displaying the publisher properties.
  To construct the hyperlink, we need to use the publisher's id column. Since we
  do not want to display the id, we can hide it by declaring the `PUBLISHER_ID`
  field as a `MetaDataField`. The `composePublisherLink` function composes the
  link URL and can use any field property to construct the address.
  The relationship with a publisher is optional -- if a book has no publisher
  (e.g. its key is NULL), then we can return `null` to prevent a link from being
  generated.

Using row anchors
-----------------
For tables that provide edit functionality, we may want to track which row in
the table has changed.

Typically, an action link (such as a 'delete' operation) refers to a different
page that carries out the modification and then redirects the user back to the
page displaying the table.

The inconvenience is that the browser loses knowledge about its previous scroll
position returning the user to the top of the page. This is quite inconvenient
when a page contains a table that exceeds the page height.

The editable table provides anchor links by default that can be used to track
the origins of a change. These can also be enabled for semi-editable and
"ordinary" tables by setting the `$displayAnchors` parameter to `true` (by
default it is `false`):

```php
\SBData\View\HTML\displaySemiEditableTable($table, true); // Anchor links enabled
```

When defining a form action or a `KeyLinkField`, we can use the `__id` field to
retrieve the row id:

```php
function deletePersonLink(Form $form)
{
    $rowId = $form->fields["__id"]->value; // refers to the anchor id of the row for which the action has been triggered
    return "?__operation=delete&amp;PERSON_ID=".$form->fields["PERSON_ID"]->value;
}
```

We can use a number of convenience functions to make the generation of action
links and redirections easier:

```php
use SBData\Model\Table\Anchor\AnchorRow;
```

We can use the `AnchorRow::composePreviousRowParameter()` function to compose a
`GET` parameter that refers to the previous row id -- when we delete a row, we
typically want to scroll to the position of the row that comes before it:


```php
function deletePersonLink(Form $form)
{
    return "?__operation=delete&amp;PERSON_ID=".$form->fields["PERSON_ID"]->value.AnchorRow::composePreviousRowParameter($form);
}
```

For example, when a delete operation has been triggered for the third table
row, then the above function invocation appends `&amp;__id=2` to the generated
URL.

We can use the `AnchorRow::composeRowFragment()` to compose the fragment part of
the redirection URL:

```php
header("Location: books.php".AnchorRow::composeRowFragment());
```

For example, if the above action was triggered from a row with id 2, then the
corresponding redirect header will be:

```
Location: books.php#table-row-2
```

By default, the convenience functions use `__id` as a GET parameter and
`table-row-` as prefix for the anchors. When it is desired to display multiple
tables on one page, you may want to change this prefix. This can be done by
providing a `$prefix` parameter to the above functions. See the API
documentation for more information.

Fields
======
Currently the following `Field` classes are provided by this library:

* `TextField`. Displays a field as text and text input field.
* `EmailField` Displays a field as e-mail hyperlink and text input field.
* `HiddenField`. Displays a field as hidden field.
* `KeyLinkField`. Displays a link to a page responsible for displaying an object.
* `MetaDataField`. Includes meta data (typically foreign keys) in a form that
  can be used as meta data for the key link fields.
* `NumericIntTextField`. Displays a field as text and text input field which
  only accepts numeric integer values. It is also possible to use a read-only
  variant of this field: `ReadOnlyNumericIntTextField` that is particularly
  useful for records having a numeric key that is not allowed to change.
* `TextAreaField`. Displays a field as text and text area.
* `URLField`. Displays a field as a hyperlink and text input field.
* `DateField`. Displays a field as text and validates it as a date value.
* `PasswordField`. Display a field as a password field and restricts viewing it.
* `CheckBoxField`. Displays a field as a checkbox and uses a preconfigured
  value to determine whether it has been checked or not.
* `ArrayComboBoxField`. Displays a field as text or combobox. It retrieves
  key-value pairs from an array.
* `DBComboBoxField`. Displays a field as text or combobox. It retrieves
  key-value pairs from a relational database.
* `FileField`. Displays a file path or file upload input field. It can
   optionally check if the file has the right MIME type.  It also adds the
   corresponding encoding type to the form that encapsulates it. The actual file
   can be retrieved through the `$_FILES["fieldname"]` variable.

Constructing custom fields
==========================
The field API is extendable allowing you to define your own fields for custom
validation and/or presentation. A custom field can be created by defining your
own field *model* by implementing a class that inherits from `Field` (or more
conveniently: `TextField`) and your own field *view* functions.

The constructor of your custom field needs to set the `$this->package` attribute
with the namespace that contains the corresponding view function.

The view functions must be implemented by creating a PHP module providing a
`display<className>` (for read-mode) and `displayEditable<className>`
(for write mode) functions that output the HTML code needed to display it.

This package contains an example named: `captcha` demonstrating how a custom
field can be implemented.

Examples
========
This package includes three example web applications that can be found in the
`examples/` folder:

* The `address` is an example demonstrating the capabilities of a form and the
  available form fields.
* The `upload` is an example demonstrating a simple file upload of a text file.
* The `persons` is an example demonstrating an `ArrayTable` of persons in which
  records can be updated and deleted.
* The `books` is an example demonstrating an `DBTable` of books, which can be
  created, viewed, updated and deleted. It requires the `db.sql` schema to be
  deployed to an RDBMS.
* The `captcha` is an example demonstrating how to create custom fields. In this
  example, we expose the functionality of the simple CAPTCHA API as a field.

API documentation
=================
This package includes API documentation that can be generated with
[Doxygen](https://www.doxygen.nl):

```bash
$ doxygen
```

License
=======
The contents of this package is available under the
[Apache Software License](http://www.apache.org/licenses/LICENSE-2.0.html)
version 2.0
