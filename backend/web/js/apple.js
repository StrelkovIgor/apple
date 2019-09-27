$(function(){
    $('.js-gen').click(function(){
        //location.pathname.split('/')
        $('.apple > div').remove();
        ajax({req:'gen'}, function(e){
            for(var key in e.data){
                var el = e.data[key];
                var temp = shablon(el);
                $('.apple ').append(temp);
                buttonSet();
            }
        },location.href + '/ajax');
    });

    $('body').on('click','.js-go',function(){
        $('.apple > div').remove();
        var eatVal = $(this).parent().find('input').val();
        var id = $(this).parents('.item').data('id');
        ajax({req:$(this).data('req'),val:eatVal, id:id}, function(e){
            if(typeof e.data.error != "undefined") alert(e.data.error);
            for(var key in e.data.items){
                var el = e.data.items[key];
                var temp = shablon(el);
                $('.apple ').append(temp);
                buttonSet();
            }
        },location.href + '/ajax');
        return false;
    });
    buttonSet();
});

function shablon(el){
    return '<div class="item" data-id="'+ el.id+'">\n' +
    '        <div>'+ el.color+'</div>\n' +
    '        <div>'+ el.status+'</div>\n' +
    '        <div>'+ el.size+'</div>\n' +
    '    </div>';
}

function ajax(data,calback, url) {
    url = (typeof url != 'undefined')?url:location.href;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (resp) {
            resp = JSON.parse(resp);
            if (!resp) {
                alert('Пустой ответ от сервера');
                return false;
            }
            if (resp.success) {
                calback(resp);

            } else {
                alert(resp.message);
                return false;
            }
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
        },
        error: function () {
            alert('Нет ответа от сервера');
        }
    });
}
function buttonSet(){
    var temp = '<div class="btn-group">\n' +
        '            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\n' +
        '                Action\n' +
        '            </button>\n' +
        '            <div class="dropdown-menu">\n' +
        '                <a class="dropdown-item js-go" data-req="drop" href="">упасть</a><br>\n' +
        '                    <input type="value"><a class="dropdown-item js-go" data-req="eat" href="">съесть</a>\n' +
        '            </div>\n' +
        '        </div>'
    $('.apple > div').append(temp);

}