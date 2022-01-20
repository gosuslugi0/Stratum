<?php 
    require "db.php";

    $data = $_POST;
    if(isset($data['btn_log'])){
        $user = R::findOne('users', "email = ?", array($data['email']));
        if($user){
            // Если Email существует в БД
            if( password_verify($data['password'], $user->password)){
                $_SESSION['logger_users'] = $user;
                
            } else{
                $errors[] = 'Пароль введен не верно';
            }
        } else {
            // Если Email не существует в БД
            $errors[] = 'Пользователь с таким Email не найден';
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $online = R::findOne('users', 'ip = ?', array($ip));

        // Вывод ошибок, если есть
        if( ! empty($errors)){
            $result_errors = '<small style="color: #F34436;">'.array_shift($errors).'</small>';
        }

        $online_count = R::count('users', "id" );
    }
?>

<!-- ЕСЛИ ПОЛЬЗОВАТЕЛЬ АВТОРИЗОВАН, ТО -->
<?php if(isset($_SESSION['logger_users'])):?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="by NoName">
    <title>Stratum</title>
    <!--    etc     -->
    <link rel="shortcut icon" href="/resources/img/Icon.svg">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
    <!--    CSS     -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/sidebars.css" rel="stylesheet">
    <link href="/css/offcanvas.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/font.css" rel="stylesheet">
    <link href="/css/carousel.css" rel="stylesheet">
    <!--    JS      -->
    <script src="/js/jquery.min.js"></script></script>
    <style>
        table {table-layout: fixed; width:100%}
        td {word-wrap:break-word;}
        table tbody th {border-bottom: none;}
        table tr:last-child td {border-bottom: none;}
        .purp_color{color: #7479B3;font-family: MM}
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>
<svg style="display: none;">
    <symbol id="Main" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        <!-- <path fill-rule="evenodd"d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" /> -->
    </symbol>
    <symbol id="group" viewBox="0 0 16 16">
        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
    </symbol>
    <symbol id="music" viewBox="0 0 16 16">
        <path d="M8 12a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
        <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm1 2h6a1 1 0 0 1 1 1v2.5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zm3 12a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
    <symbol id="messages" viewBox="0 0 16 16">
        <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
    </symbol>
    <symbol id="open-messages" viewBox="0 0 16 16">
        <path d="M8.941.435a2 2 0 0 0-1.882 0l-6 3.2A2 2 0 0 0 0 5.4v.314l6.709 3.932L8 8.928l1.291.718L16 5.714V5.4a2 2 0 0 0-1.059-1.765l-6-3.2ZM16 6.873l-5.693 3.337L16 13.372v-6.5Zm-.059 7.611L8 10.072.059 14.484A2 2 0 0 0 2 16h12a2 2 0 0 0 1.941-1.516ZM0 13.373l5.693-3.163L0 6.873v6.5Z" />
    </symbol>
    <symbol id="door" viewBox="0 0 16 16">
        <path d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1h8zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
    </symbol>
    <symbol id="open-door" viewBox="0 0 16 16">
        <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
    </symbol>
    <symbol id="Settings" viewBox="0 0 16 16">
        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
    </symbol>
    <symbol id="Number_of_people" viewBox="0 0 16 16">
        <path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2Z"/>
        <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783.059-.187.09-.386.09-.593V4a2 2 0 0 0-2-2H2Z"/>
    </symbol>
    <symbol id="facebook" viewBox="0 0 16 16">
        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
    </symbol>
    <symbol id="instagram" viewBox="0 0 16 16">
        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
    </symbol>
    <symbol id="twitter" viewBox="0 0 16 16">
        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
    </symbol>
    <symbol id="people_fill" viewBox="0 0 16 16">
        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
    </symbol>
    <symbol id="people_sub" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
    </symbol>
    <symbol id="music_check" viewBox="0 0 16 16">
        <path d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z"/>
        <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z"/>
        <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z"/>
    </symbol>
    <symbol id="image" viewBox="0 0 16 16">
        <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
        <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
    </symbol>
    <symbol id="arrow_short" viewBox="0 0 16 16">
        <path d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
    </symbol>
    <symbol id="like" viewBox="0 0 16 16">
        <path d="m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595L8 6.236zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.55 7.55 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z"/>
    </symbol>
    <symbol id="active_like" viewBox="0 0 16 16">
        <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/>
    </symbol>
    
    <symbol id="comment" viewBox="0 0 16 16">
        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
        <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
    </symbol>
    <symbol id="repost" viewBox="0 0 16 16">
        <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
    </symbol>
    <symbol id="active_repost" viewBox="0 0 16 16">
        <path d="M5.921 11.9 1.353 8.62a.719.719 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z"/>
    </symbol>
</svg>

<main>
    <div class="d-flex flex-column flex-shrink-0 bg-light" style="width: 4rem;">
        <!-- Меню -->
        <a href="index.html" class="d-block p-3 link-dark text-decoration-none" style="background: #212529" data-bs-toggle="tooltip" data-bs-placement="right">
            <img src="/resources/img/Icon.svg" alt="Stratum" style="width: 105%;" class="fire_icon">
        </a>
        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center svg_color">
            <li>
                <a href="#" class="nav-link py-3 border-bottom" title="Моя страница" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi svg_purple" width="31.5" height="31.5"><use xlink:href="#Main"/></svg></a>
            </li>
            <li>
                <a href="#" class="nav-link py-3 border-bottom position-relative" title="Сообщения" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi svg_purple" width="31.5" height="31.5"><use xlink:href="#messages"/></svg>
                    <span class="position-absolute start-100 translate-middle badge rounded-pill" style="background-color:#7479B3;">
                        99+<span class="visually-hidden">unread messages</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link py-3 border-bottom" title="Музыка" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi svg_purple" width="31.5" height="31.5"><use xlink:href="#music"/></svg></a>
            </li>
            <li>
                <a href="#" class="nav-link py-3 border-bottom" title="Друзья" data-bs-toggle="tooltip" data-bs-placement="right">
                    <svg class="bi svg_purple" width="31.5" height="31.5"><use xlink:href="#group"/></svg></a>
            </li>
        </ul>
        <!-- Настройки -->
        <div class="dropdown border-top">

        <ul class="nav nav-pills nav-flush flex-column mb-auto text-center svg_color">
            <li>
            <a href="#" class="nav-link py-3 border-bottom svg_color" style="text-decoration: none;list-style-type: none;" title="Нас - <?php echo $online_count ?> чел." data-bs-toggle="tooltip" data-bs-placement="right">
                <svg class="bi svg_purple" width="31.5" height="31.5">
                    <use xlink:href="#Number_of_people"/>
                </svg>
            </a></li></ul>

            <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none  name_settings" id="dropdownUser3" data-bs-toggle="dropdown" aria-expanded="false">
                <svg class="bi svg_name_settings" width="31.5" height="31.5">
                    <use xlink:href="#Settings"/>
                </svg>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
                <li><a class="dropdown-item" href="#">Помощь</a></li>
                <li><a class="dropdown-item" href="#">Настройки</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Выйти</a></li>
            </ul>
        </div>
    </div>

    <!-- Разделение областей -->
    <div class="b-example-divider"></div>
    <!-- Рабочее окно -->
    <div class="cont_nav">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
            <div class="container-fluid">
                <a class="navbar-brand font_hs" href="login.php">Stratum</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample05">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    
                </ul>
                <form>
                    <input class="form-control input_CR" type="text" placeholder="Найти друзей" aria-label="Search">
                </form>
                </div>
            </div>
        </nav>
        <div class="container mb-5">
            <div class="row">
                <div class="col-3">
                    <div class="card" style="border-radius:4px 4px 0px 0px; overflow: hidden;">
                        <img src="resources/img/avatar1.jpg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="card-img-top card-img-alb" alt="avatar">
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="resources/img/avatar1.jpg" alt="avatar" width="100%"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="border-radius:0px 0px 4px 4px">
                        <div class="card-body">
                            <h4 class="card-title">Олег Юрлов</h4>
                            <p class="card-text">Мой статус</p>
                        </div>
                    </div>

                    <div class="bd-example">
                        <nav>
                            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-friends" type="button" role="tab" aria-controls="nav-home" aria-selected="true" style="color: #7479B3">Друзья</button>
                                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-musics" type="button" role="tab" aria-controls="nav-contact" aria-selected="false" style="color: #7479B3">Музыка</button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-friends" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row text-center">
                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar2.jpg" class="rounded-circle border" width="70" height="70" alt=""> 
                                        <small>Дмитрий</small>
                                    </div>

                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar3.jpg" class="rounded-circle border" width="70" height="70" alt="">
                                        <small>Полина</small>
                                    </div>

                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar4.jpg" class="rounded-circle border" width="70" height="70" alt="">
                                        <small>Денис</small>
                                    </div>

                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar1.jpg" class="rounded-circle border" width="70" height="70" alt="">
                                        <small>Олег</small>
                                    </div>

                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar5.jpg" class="rounded-circle border" width="70" height="70" alt=""> 
                                        <small>Евгений</small>
                                    </div>

                                    <div class="col-4 mb-2">
                                        <img src="resources/img/avatar6.jpg" class="rounded-circle border" width="70" height="70" alt="">
                                        <small>Владислав</small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-musics" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="row">
                                    <div class="col-12 mb-2 ">
                                        <div class="row">
                                            <div class="col-3"><img src="resources/img/music1.jpg" class="rounded border" width="60" height="60" alt="..."></div>
                                            <div class="col-9 my-auto">
                                                <h6>Древо</h6>
                                                <small class="card-text ">ZAUR, MEIRINKITO</small>
                                            </div>
                                        </div>      
                                    </div>

                                    <div class="col-12 mb-2 ">
                                        <div class="row">
                                            <div class="col-3"><img src="resources/img/music2.jpg" class="rounded border" width="60" height="60" alt="..."></div>
                                            <div class="col-9 my-auto">
                                                <h6>Я все решил (Outro)</h6>
                                                <small class="card-text ">ZAPOMNI</small>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="row">
                                            <div class="col-3"><img src="resources/img/music3.png" class="rounded border" width="60" height="60" alt="..."></div>
                                            <div class="col-9 my-auto">
                                                <h6>Полёт нормальный</h6>
                                                <small class="card-text ">Markul</small>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Друзья -->
                    <!-- Музыка -->
                </div>
                
                <div class="col-9" style="margin-bottom:20px">

                    <div class="btn-toolbar mb-3 row" role="toolbar">
                        <div class="btn-group me-2 col-12" role="group">
                            <button type="button" class="btn btn-outline-secondary group_button" >Написать сообщение</button>
                            <button type="button" class="btn btn-outline-secondary group_button" >Добавить в друзья</button>
                            <button type="button" class="btn btn-outline-secondary group_button" >Заблокировать</button>
                        </div>
                    </div>

                    <div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item" >
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne"  aria-controls="panelsStayOpen-collapseOne" style="color:#7479B3">
                                    Основная информация</button></h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne" >
                                    <div class="accordion-body p-3 pb-0">
                                        <table class="table table-hover"><tbody>
                                            <tr><td>Город:</td><td>Хреновое</td></tr>
                                            <tr><td>День рождение:</td><td>11 мая 1994 г.</td></tr>
                                            <tr><td>Место работы:</td><td>DSR Corporation</td></tr>
                                        </tbody></table>
                        </div></div></div></div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse2"  aria-controls="panelsStayOpen-collapse2" style="color:#7479B3">
                                Подробная информация</button></h2>
                            <div id="panelsStayOpen-collapse2" class="accordion-collapse collapse"  aria-labelledby="panelsStayOpen-heading2">
                                <div class="accordion-body p-3 pb-0">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr><th colspan="2">Дополнительная информация</th></tr>
                                            <tr><td>Семейное положение:</td><td>Влюблен</td></tr>
                                            <tr><td>Языки:</td><td>Русский</td></tr>
                                            <tr><td>Родители:</td><td>Пользователи</td></tr>
                                            <tr><td>Дедушки, Бабушки:</td><td>Пользователи</td></tr>
                                            <tr><td>Братья, сёстры:</td><td>Пользователи</td></tr>

                                            <tr><th colspan="2">Контактная информация</th></tr>
                                            <tr><td>Мобильный телефон:</td><td>89876543210</td></tr>
                                            <tr><td>Домашний телефон:</td><td>89012345678</td></tr>
                                            <tr><td>Discord:</td><td>my_discord</td></tr>
                                            <tr><td>Skype:</td><td>my_skype</td></tr>

                                            <tr><th colspan="2">Образование</th></tr>
                                            <tr><td>Вуз:</td><td>ВГУ '15</td></tr>
                                            <tr><td>Факультет:</td><td>Прикладной математики, информатики и механики</td></tr>
                                            <tr><td>Специальность:</td><td>Математического обеспечения ЭВМ</td></tr>
                                            <tr><td>Форма обучения:</td><td>Очное отделение</td></tr>
                                            <tr><td>Статус:</td><td>Выпускник (бакалавр)</td></tr>
                                            <tr><td>Школа:</td><td>Школа № 2 им. В. И. Левакова '11</td></tr>

                                            <tr><th colspan="2">Военная служба</th></tr>
                                            <tr><td>Войсковая часть:</td><td>военная кафедра ВГУ</td></tr>

                                            <tr><th colspan="2">Жизненная позиция</th></tr>
                                            <tr><td>Политические предпочтения:</td><td>Умереннные</td></tr>
                                            <tr><td>Мировозрение:</td><td>Атеизм</td></tr>
                                            <tr><td>Главное в жизни:</td><td>Развлечения и отдых</td></tr>
                                            <tr><td>Главное в людях:</td><td>Доброта и честность</td></tr>
                                            <tr><td>Отношение к курению:</td><td>Резго негативное</td></tr>
                                            <tr><td>Отношение к алкоголю:</td><td>Компромисное</td></tr>
                                            <tr><td>Вдохновляют:</td><td>Музыка в наушниках</td></tr>

                                            <tr><th colspan="2">Личная информация</th></tr>
                                            <tr><td>Интересы:</td><td>Программирование, компьютерные стратегии</td></tr>
                                            <tr><td>Любимые фильмы:</td><td>Остров проклятых</td></tr>
                                            <tr><td>Любимые игры:</td><td>Настольные игры</td></tr>
                                            <tr><td>Любимые книги:</td><td>Тысяча слов</td></tr> 
                                        </tbody>
                                    </table>
                    </div></div></div></div>

                    <div class="row mt-3">
                        <div class="col-sm-3">
                            <div class="card">
                            <div class="card-body pb-2 svg_icon_profile">
                                <h6 class="card-title purp_color">Друзья</h6><h6>44</h6>
                                <svg class="bi svg_purple2" width="80" height="80"><use xlink:href="#people_fill"/></svg>
                        </div></div></div>

                        <div class="col-sm-3">
                            <div class="card">
                            <div class="card-body pb-2 svg_icon_profile">
                                <h6 class="card-title purp_color">Подписчики</h6><h6>217</h6>
                                <svg class="bi svg_purple2" width="80" height="80"><use xlink:href="#people_sub"/></svg>
                        </div></div></div>

                        <div class="col-sm-3">
                            <div class="card">
                            <div class="card-body pb-2 svg_icon_profile">
                                <h6 class="card-title purp_color">Фотографии</h6><h6>5</h6>
                                <svg class="bi svg_purple2" style="transform: rotate(20deg)" width="80" height="80"><use xlink:href="#image"/></svg>
                        </div></div></div>

                        <div class="col-sm-3">
                            <div class="card">
                            <div class="card-body pb-2 svg_icon_profile">
                                <h6 class="card-title purp_color">Аудиозаписи</h6><h6>29</h6>
                                <svg class="bi svg_purple2" style="transform: rotate(10deg)" width="80" height="80"><use xlink:href="#music_check"/></svg>
                        </div></div></div>
                    </div>

                    <!-- Фотографии -->
                    <div class="py-4">
                        <div class="row">
                            <h3 class="col-6 my-auto pb-3">Фотографии</h3>
                            <div class="col-6 btn-toolbar mb-3 px-0 row" role="toolbar">
                                <div class="btn-group px-0" role="group">
                                    <button type="button" class="btn btn-outline-secondary group_button" >Добавить фото</button>
                                    <button type="button" class="btn btn-outline-secondary group_button" >Все фотографии</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 albom_card rounded">
                                <img src="resources/img/img1.jpg" type="button" data-bs-toggle="modal" data-bs-target="#img1" class="albom_card_img" alt="img1">
                                <!-- Modal -->
                                <div class="modal fade" id="img1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="resources/img/img1.jpg" alt="avatar" width="100%"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 albom_card rounded">
                                <img src="resources/img/img9.jpg" type="button" data-bs-toggle="modal" data-bs-target="#img2" class="albom_card_img" alt="img1">
                                <!-- Modal -->
                                <div class="modal fade" id="img2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="resources/img/img9.jpg" alt="avatar" width="100%"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 albom_card rounded">
                                <img src="resources/img/img3.jpg" type="button" data-bs-toggle="modal" data-bs-target="#img3" class="albom_card_img" alt="img1">
                                <!-- Modal -->
                                <div class="modal fade" id="img3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="resources/img/img3.jpg" alt="avatar" width="100%"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 albom_card rounded">
                                <img src="resources/img/img10.jpg" type="button" data-bs-toggle="modal" data-bs-target="#img4" class="albom_card_img" alt="img1">
                                <!-- Modal -->
                                <div class="modal fade" id="img4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="resources/img/img10.jpg" alt="avatar" width="100%"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Фотографии -->

                    <div class="row">
                        <h3 class="col-4 my-auto pb-3">Записи</h3>
                        <div class="col-8 btn-toolbar mb-3 px-0 row" role="toolbar">
                            <div class="btn-group px-0" role="group">
                                <button type="button" class="btn btn-outline-secondary group_button" >Добавить запись</button>
                                <button type="button" class="btn btn-outline-secondary group_button" >Редактировать запись</button>
                                <button type="button" class="btn btn-outline-secondary group_button" >Удалить запись</button>
                            </div>
                        </div>
                    </div>

                    <div class="row" data-masonry='{"percentPosition": true }'>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card">
                            <img src="resources/img/img5.jpg" class="rounded-top">
                                <div class="card-footer">
                                    <div class="row my-auto">
                                        <div class="col-8">
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#like"/></svg><small class="me-2">165</small>
                                            <svg class="bi svg_purple me-1" width="30" height="30"><use xlink:href="#comment"/></svg><small>14</small>
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#repost"/></svg><small>13</small>
                                        </div>
                                        <p class="text-muted text-end mx-0 my-auto col-4">2 days ago</p>
                        </div></div></div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card p-3">
                                <figure class="p-3 mb-0">
                                    <blockquote class="blockquote"><p>A well-known quote, contained in a blockquote element.</p></blockquote>
                                    <figcaption class="blockquote-footer mb-0 text-muted">Someone famous in <cite title="Source Title">Source Title</cite></figcaption>
                                </figure>
                        </div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card">
                                <img src="resources/img/img6.jpg" class="rounded-top">
                                <div class="card-body">
                                    <h5 class="card-title">Card title that wraps to a new line</h5>
                                    <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row my-auto">
                                        <div class="col-8">
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#like"/></svg><small class="me-2">165</small>
                                            <svg class="bi svg_purple me-1" width="30" height="30"><use xlink:href="#comment"/></svg><small>14</small>
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#repost"/></svg><small>13</small>
                                        </div>
                                        <p class="text-muted text-end mx-0 my-auto col-4">2 days ago</p>
                        </div></div></div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is another card with title and supporting text below. This card has some additional content to make it slightly taller overall.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div></div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This card has a regular title and short paragraph of text below it.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div></div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card">
                                <img src="resources/img/img7.jpg" class="rounded-top">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row my-auto">
                                        <div class="col-8">
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#like"/></svg><small class="me-2">165</small>
                                            <svg class="bi svg_purple me-1" width="30" height="30"><use xlink:href="#comment"/></svg><small>14</small>
                                            <svg class="bi svg_purple" width="30" height="30"><use xlink:href="#repost"/></svg><small>13</small>
                                        </div>
                                        <p class="text-muted text-end mx-0 my-auto col-4">2 days ago</p>
                        </div></div></div></div>

                        <div class="col-sm-6 col-lg-6 mb-4">
                            <div class="card p-3 text-end">
                                <figure class="p-3 mb-0">
                                    <blockquote class="blockquote"><p>A well-known quote, contained in a blockquote element.</p></blockquote>
                                    <figcaption class="blockquote-footer mb-0 text-muted">Someone famous in <cite title="Source Title">Source Title</cite></figcaption>
                                </figure>
                        </div></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- <footer class="footerbg-light">
            <div class="container">
                <div class="d-flex justify-content-between py-4 border-top">
                    <p>&copy; 2021 Company, Inc. All rights reserved.</p>
                    <ul class="list-unstyled d-flex">
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
                        <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
                    </ul>
                </div>
            </div>
        </footer> -->

    </div>
</main>
<!--    JS      -->
<script async src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script async src="js/search.js"></script>
<script src="js/sidebars.js"></script>
</body>
</html>


<!-- ЕСЛИ ПОЛЬЗОВАТЕЛЬ НЕ АВТОРИЗОВАН, ТО -->
<?php else: ?> 
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

<body class="text-center" style="background-color: #212529;"> 
    <main class="form-signin">
        <form action="/login.php" method="POST">
        <img class="mb-4" src="/resources/img/Icon.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal" style="color: white;">Авторизация</h1>

        <div class="form-floating">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo @$data['email'] ?>">
            <label for="floatingInput">Email</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" class="form-control" name="password" placeholder="Пароль">
            <label for="floatingInput">Пароль</label>
        </div>
        <div class="mb-2"><?php echo $result_errors ?></div>

        <button class="w-100 btn btn-lg btn-primary mb-2 input_log" type="submit" name="btn_log">Войти</button>
        <small style="color: #ccc; margin-right:5px;">Нет аккаунта?</small><a href="register.php" class="input_reg">Зарегистрироваться</a>
        <p class="mt-3 mb-3 text-muted">&copy; 2021–2022</p>
        </form>
    </main>
</body>

<?php endif; ?>