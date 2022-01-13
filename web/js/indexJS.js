$(document).ready(function() {
    $('a[data-sort=name]').click(function (e) { 
        e.preventDefault();
        $('#w1-filters').toggle();
    });
    function calculateDifference (popOver, rowIndex, diferenciaTd) {
        const input = $(popOver.find('input.kv-editable-input'));
        const inputType = input.attr('id').split('-')[2];
        const inputValue = input.val();
        
        const stock = inputType === 'stock' ? inputValue : $('#product-' + rowIndex + '-stock-targ').html();
        const sugerido = inputType === 'sugerido' ? inputValue : $('#product-' + rowIndex + '-sugerido-targ').html();

        diferenciaTd.html(sugerido - stock);
    }

    $('.kv-editable-popover').each(function(ind, elem) {
        const popOver = $(elem);
        const popOverId = $(elem).attr('id');
        
        const rowIndex = popOverId.split('-')[1];
        
        const diferenciaTd = $(popOver.parents('tr').find('td')[6]);
        const diferencia = diferenciaTd.html();
        
        popOver.find('.kv-editable-form').on('submit', function(e) {
            calculateDifference(popOver, rowIndex, diferenciaTd);
        });

        popOver.find('.kv-editable-submit').on('click', function(e) {
            calculateDifference(popOver, rowIndex, diferenciaTd);
        });
    });
/*
    $("#generar").submit(function (e) {
        e.preventDefault();
        var ids;
        var url = $('#form').attr('action');
        ids = $('input[name=selection]:checked').map(function() {
            return $(this).attr('id');
        }).get();
        $.ajax({
            type: "get",
            url: url,
            data: {ids},
            dataType: "dataType",
            success: function (response) {
                console.log(ids);
                console.log(response);
            },
            fail: function() {
                console.log('error');
            }
        });
    });*/
});