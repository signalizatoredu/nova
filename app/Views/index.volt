<!DOCTYPE html>
<html>
	<head>
		<title>Collectioneer</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		{{ stylesheet_link("css/normalize.css") }}
		{{ stylesheet_link("css/kube.css") }}
		{{ stylesheet_link("css/main.css") }}
	</head>
	<body>
		{{ content() }}
		{{ javascript_include("js/lib/jquery/jquery.js") }}
		{{ javascript_include("js/lib/handlebars/handlebars.js") }}
		{{ javascript_include("js/lib/ember/ember.js") }}
		{{ javascript_include("js/lib/ember/ember-data.js") }}
		{{ javascript_include("js/templates.js") }}
		{{ javascript_include("js/app.js") }}
	</body>
</html>
