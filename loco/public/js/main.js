$(document).ready(function() {

//    setTimeout(function() {
  //      $('#loader').fadeOut();
    //}, 500);

    var path = $('meta[name="path"]').attr('value');
    var base = $('meta[name="base"]').attr('value');

    var datepicker_opts = {
        numberOfMonths: 3,
        showButtonPanel: true,
        dateFormat: "yy-mm-dd"
    };

    var slider_opts = {
        range: true,
        min: 50,
        max: 1000,
        values: [ 50, 500 ],
        slide: function( event, ui ) {
            console.log(ui)
            $( "#rangeslider-fee > label > span.from" ).text("€" + ui.values[ 0 ] );
            $( "#rangeslider-fee > label > span.to" ).text( "€" + ui.values[ 1 ] );
            $('#fee_from').val(ui.values[0]);
            $('#fee_to').val(ui.values[1]);
        }
    }


    if(path == 'loco/statistics') {

        // Anima i numeri
        $('.stat').each(function(){
            countUp($(this).children('span'), 0, $(this).data('count'), .4*1000);
        });
        $('#from').datepicker(datepicker_opts);
        $('#to').datepicker(datepicker_opts);


    } else if (path == 'accomodation/search' || path == 'accomodation/add' || path == 'accomodation/edit') {

        $('#available_from').datepicker(datepicker_opts);
        $('#available_untill').datepicker(datepicker_opts);
        $('#fee_from-element').prepend('<div id="rangeslider-fee"><label>Canone da <span class="prezzo from"></span> a <span class="prezzo to"></span></label><br/><br/><div></div></div>');
        $('#fee_from').hide();
        $('#fee_to').hide();
        $('#rangeslider-fee > div').slider(slider_opts);

        if($('#fee_from').val() && $('#fee_to').val()) {
            $( "#rangeslider-fee > div" ).slider( "values", 0, $('#fee_from').val());
            $( "#rangeslider-fee > div" ).slider( "values", 1, $('#fee_to').val());
        }

        $( "#rangeslider-fee > label > span.from" ).text("€" + $( "#rangeslider-fee > div" ).slider( "values", 0 ));
        $( "#rangeslider-fee > label > span.to" ).text("€" + $( "#rangeslider-fee > div" ).slider( "values", 1 ));

        $('#type').change(function(e) {
            var val = $(this).val();
            var name = $(this).find("option:selected").text();
            name = name.replace(' ', '');
            $('.search-display-group').hide();
            $('#fieldset-'+name).show();
        });

        $('#type').trigger('change');

    } else if (path == 'user/login') {

        $('.login .login-cont').animate({
            left: 0,
            opacity: 1
        });

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

    } else if(path == 'user/profile-edit' || path == 'user/register') {
        datepicker_opts['changeMonth'] = true;
        datepicker_opts['changeYear'] = true;
        datepicker_opts['numberOfMonths'] = 1;
        datepicker_opts['defaultDate'] = new Date(1991, 01, 01);

        $('#birth').datepicker(datepicker_opts);
    }

    $('form[data-confirm]').submit(function(e) {
        return confirm($(this).data('confirm'));
    });

    $('a[data-confirm]').click(function(e) {
        e.preventDefault();

        if(confirm($(this).data('confirm')))
            window.location = $(this).attr('href');
    });

    var updating = false;
    function updateMessages() {
        if(updating = true) return;
        updating = true;
        $.get(base+'/message/getnew/int1/' + $('.messages-content').attr('data-int1') + '/int2/' + $('.messages-content').attr('data-int2') + '/timestamp/' + $('.messages-content').attr('data-timestamp'), function(data) {
            updating = false;
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