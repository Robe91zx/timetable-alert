<template>
    <button :type="type" class="m-px px-4 py-2 text-white font-semibold bg-blue-500 rounded">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
