<template>
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">{{ label }}</span>
        </label>
        <textarea :value="modelValue" @input="updateValue" :placeholder="placeholder" class="textarea textarea-bordered textarea-md w-full"></textarea>
        <label class="label" v-if="errorText">
            <span class="label-text-alt text-red-600">{{ errorText }}</span>
        </label>
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    modelValue: {
        type: String,
        default: () => ''
    },
    label: String,
    placeholder: String,
    errorText: {
        type: String,
        required: false
    }
})
const emit = defineEmits(['update:modelValue']);

const updateValue = (event: any) => {
    emit('update:modelValue', event.target.value)
}
</script>