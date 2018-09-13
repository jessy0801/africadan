$(document).ready(function() {

    var modal = $("#mymodal"),
        test = 0,
        test1 = $("#dropdown_icon"),
        opt_img = document.getElementsByClassName("modal-opt-img"),
        opt_img_jq = $(".modal-opt-img"),
        modal_txt = $("#modal-text"),
        modal_txt_hand = $("#modal-text-handheld");
    /*for (var test in img_sm) {
        if (Number.isInteger(test)) {*/
    $(".nav .nav-link").on("click", function(){
        $(".nav").find(".active").removeClass("active");
        $(this).addClass("active");
    });


    $(".item-contener").click( function () {
        console.log($(this).attr('data-src'));
        $('.enlargeImageModalSource').attr('src', 'public/img/statue/'+$(this).attr('data-src'));
        var maxwidth = $('.enlargeImageModalSource').width / 6;
        console.log(maxwidth);
        for (var i = 0 ; i<opt_img.length; i++) {
            opt_img[i].setAttribute('src', 'public/img/statue/'+$(this).attr('data-src').split('.')[0]+'-'+i+'.'+$(this).attr('data-src').split('.')[1]);
            opt_img[i].style.maxWidth =  (maxwidth-4)+'px';
        }
        $('#modal-title').html($(this).attr('data-title'));
        $.post( "ajax.php", { id: $(this).attr('data-id') })
            .done(function( data ) {
                console.log( "Data Loaded: " + data );
                modal_txt.html(data);
                modal_txt_hand.html(data);
            });
        modal.modal('show');
    });
    opt_img_jq.click(function () {
        $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
    });
    /*}

}*/
    $(".dropdown-toggle").click( function () {

        if (test%2 === 0) {
            test1.attr('class', 'rotated');
        } else if (test%2 === 1) {
            test1.attr('class', '');
        }
        test++;


    })



});