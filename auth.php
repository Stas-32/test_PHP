<?php

	$name = $_GET["name"];
	$surname = $_GET["surname"];
	$email = $_GET["email"];
	$password = $_GET["password"];
	$password_confirm = $_GET["password_confirm"];

	//Проверка на все поля ввода
	if($name && $surname && $email && $password && $password_confirm) {
		if($password_confirm == $password) {
			$status = true;

			//Получаем почты в строку и разбиваем её на массив строк
			$users_string = file_get_contents("users.txt");
			$users = explode(";",$users_string);

			//Проверяем, есть ли введенная почта в файле
			foreach ($users as $key) {
				if($key == $email) {
					echo 'PHP: Пользователь с таким мылом уже есть';
					$status = false;
					break;
				}
			}
			if($status) {
				//Если все условия выполнены и такой почты нет в файле, то записываем лог о регистрации и дописываем почту в файл
				file_put_contents("log.txt", "[".date("d.m.Y H:i:s")."] регистрация пользователя " .$name. " " .$surname. " (" .$email. ")\n",FILE_APPEND);
				file_put_contents("users.txt", $email.';',FILE_APPEND);
			}
		} else {
			echo 'PHP: Пароли не совпадают';
		}
	} else {
		echo 'PHP: Не все поля ввода дошли до сервера';
	}

?>