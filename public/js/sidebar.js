var sidebar = new Vue({
    el: '#aside',
    data: {
        modal: {
            siswaIsFilled: false
        }
    },
    methods: {
        forceShowDaftarSiswa() {
            $('#formTambahSiswa').trigger("reset");
            setTimeout(() => {
                this.modal.siswaIsFilled = false;
                siswa.getSiswa(siswa.limit, siswa.offset);
                siswa.clearMessages();
            }, 100);
        }
    }
})
