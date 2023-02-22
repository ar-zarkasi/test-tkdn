<template>
    <div class="container mx-auto mt-[5%]">
        <div class="flex justify-center">
            <div class="w-2/3 border rounded bg-white">
                <div class="w-full p-3">
                    <div class="flex justify-between">
                        <h1 class="text-xl text-ellipsis text-black font-bold">{{ detailuser?.name }}</h1>
                        <div class="flex justify-between gap-5">
                            <nuxt-link class="btn btn-info btn-outline btn-sm" to="/">Kembali</nuxt-link>
                            <button type="button" class="btn btn-success btn-outline btn-sm" @click="gotoUpdate" :class="{loading: loadingState}">Edit</button>
                        </div>
                    </div>
                </div>
                <div class="w-full divider"></div>
                <div class="w-full p-3 space-y-3">
                    <div class="flex flex-nowrap gap-2">
                        <div class="w-8">
                            <img class="w-full" src="~/assets/images/ic-email.svg" />
                        </div>
                        <div class="align-middle items-center text-black text-lg">{{ detailuser?.email }}</div>
                    </div>
                    <div class="flex flex-nowrap gap-2">
                        <div class="w-8">
                            <img class="w-full" src="~/assets/images/ic-gender.svg" />
                        </div>
                        <div class="align-middle items-center text-black text-lg">{{ detailuser?.gender }}</div>
                    </div>
                    <div class="flex flex-nowrap gap-2">
                        <div class="w-8">
                            <img v-if="detailuser?.married === 'Married'" class="w-full" src="~/assets/images/ic-married.svg" />
                            <img v-else class="w-full" src="~/assets/images/ic-person.svg" />
                        </div>
                        <div class="align-middle items-center text-black text-lg">{{ detailuser?.married }}</div>
                    </div>
                    <div class="flex flex-nowrap gap-2">
                        <div class="w-8">
                            <img class="w-full" src="~/assets/images/ic-address.svg" />
                        </div>
                        <div class="align-middle items-center text-black text-lg">{{ detailuser?.address }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
const data = DataStore();
const route = useRoute();
const loadingState = ref(false);
const detailuser = computed(()=>{
    return data.getDetail
})
const gotoUpdate = () => {
    loadingState.value = true;
    navigateTo(`/update/${route.params.id}`);
}
definePageMeta({
    middleware: ['detailuser']
})
</script>