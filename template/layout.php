<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>{{ title }}</title>
        <link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<header class="center">
			<nav>
				{{ menu }}
			</nav>
		</header>

		<main class="center column">
			{{ content }}
		</main>

		<footer class="center column">
			{{ footer }}
			<p>&copy; {{ year }}</p>
        </footer>
	</body>
</html>