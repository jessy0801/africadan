$(function () {
   $(".delete").click(function () {
       if (confirm('Vous étes sur ?')) {
           $.get("delete.php", {id: $(this).attr('data-id')}).done(function () {
               console.log('suprimer !');
           })
       } else {

       }

   });


    $(".delete-cat").click(function () {
        if (confirm('Vous étes sur ?')) {
            $.get("delete.php", {cat: $(this).attr('data-id')}).done(function () {
                console.log('suprimer !');
            })
        } else {

        }

    });


});