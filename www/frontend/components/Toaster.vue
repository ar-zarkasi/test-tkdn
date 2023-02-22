<template>
    <div class="toast toast-start">
        <div v-for="notif in toastdata" :key="notif.id" class="alert" :class="`alert-${notif.tipe}`">
            <div class="flex justify-between">
                <span>{{ notif.message }}</span>
                <button class="btn btn-circle btn-secondary btn-outline btn-sm" @click="removeNotif(notif.id)">
                    <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
const datastore = DataStore();

const toastdata = computed(()=>{
    return datastore.getNotif
})

const removeNotif = (id: string | number) => {
    datastore.removeNotif(id);
}
</script>