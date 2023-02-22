<template>
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">{{ label }}</span>
        </label>
        <input type="password" :placeholder="placeholder" class="input input-bordered w-full" :value="modelValue" @input="updateValue"  />
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