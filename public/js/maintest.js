$('document').ready(function () {


    $(' #form .editbutton').click(function () {
        $(' #task textarea').removeAttr("disabled");
        $(' #form .savebutton').removeAttr("disabled");
        $(this).attr("disabled", "disabled");
    });



    $(' #form .savebutton').click(function () {

        var id = $('.tasknumber p').html();
        var title = $('.tasktitle textarea').val();
        var description = $('.taskdescription textarea').val();
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
               $('.tasktitle textarea').val(data.title).attr("disabled", "disabled");
               $('.taskdescription textarea').val(data.description).attr("disabled", "disabled");
               alert(data.message);
               $(' #form .editbutton ').removeAttr("disabled");
               $(' #form .savebutton ').attr("disabled", "disabled");
               return false;


           }
        });



    });

    $( ' #addtaskhref .addtask ' ).click(function () {
        $('#addtask').css("display", "block");
        $('#create').css("display", "block");
        $('#annulment button').css("display", "block");
            
    });

    $('#annulment button').click(function () {
        $('#addtask').css("display", "none");
        $('#create').css("display", "none");
        $(this).css("display", "none");
    });

    $('.test').one('click', '.button',function (event) {
        event.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var elem = $(event.target);
        var type = elem.data('type');
        var id = elem.parents().data('id');


        switch(type) {
            case 'start':
                    if (!$('.taskwork ').hasClass("active")) {
                        elem.attr("disabled","disabled");
                        elem.nextAll().removeAttr("disabled");

                        $.ajax({
                            type: "post",
                            url: "/start",
                            data: {
                                id: id,
                                _token: token
                            },
                            success: function (data) {
                                elem.closest('.test').find('.taskstatus p').html(data.status);
                                elem.closest('.taskwork').attr('data-idtime', data.id);

                            }
                        });
                        elem.closest('.taskwork').addClass("active");
                        return false;

                    } else {

                        elem.eq(0).nextAll().removeAttr("disabled");

                         var oldid = $( '.active').closest('.test').find('.taskwork').data('id');
                         var oldidtime = $('.active ').closest('.test').find('.taskwork').data('idtime');

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

                                 $('.active ').closest('.test').find('.taskstatus p').append(data.statusold);
                                 $('.active ').closest('.test').find('.tasktime p').text(data.seconds);

                                elem.closest('.taskwork').attr('data-idtime', data.id);
                                elem.closest('.test').find('.taskstatus p').html(data.statusnew);
                            }
                        });

                        $('.active').closest('.test').find('.taskwork').removeAttr('data-idtime');

                        elem.attr("disabled","disabled");
                        var hide = $('.active ').closest('.test').find('.taskwork button').eq(0);
                        hide.removeAttr("disabled");
                        hide.nextAll().attr("disabled", "disabled");


                        $('.taskwork').removeClass('active');
                        elem.closest('.taskwork').addClass("active");




                        }

                    return false;
                    break;
               case 'pause':
                   var a = elem.closest('.taskwork').attr('data-idtime');
                   elem.attr("disabled","disabled");
                   elem.prev().removeAttr("disabled");
                   elem.next().attr("disabled","disabled");
                    $.ajax({
                        type: "post",
                        url: "/pause",
                        data: {
                            id: id,
                            _token: token,
                            idstart: a
                        },
                        success: function (data) {

                            elem.closest('.test').find('.taskstatus p').html(data.status);
                            elem.closest('.test').find('.tasktime p').html(data.seconds);
                            elem.closest('.taskwork').removeClass("active");
                            elem.closest('.test').find('.taskwork').removeAttr('data-idtime');

                        }
                    });
               break;
               case 'complete':
                   elem.closest('.taskwork').find('.button').attr("disabled","disabled");
                   var b = elem.closest('.taskwork').attr('data-idtime');
                   $.ajax({
                       type: "post",
                       url: "/complete",
                       data: {
                           id: id,
                           _token: token,
                           idend: b
                       },
                       success: function (data) {
                           elem.closest('.test').find('.taskstatus p').html(data.status);
                           elem.closest('.test').find('.tasktime p').html(data.seconds);
                           elem.closest('.taskwork').removeClass("active");
                           elem.closest('.test').find('.taskwork').removeAttr('data-idtime');

                       }
                   });
               break;
                }

    });

});