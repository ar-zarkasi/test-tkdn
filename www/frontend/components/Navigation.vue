<template>
    <div class="navbar bg-violet-500">
        <div class="flex-1">
            <nuxt-link to="/" class="text-xl text-white truncate">Arfan Test CRUD</nuxt-link>
        </div>
        <div class="hidden md:flex flex-none">
            <button-menu :text="createMenuText" @bklik="gotoCreate()" />
        </div>
        <div class="flex-none md:hidden">
            <label class="btn btn-circle swap swap-rotate">
  
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox" v-model="hamburgerMenu" />
                
                <!-- hamburger icon -->
                <svg class="swap-off fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z"/></svg>
                
                <!-- close icon -->
                <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>
                
            </label>
        </div>
    </div>
    <div class="w-full bg-violet-400" :class="{ hidden: !hamburgerMenu }">
        <div class="container mx-auto p-4">
            <button type="button" class="btn btn-primary btn-block btn-outline rounded" @click="gotoCreate()">
                {{ createMenuText }}
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
const hamburgerMenu = ref<boolean>(false)
const createMenuText = 'Create New Customer';
const gotoCreate = () => {
    hamburgerMenu.value = false;
    navigateTo('/create');
}
</script>