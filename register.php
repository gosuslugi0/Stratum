<?php 
    require "db.php";

    $data = $_POST;
    if( isset($data['btn_reg']) )
    {
        // Начало проверки данных
        $errors = array();
        if(trim($data['fname']) == ''){
            $errors[] = 'Вы не ввели Имя';}
        if(trim($data['lname']) == ''){
            $errors[] = 'Вы не ввели Фамилию';}
        if(trim($data['email']) == ''){
            $errors[] = 'Вы не ввели Email';}
        if($data['password'] == ''){
            $errors[] = 'Вы не ввели пароль';}
        if($data['repeat_password'] != $data['password']){
            $errors[] = 'Пароли не совпалают!';}
        if(R::count('users', "email = ?", array($data['email'])) > 0){
          $errors[] = 'Пользователь с таким Email уже существует!';
        }
        // Конец проверки

        // Получение даты
        $date_sec = time();
        $dt = new DateTime("@$date_sec");
        $date = $dt->format('Y-m-d');

        // Вывод ошибок, если есть
        if( empty($errors)){
            $users = R::dispense('users');
            $users->fname = $data['fname'];
            $users->lname = $data['lname'];
            $users->email = $data['email'];
            $users->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $users->date_reg = $date;
            R::store($users);
            header('Location: /login.php');
        } else { $result_errors = '<small style="color: #F34436;">'.array_shift($errors).'</small>'; }        
    }
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="by NoName">
    <title>Stratum</title>
    <!--    CSS     -->
    <link rel="shortcut icon" href="/resources/img/Icon.svg">
    <link rel="stylesheet" href="/css/StyleSingIn.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="text-center" style="background-color: #212529">
    <main class="form-signin">
        <form action="/register.php" method="POST">
          <img class="mb-4" src="resources/img/Icon.svg" alt="" width="72" height="57">
          <h1 class="h3 mb-3 fw-normal" style="color: white;">Регистрация</h1>
          <div class="form-floating">
            <input type="text" class="form-control rounded-top rounded-0" name="fname" placeholder="Имя" value="<?php echo @$data['fname'] ?>">
            <label for="floatingInput">Имя</label>
          </div>
          
          <div class="form-floating">
            <input type="text" class="form-control mb-2 border-top-0 rounded-0 rounded-bottom" name="lname" placeholder="Фамилия" value="<?php echo @$data['lname'] ?>">
            <label for="floatingInput">Фамилия</label>
          </div>

          <div class="form-floating">
            <input type="email" class="form-control mb-2 rounded" name="email" placeholder="Email" value="<?php echo @$data['email'] ?>">
            <label for="floatingInput">Email</label>
          </div>

          <div class="form-floating">
            <input type="password" class="form-control mb-0 rounded-0 rounded-top" name="password" placeholder="Пароль">
            <label for="floatingInput">Пароль</label>      
          </div>
          
          <div class="form-floating">
            <input type="password" class="form-control mb-1 border-top-0 rounded-0 rounded-bottom" name="repeat_password" placeholder="Повторите пароль">
            <label for="floatingInput">Повторите пароль</label>
          </div>
          <div class="mb-2"><?php echo $result_errors ?></div>
          
          <button class="btn_lr w-100 btn btn-lg btn-primary mb-2 input_log" type="submit" name="btn_reg">Зарегистрироваться</button>
          <small style="color: #ccc; margin-right:5px;">Уже зарегистрирован?</small><a href="login.php" class="input_reg">Войти</a>
          <p class="mt-3 mb-3 text-muted">&copy; 2021–2022</p>
        </form>
    </main>
</body>