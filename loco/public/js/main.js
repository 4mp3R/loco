$(document).ready(function() {

    var path = $('meta[name="path"]').attr('value');

    if(path == 'loco/statistics') {

        // Anima i numeri
        $('.stat').each(function(){
            countUp($(this).children('span'), 0, $(this).data('count'), .4*1000);
        })

    }

    function countUp(element, from, to, duration) {
        //calculate frames
        var length = to - from;
        var frame = duration / length;
        if(from == to) return;
        console.log(element, from, to, duration);

        var i = setInterval(function() {
            element.text(from++);
            if(from == to) clearInterval(i);
        }, frame);
    }

});