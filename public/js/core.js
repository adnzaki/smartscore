var core = new Vue({
    el: '#loader',
    data: {
        showLoader: false
    },
    methods: {
        formHasValue(form) {
            var fields = [];
            $(`${form} :input[type='text']`).each(function() {
                fields.push($(this).val());
            });

            var notBlankFields = fields.filter((fields) => {
                return fields.length > 0;
            })

            if(notBlankFields.length > 0) {
                return true;
            } else {
                return false;
            }
        },
    }
})
