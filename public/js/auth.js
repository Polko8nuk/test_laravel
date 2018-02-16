$(document).ready(function () {

    //При нажатии кнопки Регистрация всплывает форма регистрации
    $('#register').click(function () {
        $('#form-register').css('display','block');
        $('#blackout').fadeIn();
    });

    //При нажатии кнопки Вход всплывает форма аутентицикации пользователя
    $('#entry').click(function () {
        $('#form-auth').css('display','block');
        $('#blackout').fadeIn();
    });

    //При нажатии вне форм регистрации и входа, данные формы скрываются
    $('#blackout').click(function () {
        $('#form-register').css('display','none');
        $('#form-auth').css('display','none');
        $('#blackout').fadeOut();
        $('#form-register span[id="error"]').remove();
    });

    //При нажатии на кнопку Отправить(форма Регистрация), выполняется POST запрос мметодом Аjax
    $('#form-register button').click(function () {
        $('#form-register span[id="error"]').remove();
        //получение данных с формы
        var data = $('#form-register form').serialize();

        $.ajax({
            type: "post",
            url: "/register",
            data: data,
            success: function (data) {
                //в случае успешного получения ответа, форма регистрации скрывается
                $('#form-register').css('display','none');
                $('#blackout').fadeOut();

                //вывод на екран логина пользователя и кнопки Выйти
                $("<div>").attr("id", "auth").insertBefore("#add");
                $("<a>").attr("id", "name").attr("href", "/home").appendTo("#auth").html(data.name);
                $("<a>").attr("id", "logout").attr("href", "/logout").appendTo("#auth").html('Выйти');
                $("<br>").appendTo("#name");
                $('#add').css("display", "none");


            },
            error: function (xhr, ajaxOptions, thrownError) {
                //преобразовуем json в JavaScript значение
                var data = $.parseJSON( xhr.responseText );
                //перебираем ошибки и добавляем их на форму регистрации
                $.each(data, function(key, val) {
                    if (key == 'login') {
                        $("<span>").attr("id", "error").insertBefore("#login input").html(val).css("color", "red");
                    }
                    if (key == 'email') {
                        $("<span>").attr("id", "error").insertBefore("#email input").html(val).css("color", "red");
                    }
                    if (key == 'password') {
                        $("<span>").attr("id", "error").insertBefore("#password input").html(val).css("color", "red");
                    }
                });

            }
        });

        return false;
    });

    //При нажатии на кнопку Отправить(формы Вход), выполняется POST запрос мметодом Аjax
    $('#form-auth button').click(function () {
        //получение данных с формы
        var data = $('#form-auth form').serialize();

        $.ajax({
            type: "post",
            url: "/login",
            data: data,
           success: function (data) {
               //в случае успешного получения ответа, форма регистрации скрывается
               $('#form-auth').css('display', 'none');
               $('#blackout').fadeOut();
               //вывод на екран логина пользователя и кнопки Выйти
               $("<div>").attr("id", "auth").insertBefore("#add");
               $("<a>").attr("id", "name").attr("href", "/home").appendTo("#auth").html(data.name);
               $("<br>").appendTo("#name");
               $("<a>").attr("id", "logout").attr("href", "/logout").appendTo("#auth").html('Выйти');
               $('#add').css("display", "none");
            }
        });

        return false;
    });
});