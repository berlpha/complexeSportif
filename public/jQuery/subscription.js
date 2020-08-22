$(function(){

    function calculate_price(){
        var price = 0;
        var type = $("input[name='customRadio']:checked").val();
        var duration = $("input[name='customRadiod']:checked").val();

        $("input[id^='sport']").each(function(){
            if($(this).is(":checked")){
                var sportprice = $(this).attr('data-price');
                var p = sportprice;

                if ( type == 'Enfant' )
                {
                    p =  sportprice * 0.85;
                }
                else if (type == 'VIP')
                {
                    p = sportprice * 1.25;
                }

                var subprice = p;

                if(duration == 'durationThreeMonth')
                {
                    subprice = p * 3;
                }
                else if (duration == 'durationSixMonth')
                {
                    subprice = p * 6 - (p / 2);
                }
                else if( duration == 'durationOneYear')
                {
                    subprice = p * 11;
                }
                price += parseFloat(subprice);
            }
        });

        $('#price').val(price);
    }

    $("input[name='customRadio']").change(function(){
        calculate_price();
    });

    $("input[name='customRadiod']").change(function(){
        calculate_price();
    });

    $("input[id^='sport']").change(function(){
        // alert($(this).val());
        // alert($(this).is(':checked'));
        calculate_price();
    });
});





