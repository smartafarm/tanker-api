<?php
?>
<!DOCTYPE html>
<head>
<title>Smart Farm</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="Views/default.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <?php
		if (isset($this->css)) 
		{
			foreach ($this->css as $css)
			{
				echo '<link rel="stylesheet" href="'.URL.'Views/'.$css.'">';
			}
		}
	?>

</head>
<body>
<?php require 'navigation.php';?>
<div class =container>