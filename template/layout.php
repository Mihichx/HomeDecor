<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>{{ title }}</title>
		<link rel="icon" href="/img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="/css/main.css">
	</head>
	<body>
		<header class="center column">
			{{ header }}
		</header>

		<main class="center column">
			{{ content }}
		</main>

		<footer class="center column">
			<div>
				<div class=" center row">
					<h3>ДЕКОР ДЛЯ <br> ДОМА</h3>
					<img src="/img/logo.png" alt="Логотип" style="max-width: 50px; margin: 20px;">
				</div>
				<p style="opacity: 0.6;">&copy; {{ year }} Декор для дома. Все права защищены.</p>
				<p style="opacity: 0.6; margin-top: 20px;">
					Команда разработчиков: <br>
					Бакулев Михаил <br>
					Сухарева Ангелина <br>
					Рагазина Елена
				</p>
				<div class="center row" style="margin-top: 20px;">
					<a target="_blank" class="hover" href="https://web.telegram.org/"><img class="margin15" src="/img/telegram.png" alt="Логотип" style="max-width: 40px;"></a>
					<a target="_blank" class="hover" href="https://www.youtube.com/"><img class="margin15" src="/img/youtube.png" alt="Логотип" style="max-width: 40px;"></a>
					<a target="_blank" class="hover" href="https://vk.com/"><img class="margin15" src="/img/vk.png" alt="Логотип" style="max-width: 40px;"></a>
				</div>
			</div>
        </footer>
	</body>
</html>