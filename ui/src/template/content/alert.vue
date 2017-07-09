<template lang="html">
    <div class="padding less-m-b">
        <div v-bind:class="[alert, alertClass, alertDismissible, noBr]" role="alert" v-if="target">
            <button type="button" class="close" @click="target = false" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{ initMsg }}</strong> {{ msg }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'ssalert',
    props: ['alertClass', 'target', 'initMsg', 'msg'],
    data() {
        return {
            alert: 'alert', alertDismissible: 'alert-dismissible', noBr: 'ss-no-b-r'
        }
    }
}
</script>
