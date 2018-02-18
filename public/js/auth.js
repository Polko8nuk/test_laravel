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

        //удаление временных сообщений об ошибке
        $(' #form-register span[id="error"]').remove();
        $(' #form-auth span[id="error"]').remove();

    });

    //При нажатии на кнопку Отправить(форма Регистрация), выполняется POST запрос мметодом Аjax
    $(' #form-register .button button').click(function () {

        //получение данных с формы
        var data = $(' #form-register form').serialize();

        //удаление временных сообщений об ошибке
        $(' #form-register span[id="error"]').remove();

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
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //преобразовуем json в JavaScript значение
                var data = $.parseJSON( xhr.responseText );
                console.log(data);
                 //перебираем ошибки и добавляем их на форму регистрации
                $.each(data.errors, function(key, val) {
                    if (key == 'name') {
                        $("<span>").attr("id", "error").insertAfter("#form-register .formGroupExampleName").html(val).css("color", "red");
                    }
                    if (key == 'login') {
                        $("<span>").attr("id", "error").insertAfter("#form-register .formGroupExampleLogin").html(val).css("color", "red");
                    }
                    if (key == 'email') {
                        $("<span>").attr("id", "error").insertAfter("#form-register .formGroupExampleEmail").html(val).css("color", "red");
                    }
                    if (key == 'password') {
                        $("<span>").attr("id", "error").appendTo("#form-register .formGroupExamplePassword").html(val).css("color", "red");
                    }
                });

            }
        });

        return false;
    });

    //При нажатии на кнопку Отправить(формы Вход), выполняется POST запрос мметодом Аjax
    $(' #form-auth .button button').click(function () {
        //получение данных с формы
        var data = $(' #form-auth form').serialize();

        //удаление временных сообщений об ошибке
        $(' #form-auth span[id="error"]').remove();

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
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //преобразовуем json в JavaScript значение
                var data = $.parseJSON( xhr.responseText );
                console.log(data);
                //перебираем ошибки и добавляем их на форму регистрации
                $.each(data.errors, function(key, val) {
                    if (key == 'login') {
                        $("<span>").attr("id", "error").insertAfter("#form-auth .formGroupExampleLogin").html(val).css("color", "red");
                    }
                    if (key == 'password') {
                        $("<span>").attr("id", "error").appendTo("#form-auth .formGroupExamplePassword").html(val).css("color", "red");
                    }
                });
            }
        });

        return false;
    });
});