var sidebar = new Vue({
    el: '#aside',
    data: {},
    methods: {
        loadSiswa: function() {
            core.showLoader = true;
            siswa.getSiswa();
            core.showLoader = false;
        }
    }
})
