<template lang="html">
    <div class="padding less-m-b">
        <div v-bind:class="['ss-fly-alert alert ss-no-b-r', alertClass]" role="alert" v-if="target">
            <!-- <button type="button" class="close" @click="" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            <strong>{{ initMsg }}</strong> {{ msg }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'ssalert',
    props: ['alertClass', 'target', 'initMsg', 'msg'],
}
</script>
