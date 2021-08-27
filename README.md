1. Composer install
2. php -r "file_exists('.env') || copy('.env.example', '.env');"
3. Configure .env
4. php artisan key:generate
5. php artisan jwt:secret
6. php artisan migrate
7. php artisan db:seed

Api endpoints:

//Авторизация

'login' 

    email - required
	password - required
	response: {
		‘acces_token’, - токен для работы с остальными путями
		‘token_type’,  - тип токена
		‘expires_in’   - время окончания токена
	}

//Выход с аккаунта

'logout' : {
	
	‘token’ - required
}

//Обновления токена

'refresh' : {

	‘token’ - required
}

//Получение информации о своем аккаунте

'me': {

	‘token’ - required
}

//Регистрация пользователя

'registration': {

	name - required
	email - required
	password - required
	password_confirmation - required
}

//Получения списка пользователей

'users': {

	‘token’ - required
}

//Получение списка всех заданий

'getTasks’{

	‘token’ - required
}

//Получение списка заданий привязанных к пользователю

'getTasksByUserId/{user_id}':{

	‘token’ - required
}

//Создание задания

'createTask’:{

	‘token’ - required,
	‘name’ - required,
	‘description’ - required,
}

//Обновить задание

'updateTask/{id}':{

	‘token’ - required,
	‘name’,
	‘description’,
	‘user_id’ 
	’status_id’
}

//Удалить задание

'deleteTask/{id}':{

	‘token’ - required
}

//Получить все статусы

'getStatuses':{

	‘token’ - required
}

//Создать статус

'createStatus':{

	‘token’ - required
	‘name’ - required
}
//Обновить статус

'updateStatus/{id}':{

	‘token’ - required
	‘name’ - required
}

//Удалить статус

'deleteStatus/{id}':{

	‘token’ - required
}
