$(function(){

    function calculate_price(){
        var price = 0;
        var type = $("input[name='customRadio']:checked").val();
        var duration = $("input[name='customRadiod']:checked").val();

        $("input[id^='sport']").each(function(){
            if($(this).is(":checked")){
                var sportprice = $(this).attr('data-price');
                //mettre ta formule
                var subprice = sportprice;
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

/*<tbody>
    {% set p = price %}
    <tr>
    {% set pe = p - (p * 15/100) %}
    <th scope="row">Enfant</th>
        <td>{{ pe }}</td>
    <td>{{ pe * 3 }}</td>
    <td>{{ pe * 6 - (pe / 2) }}</td>
    <td>{{ pe * 11 }}</td>
    </tr>
    <tr>
    <th scope="row">Basic</th>
        <td>{{ p }}</td>
    <td>{{ p * 3 }}</td>
    <td>{{ p * 6 - (p / 2) }}</td>
    <td>{{ p * 11 }}</td>
    </tr>
    <tr>
    {% set pv = p * 1.25 %}
    <th scope="row">VIP</th>
        <td>{{ pv }}</td>
    <td>{{ pv * 3 }}</td>
    <td>{{ pv * 6 - (pv / 2) }}</td>
    <td>{{ pv * 11 }}</td>
    </tr>
</tbody>*/