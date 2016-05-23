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
require_once("data/model/field/EmailField.class.php");

$field = new EmailField("Email"); // Defines an e-mail field with title: 'Email'
```

Checking the validity of a value
--------------------------------
One of the use cases of an `Field` instance is to validate values. We can use the
earlier `EmailField` instance to check whether a provided e-mail adresses is
valid:

```php
field->value = "hello@world.com";
$valid = field->checkField("email"); // Returns true, since it's valid
```

Displaying a field
------------------
Another use case is to display a field, which can be done in various ways. The
following code fragment simply displays a field in an appropriate way:

```php
require_once("data/view/html/field.inc.php");
displayField($field); // Displays an e-mail hyperlink
```

Another option is to generate an editable field so that a user can provide his
own value for it through a web browser. The following code fragment generates an
input element from the `EmailField` object:

```php
displayEditableField("email", $field); // Displays a text input field with name: 'email'
```

Defining a form model
---------------------
Usually fields are not very useful on their own. One of the primary goals of this
library is to encapsulate multiple fields into forms. For example:

```php
require_once("data/model/Form.class.php");

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
an associative array) is valid. For example the following example yields false:

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
require_once("data/view/html/form.inc.php");

displayForm($form);
```

The above function also automatically formats the fields. For example, the
`homepage` value is displayed as a hyperlink.

Displaying an editable form
---------------------------
We can also display an editable variant of the same form:

```php
displayEditableForm($form,
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
require_once("data/model/table/ArrayTable.class.php");

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
require_once("data/model/table/DBTable.class.php");

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
    "comments" => new TextAreaField("Comments", false, 30, 15)
));
```

The above example is nearly identical to the `ArrayTable`, except that it adds
the `PERSON_ID` column that serves as a primary key.

The schema of the relational database that this example works on, could have the
following structure:

```sql
create table persons
( PERSON_ID    INTEGER      NOT NULL,
  firstname    VARCHAR(255) NOT NULL check(firstname <> ''),
  lastname     VARCHAR(255) NOT NULL check(lastname <> ''),
  address      VARCHAR(255) NOT NULL check(address <> ''),
  number       INTEGER      NOT NULL,
  zipcode      VARCHAR(6)   NOT NULL check(zipcode <> ''),
  city         VARCHAR(255) NOT NULL check(city <> ''),
  country      VARCHAR(255) NOT NULL check(country in ('Netherlands', 'Belgium')),
  email        VARCHAR(255) NOT NULL check(email <> ''),
  homepage     VARCHAR(255),
  birthdate    DATE         NOT NULL,
  comments     TEXT,
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
require_once("data/view/html/table.inc.php");
displayTable($table);
```

The above function invocation composes a `table` element with rows, headers and
table cells. It also formats each cell according to their type.

Displaying a table with basic editing capablities
-------------------------------------------------
We may also want to add basic editing capabilities to a table. For example, the
key column's values may want to link to a page giving the user the ability to edit
the record. A column value can be turned into a link by defining it as a
`KeyLinkField` column.

Moreover, we may also want to add a delete link to each table row. However, there
is no way to implement a generic delete operation. To support deletes we must
implement a function that returns a string representing the link to a delete URL:

```php
function deletePersonLink(Form $form)
{
    return "?__action=delete&amp;PERSON_ID=".$form->fields["PERSON_ID"]->value;
}
```

A delete function is a function taking a `Form` as parameter, which can be used
to retrieve the values of the corresponding table row. In this example, we return
a link to the same page that sets the `__action` and `PERSON_ID` `GET`
parameters.

These parameters can be used to compose a delete operation on the array or the
database table.

We can provide an additional parameter that refers to the delete function that we
have just defined. The result is that each row has a delete link which URL is
composed by our custom delete function:

```php
displayTable($table, "deletePersonLink");
```

Displaying an editable table
----------------------------
We can also compose an editable grid to make every cell in the table editable:

```php
displayEditableTable($table, $submittedForm, "deleteBookLink");
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

Fields
======
Currently the following `Field` classes are provided by this library:

* `TextField`. Displays a field as text and text input field.
* `EmailField` Displays a field as e-mail hyperlink and text input field.
* `HiddenField`. Displays a field as hidden field.
* `KeyLinkField`. Displays a link to a page responsible for displaying an object.
* `NumericIntTextField`. Displays a field as text and text input field which only accepts numeric integer values.
* `TextAreaField`. Displays a field as text and text area.
* `URLField`. Displays a field as a hyperlink and text input field.
* `DateField`. Displays a field as text and validates it as a date value.
* `ArrayComboBoxField`. Displays a field as text or combobox. It retrieves key-value pairs from an array.
* `DBComboBoxField`. Displays a field as text or combobox. It retrieves key-value pairs from a relational database.
* `FileField`. Displays a file path or file upload input field. It can optionally check if the file has the right MIME type.  It also adds the corresponding encoding type to the form that encapsulates it. The actual file can be retrieved through the `$_FILES["fieldname"]` variable.

Examples
========
This package includes three example web applications that can be found in the
`examples/` folder:

* The `address` is an example demonstrating the capabilities of a form and the available form fields.
* The `upload` is an example demonstrating a simple file upload of a text file.
* The `persons` is an example demonstrating an `ArrayTable` of persons in which records can be updated and deleted.
* The `books` is an example demonstrating an `DBTable` of books, which can be created, viewed, updated and deleted. It requires the `db.sql` schema to deployed to an RDBMS.

API documentation
=================
This package includes API documentation, which can be generated with [Doxygen](http://www.doxygen.org).
The Makefile in this package contains a `doc` target and produces the
corresponding HTML files in `apidoc`:

    $ make doc

License
=======
The contents of this package is available under the [Apache Software License](http://www.apache.org/licenses/LICENSE-2.0.html)
version 2.0
