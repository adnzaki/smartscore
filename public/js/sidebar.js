var sidebar = new Vue({
    el: '#aside',
    data: {
        modal: {
            siswaIsFilled: false
        }
    },
    methods: {
        forceShowDaftarSiswa: function() {
            siswa.showFormAdd = false;
            this.modal.siswaIsFilled = false;
            setTimeout(() => {
                siswa.getSiswa(siswa.limit, siswa.offset);
            }, 100);
        }
    }
})
