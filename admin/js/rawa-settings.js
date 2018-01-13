(function($){
    function foundIt() {
        var selectThis = $('#rawa_aos_disable');
        var tableBody = $('.form-table tbody tr:nth-child(6)');

        switch(selectThis.val()) {
            case 'custom':
                tableBody.show();
                console.log('custom');
                break;
            default: 
                tableBody.hide();
                break;
        }

        selectThis.on('change', function(){
            var selection = $(this).val();
            console.log(selection);
            switch(selection) {
                case 'custom':
                    tableBody.show();
                    console.log('custom');
                    break;
                default: 
                    tableBody.hide();
                    break;
            }
        });
    }
    $(document).ready(function(){
        foundIt();
    });

    $(document).ajaxStop(function(){
        foundIt();
    });
    $(document).on('widget-added widget-updated', function(){
        foundIt();
    });
})(jQuery);