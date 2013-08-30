<html>
<head>
<title></title>
<!--zf::debug:head-->
</head>
<body>

Information:<p>

<?=$a?>

<br /><br />



<?
//debug::dump($this->forms);
echo $form->getHeader();
echo $form->getLabel('name'), ': ';
echo $form->getInput('name');
?>
</form>

<br /><br />
<!--zf::debug:body-->
</body>
</html>