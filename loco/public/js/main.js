$(document).ready(function() {

    var path = $('meta[name="path"]').attr('value');
    var base = $('meta[name="base"]').attr('value');

    if(path == 'loco/statistics') {

        // Anima i numeri
        $('.stat').each(function(){
            countUp($(this).children('span'), 0, $(this).data('count'), .4*1000);
        })

    } else if (path == 'message/list') {

        setInterval(updateMessages, 5 * 1000);

        var form =  $('#message_form');
        form.submit(function() {
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    updateMessages();
                }
            });
            $('#message_form input[name="content"]').val('');

            return false;
        });

        $('.messages-content').animate({scrollTop: $('.messages-content')[0].scrollHeight});

    }

    function updateMessages() {
        $.get(base+'/message/getnew/int1/' + $('.messages-content').attr('data-int1') + '/int2/' + $('.messages-content').attr('data-int2') + '/timestamp/' + $('.messages-content').attr('data-timestamp'), function(data) {
            if(data.length > 0) {
                for(var i = 0; i < data.length; i++) {

                    var m = data[i];

                    $('.messages-content').append(
                        '<div class="message grid">'+
                            '    <div class="col-3-12">'+
                            '        <img src="data:image/jpeg;base64,'+base64_encode(m['author_profile_image']) +'" class="float-left profile" alt=""/>'+
                            '        <b>' + m['author'] +'</b>'+
                            '        <p>' + m['timestamp'] +'</p>'+
                            '    </div>'+
                            '    <div class="col-9-12">'+
                            '        <p>'+ m['content'] +'</p>'+
                            '    </div>'+
                            '</div>'
                    );

                }
                $('.messages-content').attr('data-int1', data[data.length-1]['author']);
                $('.messages-content').attr('data-int2', data[data.length-1]['recipient']);
                $('.messages-content').attr('data-timestamp', data[data.length-1]['timestamp']);

                setTimeout(function() {
                    $('.messages-content').animate({scrollTop: $('.messages-content')[0].scrollHeight});
                }, 50);
            }
        });
    }

    $('.button-goback').click(function() {
        window.history.back();
    });

    function countUp(element, from, to, duration) {
        //calculate frames
        var length = to - from;
        var frame = duration / length;
        if(from == to) return;
        var i = setInterval(function() {
            element.text(from++);
            if(from == to) clearInterval(i);
        }, frame);
    }

    function base64_encode(data) {

        var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
        var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            enc = '',
            tmp_arr = [];

        if (!data) {
            return data;
        }

        do { // pack three octets into four hexets
            o1 = data.charCodeAt(i++);
            o2 = data.charCodeAt(i++);
            o3 = data.charCodeAt(i++);

            bits = o1 << 16 | o2 << 8 | o3;

            h1 = bits >> 18 & 0x3f;
            h2 = bits >> 12 & 0x3f;
            h3 = bits >> 6 & 0x3f;
            h4 = bits & 0x3f;

            // use hexets to index into b64, and append result to encoded string
            tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
        } while (i < data.length);

        enc = tmp_arr.join('');

        var r = data.length % 3;

        return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
    }

});