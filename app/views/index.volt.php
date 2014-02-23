<!DOCTYPE html>
<html>
	<head>
		<title>Collectioneer</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php echo $this->tag->stylesheetLink('css/normalize.css'); ?>
		<?php echo $this->tag->stylesheetLink('css/kube.css'); ?>
		<?php echo $this->tag->stylesheetLink('css/main.css'); ?>
	</head>
	<body>
		<?php echo $this->getContent(); ?>
		<?php echo $this->tag->javascriptInclude('js/lib/jquery/jquery.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/lib/handlebars/handlebars.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/lib/ember/ember.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/lib/ember/ember-data.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/templates.js'); ?>
		<?php echo $this->tag->javascriptInclude('js/app.js'); ?>
	</body>
</html>
