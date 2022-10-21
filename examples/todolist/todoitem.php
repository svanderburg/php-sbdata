<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\IntegerValue;
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\ReadOnlyNumericIntTextField;
use Examples\TodoList\Entity\TodoItem;

function importAndCheckParameters(): ParameterMap
{
	$getMap = new ParameterMap(array(
		"viewmode" => new IntegerValue(false),
		"ITEM_ID" => new IntegerValue(false, 255)
	));
	$getMap->importValues($_GET);
	$getMap->checkValues();

	if($getMap->checkValid())
		return $getMap;
	else
		throw new Exception($getMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructForm(): Form
{
	return new Form(array(
		"__operation" => new HiddenField(false),
		"ITEM_ID" => new ReadOnlyNumericIntTextField("Id", false, 20, 255),
		"Description" => new TextField("Description", true),
	));
}

function executeOperation(ParameterMap $getMap, Form $form, PDO $dbh): void
{
	if(array_key_exists("__operation", $_POST))
	{
		if($_GET["__operation"] = "insert_item" || $_GET["__operation"] == "update_item")
		{
			$form->importValues($_POST);
			$form->checkFields();

			if($form->checkValid())
			{
				$item = $form->exportValues();

				if($_GET["__operation"] == "insert_item")
					$itemId = TodoItem::insert($dbh, $item);
				else
				{
					$itemId = $item["ITEM_ID"];
					TodoItem::update($dbh, $item);
				}

				header("Location: ".$_SERVER["PHP_SELF"]."?".http_build_query(array(
					"ITEM_ID" => $itemId
				), "", null, PHP_QUERY_RFC3986));
				exit;
			}
		}
		else
			throw new Exception("Unknown operation: ".$_POST["operation"]);
	}
	else
	{
		$itemId = $getMap->values["ITEM_ID"]->value;

		if($itemId == "")
			$form->fields["__operation"]->importValue("insert_item");
		else
		{
			$stmt = TodoItem::queryOne($dbh, $itemId);

			if(($item = $stmt->fetch()) !== false)
				$form->importValues($item);

			$form->fields["__operation"]->importValue("update_item");
		}
	}
}

$error = null;

try
{
	$getMap = importAndCheckParameters();
	$form = constructForm($getMap, $dbh);
	executeOperation($getMap, $form, $dbh);
}
catch(Exception $ex)
{
	$error = $ex->getMessage();
}

/* Display the page and form */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>TODO item</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<p>
			<a href="todoitems.php">&laquo; TODO items</a> |
			<a href="<?php print($_SERVER["PHP_SELF"]); ?>">Add TODO item</a>
		</p>
		<?php
		if($error === null)
		{
			if($getMap->values["viewmode"]->value == 1)
				\SBData\View\HTML\displayForm($form);
			else
				\SBData\View\HTML\displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
			}
		else
		{
			?>
			<p><?php print($error); ?></p>
			<?php
		}
		?>
	</body>
</html>
