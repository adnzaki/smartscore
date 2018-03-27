<template lang="html">
    <li class="list-item">
        <div class="list-body">
            <small class="text-muted text-ellipsis">{{ name }}</small>
            <div><a href>{{ value }}</a></div>
        </div>
    </li>
</template>

<script>
export default {
    name: 'DataSekolah',
    props: ['name', 'value'],
}
</script>
