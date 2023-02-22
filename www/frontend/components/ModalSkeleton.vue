<template>
    <input type="checkbox" :id="id" class="modal-toggle" />
    <div class="modal">
        <slot name="modal-content"></slot>
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    id: {
        type: String,
        default: () => 'custom-modal'
    },
})
</script>