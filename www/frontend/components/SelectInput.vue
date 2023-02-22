<template>
    <div class="form-control w-full">
        <label class="label">
            <span class="label-text">{{ label }}</span>
        </label>
        <select class="select select-bordered w-full" @change="updateValue">
            <option>{{ placeholder }}</option>
            <option v-for="(opsi, idx) in option" :key="idx" :value="opsi.value" :selected="opsi.value === modelValue">{{ opsi.text }}</option>
        </select>
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
    option: {
        type: Array<any>,
        default: () => []
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