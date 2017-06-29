<template>
    <div id="test">
        <table>
            <thead>
                <th>Nama Rombel</th>
                <th>Tingkat</th>
            </thead>
            <tbody>
                <tr v-for="list in rombel">
                    <td>{{ list.nama_rombel }}</td>
                    <td>{{ list.tingkat }}</td>
                </tr>
            </tbody>
        </table>
        <button type="button" name="button" @click="testLoad">Load!</button>
    </div>
</template>

<script>
import { apiUrl } from './global.js'

export default {
    name: 'ajax',
    data() {
        return {
            rombel: ''
        }
    },
    methods: {
        testLoad() {
            var self = this
            $.ajax({
                url: `${apiUrl}admin/rombelcontroller/fetchrombel/10/0`,
                type: 'GET',
                crossDomain: true,
                dataType: 'json',
                success: data => {
                    self.rombel = data['rombel']
                }
            })
        }
    }
}
</script>

<style lang="css">
</style>
