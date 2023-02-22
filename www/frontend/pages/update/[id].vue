<script setup lang="ts">
const data = DataStore();
const loadingState = ref(false);
const route = useRoute();
const model = reactive({
    id: route.params.id,
    name: data.getDetail?.name,
    email: data.getDetail?.email,
    gender: data.getDetail?.gender === 'Man' ? 'L' : 'P',
    is_married: data.getDetail?.married === 'Married' ? '1' : '0',
    address: data.getDetail?.address
})
const option_gender = [
    { text: 'Man', value: 'L' },
    { text: 'Woman', value: 'P' },
];
const option_married = [
    { text: 'Single', value: '0' },
    { text: 'Married', value: '1' },
];
const submit = async () => {
    if(loadingState.value) {
        console.log('Still Progress, Please wait..')
        return;
    }
    const urlpost = `/api/update`;
    loadingState.value = true;
    try {
        const { data:submitResponse, error: errorSubmit } = await useFetch(urlpost,generateHeaderFetch('post',model));
        if(errorSubmit.value) throw errorSubmit.value
        const response :any = submitResponse.value
        data.launchNotif({
            id: 'success-response-created',
            tipe: 'success',
            message: response.status.message,
        })
        navigateTo('/');
    } catch (error) {
        data.launchNotif({
            id: 'error-response-created',
            tipe: 'error',
            message: error as string
        })
        loadingState.value = false;
    }
    
}
definePageMeta({
    middleware: ['detailuser']
})
</script>

<template>
<div class="container mx-auto">
    <div class="flex flex-wrap justify-center gap-4 mt-[5%]">
        <TextInput v-model="model.name" label="Nama" placeholder="Nama Lengkap" />
        <TextInput v-model="model.email" label="Email" placeholder="Alamat Email" />
        <SelectInput v-model="model.gender" :option="option_gender" label="Gender" placeholder="pilih jenis kelamin" />
        <SelectInput v-model="model.is_married" :option="option_married" label="is Married ?" placeholder="status pernikahan" />
        <div class="w-full p-2">
            <div class="flex justify-center">
                <TextAreaInput v-model="(model.address as string)" placeholder="Alamat Lengkap" label="Alamat" />
            </div>
        </div>
    </div>
    <div class="w-full mt-[5%] mb-[5%]">
        <div class="flex justify-end">
            <ButtonLantern text="Update" @bklik="submit" :is-loading="loadingState" />
        </div>
    </div>
</div>
</template>