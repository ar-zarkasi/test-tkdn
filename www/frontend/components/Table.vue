<template>
    <div class="w-full overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr>
                    <th v-for="(th, idx) in header" :key="idx">{{ th }}</th> 
                </tr>
            </thead>
            <tbody>
                <slot name="row-table"></slot>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    header: {
        type: Array<String>,
    },
})
</script>