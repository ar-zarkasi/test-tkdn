<template>
    <ModalSkeleton :id="id">
        <template #modal-content>
            <div class="modal-box">
                <div class="container mx-auto space-y-8">
                    <div class="w-full">{{ text }}</div>
                    <div class="w-full">
                        <div class="flex justify-end">
                            <div class="flex justify-between gap-2">
                                <button type="button" class="btn btn-info btn-outline" @click="emits('accept')">Yes</button>
                                <button type="button" class="btn btn-error btn-outline" @click="emits('cancel')">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ModalSkeleton>
</template>

<script setup lang="ts">
const props = defineProps({
    text: String,
    id: String
})
const emits = defineEmits(['cancel','accept'])
</script>