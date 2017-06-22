

var rombel = new Vue({
    el: '#dataRombel',
    data: {
        showDaftarRombel: false,
        daftarRombel: '',
    },
    methods: {
        getRombel(limit, start) {
            var self = this
            paging.offset = start * limit
            $.ajax({
                url: `${baseUrl}admin/RombelController/fetchRombel/${limit}/${paging.offset}/`,
                type: 'GET',
                dataType: 'json',
                success: data => {
                    self.daftarRombel = data['rombel']
                    setTimeout(() => {
                        self.showDaftarRombel = true
                    }, 400)

                    paging.totalRows = data['baris']
                    paging.create(data['baris'])

                    // atur nilai default untuk next page
                    start === (paging.last -= 1) ? paging.next = start : paging.next = start + 1

                    // atur nilai default untuk previous page
                    start === paging.first ? paging.prev = start : paging.prev = start - 1
                }
            })
        }
    },
})
