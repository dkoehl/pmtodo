
/**
 * ToDo: Clean up ;)
 * Automatically init
 */
$(document).ready(function () {
    /**
     * Gets Project Form
     */
    $("a.editProject").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',

            success: function (success) {
                $( ".projectEditResponse" ).html(success);
                $( ".projectEditResponse" ).slideDown( "fast", function() {
                    $( ".projectEditResponse" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#scrolltop").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    /**
     * Gets the Task Form
     */
    $("a.editTask").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',

            success: function (success) {
                $( "#showTaskForm" ).html(success);
                $( "#showTaskForm" ).slideDown( "fast", function() {
                    $( "#showTaskForm" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#showTaskForm").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    // Holt Edit Todo Form
    $("a.editTodo").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',

            success: function (success) {
                $( "#showTodoForm" ).html(success);
                $( "#showTodoForm" ).slideDown( "fast", function() {
                    $( "showTodoForm" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#scrolltoTodo").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Holt NEW Todo Form
    $("a#newTodo").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',

            success: function (success) {
                $( "#showTodoForm" ).html(success);
                $( "#showTodoForm" ).slideDown( "fast", function() {
                    $( "#showTodoForm" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#scrolltoTodo").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    // Holt NEW Task Form
    $("a#newTask").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',

            success: function (success) {
                $( "#showTaskForm" ).html(success);
                $( "#showTaskForm" ).slideDown( "fast", function() {
                    $( "#showTaskForm" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#showTaskForm").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    // Holt NEW Project Form
    $("a#newProject").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href")+'&type=666',
            type: "GET",
            data: '',
            success: function (success) {
                $( ".projectEditResponse" ).html(success);
                $( ".projectEditResponse" ).slideDown( "fast", function() {
                    $( ".projectEditResponse" ).css('display','block');
                    closeEditForm()
                    _initFileUpload();
                    $('html, body').animate({
                        scrollTop: $("#scrolltop").offset().top
                    })
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });



    // Zeigt Detail View an
    $("span.glyphicon-search").on("click",function(e){
        url = $(this).parent().attr("href")+'&type=666'
        e.preventDefault();
        $.ajax({
            url: url,
            type: "GET",
            data: '',

            success: function (success) {
                $( ".modal-body" ).html(success);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });










    /**
     * Close Edit/New Form
     */
    function closeEditForm(){
        $('a.close').on('click', function () {
            $( this).parent().parent().slideUp( "slow", function() {
                $(this).parent().parent().parent().hide('fast')
            });
            return false;
        })
    }


    /**
     * Löschen
     */
    $('span.glyphicon.glyphicon-trash.pull-right').on('click', function (e) {
        e.preventDefault();
        url = $(this).parent().attr("href")+'&type=666'

        answer = confirm("Wirklich löschen?");
        if(answer == true){
//            alert('wird gelöscht')
            $(this).parent().parent().hide('slow', function() {
                $(this).css('display','none');
            });
            $.ajax({
                url: url,
                type: "GET",
                data: '',

                success: function (success) {
                    $( "#resolvedTodo" ).html('<div class="alert alert-danger" role="alert"><strong>Gelöscht!</strong> Objekt wurde erfolgreich gelöscht</div>');
                    $( "#resolvedTodo" ).slideDown( "fast", function() {
                        $( "resolvedTodo" ).css('display','block');
                    });
                    $('#resolvedTodo').delay(1200).slideUp('fast', function(e){
                        $( "resolvedTodo" ).css('display','none');
                    })
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }else{
//            alert('wird NICHT gelöscht')
        }

        return false;
    })


    /**
     * Fileupload
     * @private
     */
    var _initFileUpload = function(){
        var ul = $('#upload ul');
        $('#fileupload').find('#upload').fileupload({
            // This element will accept file drag/drop uploading
            dropZone: $('#drop'),

            // This function is called when a file is added to the queue;
            // either via the browse button, or via drag/drop:
            add: function (e, data) {

                var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                    ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

                // Append the file name and file size
                tpl.find('p').text(data.files[0].name)
                    .append('<i>' + _formatFileSize(data.files[0].size) + '</i>');

                // Add the HTML to the UL element
                data.context = tpl.appendTo(ul);

                // Initialize the knob plugin
                tpl.find('input').knob();

                // Listen for clicks on the cancel icon
                tpl.find('span').click(function(){

                    if(tpl.hasClass('working')){
                        jqXHR.abort();
                    }

                    tpl.fadeOut(function(){
                        tpl.remove();
                    });

                });

                // Automatically upload the file once it is added to the queue
                var jqXHR = data.submit();
            },

            progress: function(e, data){

                // Calculate the completion percentage of the upload
                var progress = parseInt(data.loaded / data.total * 100, 10);

                // Update the hidden input field and trigger a change
                // so that the jQuery knob plugin knows to update the dial
                data.context.find('input').val(progress).change();

                if(progress == 100){
                    data.context.removeClass('working');
                }
            },

            fail:function(e, data){
                // Something has gone wrong!
                data.context.addClass('error');
            },


            success: function(datareturn){
                $('<input type="hidden" value="'+datareturn+'" name="tx_pmtodo_pmtodo[file][]">').appendTo('form');
                $('form#upload input.uploadField').hide();
            }

        });
    }

    // Helper function that formats the file sizes
    var _formatFileSize = function(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }







    /**
     * Handles resolve Items
     */
    var _handleOptions = function () {
        $('span.glyphicon-ok').on('click', function () {
            var theOptionAction, $itemElem;
            theOptionAction = $(this).attr('class');
            $itemElem = $(this).parent().parent().parent();
            var ajaxUrl = $(this).parent().attr("href")+'&type=666';
            switch (theOptionAction.replace('glyphicon glyphicon-ok ', '')) {
                case 'deactivate':
                    $(this).removeClass('deactivate').addClass('activate');
                    $(this).next('.share').removeClass('share').addClass('delete');
                    $itemElem.addClass('inactive');
                    $.ajax({
                        url: ajaxUrl,
                        type: "GET",
                        data: '',
                        success: function (success) {
                            $( "#resolvedTodo" ).html('<div class="alert alert-success" role="alert"><strong>Super</strong>, weiter so!</div>');
                            $( "#resolvedTodo" ).slideDown( "fast", function() {
                                $( "resolvedTodo" ).css('display','block');
                            });
                            $('#resolvedTodo').delay(700).slideUp('fast', function(e){
                                $( "resolvedTodo" ).css('display','none');
                            })
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                    return false;
                    break;

                case 'activate':
//                    console.log('AKTIVIEREN!');
                    $(this).removeClass('activate').addClass('deactivate');
                    $(this).next('.delete').removeClass('delete').addClass('share');
                    $itemElem.removeClass('inactive');
                    $.ajax({
                        url: ajaxUrl,
                        type: "GET",
                        data: '',

                        success: function (success) {
                            $( "#resolvedTodo" ).html('<div class="alert alert-info" role="alert"><strong>Rebound!</strong> Der Ball ist wieder im Rennen</div>');
                            $( "#resolvedTodo" ).slideDown( "fast", function() {
                                $( "resolvedTodo" ).css('display','block');
                            });
                            $('#resolvedTodo').delay(1200).slideUp('fast', function(e){
                                $( "resolvedTodo" ).css('display','none');
                            })

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                    return false;
                    break;
                default:
                    return false;
                    break;
            }
        });
    }
    _handleOptions();
    closeEditForm();



    // BREADCRUMP - Projects
    var activeProject = sessionStorage.getItem("project");
    $('li.list-group-item#'+activeProject).addClass("active");
    $('div#tasks div#'+activeProject).removeClass("hide");




    // DARSTELLUNG
    $('ul#projects li').on('click', function (e) {
        e.preventDefault();
        theOptionAction = $(this).attr('id');

        $('#todos > div').each(function(){
            $(this).addClass('hide');
        });

        // PROJECTs
        $('ul#projects li').each(function(){
            projektid = $(this).attr('id');
            if(projektid == theOptionAction){
                $(this).addClass("active")
                sessionStorage.setItem("project",theOptionAction);
            }else{
                $(this).removeClass("active",400)
                $('ul#'+theOptionAction).removeClass('hide');
            }
        });




        // TASKS
        $(this).removeClass('hide',500)
        $('html, body').animate({
            scrollTop: $("#tasks").offset().top
        }, 500);

        $('#tasks > div').each(function(){
            taskitem = $(this).attr('id');
            if(taskitem != theOptionAction){
                $(this).addClass("hide")
            }else{
                $(this).removeClass('hide');
            }
        });
        return false;
    });





    // BREADCRUMP - Tasks
    var activeTask = sessionStorage.getItem("task");
    $('li.list-group-item.task[name='+activeTask+']').addClass("active");
    $('#todos #'+activeTask).removeClass("hide");

    // TODOs
    $('li.list-group-item.task h4 a').on('click', function (e) {
        e.preventDefault();
        taskId = $(this).parent().parent().attr('name');
        // AKTIV Status
        $('#tasks ul.list-group li').each(function(){
            taskname = $(this).attr('name');
            if(taskname == taskId){
                $(this).addClass('active',200);
                sessionStorage.setItem("task",taskId);
            }else{
                if($(this).hasClass("active")){
                    $(this).removeClass("active",100)
                }
            }
        });

        $('#'+taskId).removeClass('hide');

        // Scroll zu Todos
//        $('html, body').animate({
//            scrollTop: $("#todos").offset().top
//        }, 1000);

        $('#todos > div').each(function(){
            projektid = $(this).attr('id');

            if(taskId == projektid){
                $('ul#'+projektid).removeClass('hide',500);
            }else{
                if ( $( this ).hasClass( "hide" ) ) {
                }else{
                    $('#'+projektid).addClass('hide'),500;
                }

            }
        });

        return false;
    })


    // Scroll zu Projekte
    $("html, body").animate({ scrollTop: $('div.col-xs-12.col-sm-5.col-md-4 > h2').height() }, 1000);

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function(){
        $('html, body').animate({scrollTop : 50},800);
        return false;
    });


});
