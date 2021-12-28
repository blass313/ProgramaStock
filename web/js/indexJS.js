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
});