$(function() {
    // Datatime Picker
    $('#date').datetimepicker({
        locale: 'zh-cn',
        format: 'YYYY-MM'
    });

    // Google Maps Autocomplete input
    $('#location').select2({
        ajax: {
            url: '/here/placeAutocomplete',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    input: params.term
                };
            },
            processResults: function(data) {
                if ('OK' === data.status) {
                    var list = [];
                    for (i in data.predictions) {
                        list[i] = {
                            id: data.predictions[i].place_id,
                            text: data.predictions[i].description
                        };
                    }
                    return {
                        results: list,
                        more: false
                    };
                } else {
                    return {
                        results: [{
                            disabled: true,
                            loading: true,
                            text: data.status
                        }]
                    };
                }
            },
            cache: true
        },
        theme: 'bootstrap'
    });
});
