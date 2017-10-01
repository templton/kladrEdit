"use strict";

$(document).ready(function () {
    $('.head-list').on('click', function () {
        Controller.headClick(this);
    });

    $('[name="search"]').on('keyup', function () {
        var d1 = new Date();
        var start_time = d1.getTime();
        var first = $(this).val().trim();
        if (timer === undefined) {
            var timer = setTimeout(function () {
                var text = $('[name="search"]').val().trim();
                if (text.length > 3 && first == text) {
                    clearTimeout(timer);
                    timer = undefined;
                    Controller.searchKeyword(text);
                }
            }, 700);
        }
    });
});


//Главный контроллер
var Controller = {
    //Загрузить список для заданного child
    loadDisplay: function (child, callback) {
        $.post('index.php?ajax=1', {filters: {child: child}, action: 'getLists'}, function (result, status) {
            result = JSON.parse(result);
            if (result.error !== undefined) {
                alert(result.error);
            } else {
                if (callback) {
                    callback(result);
                }
            }
        })
    },

    //Обработчик заголовка для загрузки списка по клику
    //head - элемент, на котором был клик
    headClick: function (head) {
        var child = $(head).attr('child');
        var block = $('#child-' + child);
        if (block.hasClass('empty')) {
            Controller.loadDisplay(child, function (result) {

                var level = $(head).attr('level');
                level++;

                var paddingLeft = level * 20;
                block.css('padding-left', paddingLeft + "px");
                block.addClass('in');

                block.append('<div class="block-level">');
                for (var i in result.data) {
                    block.append(Controller.getChildEl(result.data[i], level));
                }
                block.append('</div>');


                block.removeClass('empty');

                $('[child=' + child + ']').attr('data-toggle', 'collapse');
                $('[child=' + child + ']').attr('data-target', '#child-' + child);
                $('[child=' + child + ']').collapse();
            });
        }

        $('[child=' + child + ']').toggleClass('opened');
        $('[child=' + child + ']').toggleClass('closed');
    },

    //Показать окно редактирования элемента
    showEditWindow: function (id) {
        var item = $('.title[child="' + id + '"]');
        var text = $(item).find('.text').text().trim();
        $('#editwinow .item-id').text(id);
        $('#editwinow [name="item-name"]').val(text);

        $('#editwinow .save-btn').off().on('click', function () {
            var text = $('#editwinow [name="item-name"]').val().trim();

            //Запрос на редактирование
            $.post('index.php?ajax=1', {filters: {id: id, text: text}, action: 'editItemTree'}, function (result, status) {
                result = JSON.parse(result);
                if (result.error !== undefined) {
                    alert(result.error);
                } else {
                    //В случае успешного редактирования, меняем текст на странице
                    $('.title[child="' + id + '"] .text').text(text);
                    $('#editwinow .close-btn').click();
                }
            })

        });

        $('#editwinow').modal('show');
    },

    //Поиск по справочнику
    searchKeyword: function (text) {
        $.post('index.php?ajax=1&search=' + text, {}, function (result, status) {
            result = JSON.parse(result);
            if (result.error !== undefined) {
                alert(result.error);
            } else {
                console.log(result);
                //Очистить блок с деревом
                $('#list').html('');
                var block = $('#list');
                //Перебор найденных элементов
                for (var i in result) {

                    if (result[i].parent_id === null) {
                        block.append(Controller.getMainEl(result[i]));
                    } else {

                        if ($('#child-' + result[i]['parent_id']).length > 0) {
                            var childBlock = $('#child-' + result[i]['parent_id']);
                            var level = $('[child=' + result[i]['parent_id'] + ']').attr('level');
                            var paddingLeft = level * 20;
                            childBlock.css('padding-left', paddingLeft + "px");
                            childBlock.append(Controller.getChildEl(result[i], level));
                            childBlock.removeClass('collapse');
                        }

                    }

                }
            }
            Controller.showWords(text);
        })
    },

    //Получить заполненный шаблон элемента верхнего уровня
    getMainEl: function (item) {
        var el = '<div class="wrapper-item">';
        el += '<i class="glyphicon glyphicon-edit edit-item" aria-hidden="true" onclick="Controller.showEditWindow(' + item['id'] + ')"></i>';
        el += '<div class="head-list title closed" level="1" child="' + item['id'] + '">';
        el += '<i class="glyphicon glyphicon-chevron-right chevron" aria-hidden="true"></i>';
        el += '<i class="glyphicon glyphicon-chevron-down chevron" aria-hidden="true"></i>';
        el += '<span class="text">' + item['name'] + '</span>';
        el += '</div>';
        el += '</div>';
        el += '<div class="child-list empty collapse" id="child-' + item['id'] + '" parent="' + item['id'] + '">';
        el += '</div>';
        return el;
    },

    //Получить заполненный шаблон подчиненного элемента элемента
    getChildEl: function (item, level) {

        //Загружать вложенный список по клику, если текущий элемент имеет вложенные элементы
        var action = "";
        //Иконки
        var icon = "";

        if (item['node_count'] > 0) {
            var action = 'onclick="Controller.headClick(this);"';
            icon += '<i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i>';
            icon += '<i class="glyphicon glyphicon-chevron-down" aria-hidden="true"></i>';
        }

        var el = '<div class="wrapper-item">';
        el += '<i class="glyphicon glyphicon-edit edit-item" aria-hidden="true" onclick="Controller.showEditWindow(' + item['id'] + ')"></i>';
        el += '<div class="head-list title closed" level="' + level + '" child="' + item['id'] + '" ' + action + '>';
        el += icon;
        el += '<span class="text">' + item['name'] + '</span>';
        el += '</div>';
        el += '<div class="child-list empty collapse" id="child-' + item['id'] + '" parent="' + item['id'] + '">';
        el += '</div>';
        el += '</div>';
        return el;
    },

    //Подсветить заданный текст на странице
    showWords: function (text) {
        jQuery('#list').html(jQuery('#list').html().replace(new RegExp(text, 'ig'), '<span class="highlight">$&</span>')); // выделяем найденные фрагменты
        var n = jQuery('span.highlight').length; // количество найденных фрагментов
        console.log('n = ' + n);
        if (n == 0) {
            jQuery('#spresult').html('Ничего не найдено');
        } else {
            jQuery('#spresult').html('Результатов: ' + n);
        }
    },
}
