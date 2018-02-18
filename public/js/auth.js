$(document).ready(function () {

    //При нажатии кнопки Регистрация всплывает форма регистрации
    $('.register button').click(function () {
        $('#form-register').css('display','block');
        $('#blackout').fadeIn();
    });

    //При нажатии кнопки Вход всплывает форма аутентицикации пользователя
    $('.entry button').click(function () {
        $('#form-auth').css('display','block');
        $('#blackout').fadeIn();
    });

    //При нажатии вне форм регистрации и входа, данные формы скрываются
    $('#blackout').click(function () {
        $('#form-register').css('display','none');
        $('#form-auth').css('display','none');
        $('#blackout').fadeOut();

    });

    //При нажатии на кнопку Отправить(форма Регистрация), выполняется POST запрос мметодом Аjax
    $(' #form-register .button button').click(function () {

        //получение данных с формы
        var data = $(' #form-register form').serialize();

        $.ajax({
            type: "post",
            url: "/register",
            data: data,
            success: function (data) {
                //в случае успешного получения ответа, форма регистрации скрывается
                $('#form-register').css('display','none');
                $('#blackout').fadeOut();

                //вывод на екран логина пользователя и кнопки Выйти
                $('.register button').remove();
                $("<a>").attr("href", "/home").addClass("btn btn-primary").appendTo(".register").html("Добро пожаловать, " + data.name);
                $('.entry button').remove();
                $("<a>").attr("href", "/logout").addClass("btn btn-primary").appendTo(".entry").html('Выйти');

            }
        });

        return false;
    });

    //При нажатии на кнопку Отправить(формы Вход), выполняется POST запрос мметодом Аjax
    $(' #form-auth .button button').click(function () {
        //получение данных с формы
        var data = $(' #form-auth form').serialize();

        $.ajax({
            type: "post",
            url: "/login",
            data: data,
           success: function (data) {
               //в случае успешного получения ответа, форма регистрации скрывается
               $('#form-auth').css('display', 'none');
               $('#blackout').fadeOut();
               //вывод на екран логина пользователя и кнопки Выйти
               $('.register button').remove();
               $("<a>").attr("href", "/home").addClass("btn btn-primary").appendTo(".register").html("Добро пожаловать, " + data.name);
               $('.entry button').remove();
               $("<a>").attr("href", "/logout").addClass("btn btn-primary").appendTo(".entry").html('Выйти');
            }
        });

        return false;
    });
});