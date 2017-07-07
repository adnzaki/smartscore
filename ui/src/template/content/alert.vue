<template lang="html">
    <div class="padding less-m-b">
        <div v-bind:class="[alert, alertClass, alertDismissible, noBr]" role="alert" v-if="target">
            <button type="button" class="close" @click="target = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{ initMsg }}</strong> {{ msg }}
            <a href="javascript:void(0)" @click="action" v-if="isInsert">
                <b><u>Lihat detail</u></b>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ssalert',
    props: ['alertClass', 'target', 'initMsg', 'msg', 'isInsert', 'action'],
    data() {
        return {
            alert: 'alert', alertDismissible: 'alert-dismissible', noBr: 'ss-no-b-r'
        }
    }
}
</script>

<style lang="css">
</style>
