<template>
    <label class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['value']
    })
</script>
