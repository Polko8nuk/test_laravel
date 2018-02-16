$('document').ready(function () {
    //при нажатии на кнопку редактировать, на странице просмотр задачи, textarea становяться активными для редактирования
    $(' #form .editbutton').click(function () {
        //
        $(' #task textarea').removeAttr("disabled");
        $(' #form .savebutton').removeAttr("disabled");
        $(this).attr("disabled", "disabled");
    });

    //при нажатии на кнопку Сохранить, отправляется Ajax запрос на сервер.
    $(' #form .savebutton').click(function () {
        //получение id задачи
        var id = $('.tasknumber p').html();
        //получение значения поля наименование задачи
        var title = $('.tasktitle textarea').val();
        //получение значения поля описания задачи
        var description = $('.taskdescription textarea').val();
        //получение токена, который формирует сервер
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "post",
            url: "/edit",
            data: {
                title: title,
                description: description,
                id: id,
                _token: token
            },
           success: function (data) {
               //записываем обновленные данные и убираем возможность редактировать
               $('.tasktitle textarea').val(data.title).attr("disabled", "disabled");
               $('.taskdescription textarea').val(data.description).attr("disabled", "disabled");
               //ссобщение об успешном создании
               alert(data.message);
               //кнопка Редактировать становиться активной
               $(' #form .editbutton ').removeAttr("disabled");
               //кнопка Сохранить - не активной
               $(' #form .savebutton ').attr("disabled", "disabled");

               return false;
           }
        });



    });

    //При нажатии на кнопку Добавить задачу, textarea становяться активными и появляется кнопка Отменить
    $( ' #addtaskhref .addtask ' ).click(function () {
        $('#addtask').css("display", "block");
        $('#create').css("display", "block");
        $('#annulment button').css("display", "block");
            
    });

    //При нажатии на кнопку Отмена, textarea и сама кнопка скрываются
    $('#annulment button').click(function () {
        $('#addtask').css("display", "none");
        $('#create').css("display", "none");
        $(this).css("display", "none");
    });


    //При помощи делегирования событий, получаю события на определенной кнопке.

    $('.test').on('click', '.button',function (event) {
        //отменяет стандартное действие
        event.preventDefault();
        //получаю токен
        var token = $('meta[name="csrf-token"]').attr('content');
        //получаю указатель на текущий обьект
        var elem = $(event.target);
        //получаю тип нажатой кнопки
        var type = elem.data('type');
        //получение id текущей задачи
        var id = elem.parents().data('id');

        //получение указателя предыдущую активную задачу
        var active = $( '.active').closest('.test');
        //получение указателя на текущую задачу
        var oldid = active.find('.taskwork').data('id');
        //получение метки времени на предыдущую задачу
        var oldidtime = $('body').attr('data-idtime');

        /* в зависимости от типа кнопки, выполняют запросы  на сервер через Ajax
        * при нажатии на кнопку старт, текущая задача становиться активной
        * при следующем нажатии, получаю предыдущую активную задачу, для ее завершения или паузы */
        switch(type) {
            case 'start':
                    //когда нет активных задач
                    if (!$('.taskwork ').hasClass("active")) {
                        //кнопка старт становиться не активной
                        elem.attr("disabled","disabled");
                        //кнопка пауза и завершить активной
                        elem.nextAll().removeAttr("disabled");
                        $.ajax({
                            type: "post",
                            url: "/start",
                            data: {
                                id: id,
                                _token: token
                            },
                            success: function (data) {
                                //записываем текущее состояние задачи
                                elem.closest('.test').find('.taskstatus p').html(data.status);
                                //записываем новую временную метку
                                elem.closest('.taskwork').attr('data-idtime', data.id);
                                //запись метки времени на текущую задачу
                                $('body').attr('data-idtime', data.id);
                            }
                        });
                        //текущая задача становиться активной
                        elem.closest('.taskwork').addClass("active");

                    } else {
                         //кнопка пауза и завершить становяться активной
                         elem.eq(0).nextAll().removeAttr("disabled");
                         //получение id предыдущей задачи
                        // oldid = $( '.active').closest('.test').find('.taskwork').data('id');
                        //получение временной метки предыдущей задачи для ее остановки
                         //oldidtime = $('.active ').closest('.test').find('.taskwork').data('idtime');

                        $.ajax({
                            type: "post",
                            url: "/change",
                            data: {
                                idold: oldid,
                                _token: token,
                                 idtimeold: oldidtime,
                                id: id
                            },
                            success: function (data) {
                                //записываем временную метку для текущей задачи
                                elem.closest('.taskwork').attr('data-idtime', data.id);
                                //записываем статус
                                elem.closest('.test').find('.taskstatus p').html(data.statusnew);
                                //запись метки времени на текущую задачу
                                $('body').attr('data-idtime', data.id);
                                //заменя статуса и времени для предыдущей задачи
                                var status = data.statusold;
                                active.find('.taskstatus p').html(status);
                                var time = data.seconds;
                                active.find('.tasktime p').html(time);
                            }
                        });
                        //получения указателя для предыдущую активную задачу
                        var lasttask = $('.active').closest('.test');
                        //удаление временной метки в предыдущей активной задаче
                        lasttask.find('.taskwork').removeAttr('data-idtime');
                        //поле старт становиться не активным
                        elem.attr("disabled","disabled");
                        //кнопка старт становиться активной
                        var passive = lasttask.find('.taskwork button').eq(0).removeAttr("disabled");
                        //кнопки пауза и завершить - неактивными
                        passive.nextAll().attr("disabled", "disabled");
                        //предыдущая активная задача становиться не активной
                        $('.taskwork').removeClass('active');
                        //текущая задача становиться активной
                        elem.closest('.taskwork').addClass("active");

                    }
                    break;
               case 'pause':
                   //получаем временную метку активной задачи
                   var a = elem.closest('.taskwork').attr('data-idtime');
                   //кнопка пауза становиться не активной
                   elem.attr("disabled","disabled");
                   //кнопка старт активной
                   elem.prev().removeAttr("disabled");
                   //кнопка завершить не активной
                   elem.next().attr("disabled","disabled");
                   //получение указателя на родителя
                   var parent = elem.closest('.test');
                   var markpause = "pause";
                    $.ajax({
                        type: "post",
                        url: "/pause",
                        data: {
                            id: id,
                            _token: token,
                            idstart: a,
                            mark: markpause
                        },
                        success: function (data) {
                            //отображние статуса задачи
                            parent.find('.taskstatus p').html(data.status);
                            //отображение времени
                            parent.find('.tasktime p').html(data.seconds);
                            //текущая задача становиться не активной
                            elem.closest('.taskwork').removeClass("active");
                            //временная метка для текущей задачи удаляется
                            parent.find('.taskwork').removeAttr('data-idtime');

                        }
                    });
               break;
            case 'complete':
                   //при нажатии кнопки завершить, все кнопки данной задачи, становяться не активными
                   elem.closest('.taskwork').find('.button').attr("disabled","disabled");
                   //получение временной метки текущей задачи
                   var data = elem.closest('.taskwork').attr('data-idtime');
                   //получение указателя на родителя
                   var parentcomplete = elem.closest('.test');
                   var markcomplete = "complete";
                   $.ajax({
                       type: "post",
                       url: "/pause",
                       data: {
                           id: id,
                           _token: token,
                           idstart: data,
                           mark: markcomplete
                       },
                       success: function (data) {
                           //отображение статуса
                           parentcomplete.find('.taskstatus p').html(data.status);
                           //отображение времени
                           parentcomplete.find('.tasktime p').html(data.seconds);
                           //текущая задача становиться не активной
                           elem.closest('.taskwork').removeClass("active");
                           //временная метка для текущей задачи удаляется
                           parentcomplete.find('.taskwork').removeAttr('data-idtime');
                       }
                   });
               break;
        }
    });
});