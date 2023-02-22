<template>
    <div class="container mx-auto">
        <div class="flex flex-wrap justify-center gap-4 mt-[5%]">
            <TextInput v-model="model.name" label="Nama" placeholder="Nama Lengkap" />
            <TextInput v-model="model.email" label="Email" placeholder="Alamat Email" />
            <SelectInput v-model="model.gender" :option="option_gender" label="Gender" placeholder="pilih jenis kelamin" />
            <SelectInput v-model="model.is_married" :option="option_married" label="is Married ?" placeholder="status pernikahan" />
            <div class="w-full p-2">
                <div class="flex justify-center">
                    <TextAreaInput v-model="model.address" placeholder="Alamat Lengkap" label="Alamat" />
                </div>
            </div>
            <PasswordInput v-model="model.password" label="Password" placeholder="Masukkan Kata Sandi" />
            <PasswordInput v-model="model.confirm_password" label="Confirm Password" placeholder="Konfirmasi Ulang Kata Sandi" />
        </div>
        <div class="w-full mt-[5%] mb-[5%]">
            <div class="flex justify-end">
                <ButtonLantern text="Create" @bklik="submit" :is-loading="loadingState" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
const config = useRuntimeConfig();
const datastore = DataStore()
const loadingState = ref(false);
const model = reactive({
    name: '',
    email: '',
    gender: undefined,
    is_married: '',
    password: '',
    confirm_password: '',
    address: undefined
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
    const urlpost = `/api/submit`;
    loadingState.value = true;
    try {
        const { data:submitResponse, error: errorSubmit } = await useFetch(urlpost,generateHeaderFetch('post',model));
        if(errorSubmit.value) throw errorSubmit.value
        const response :any = submitResponse.value
        datastore.launchNotif({
            id: 'success-response-created',
            tipe: 'success',
            message: response.status.message,
        })
        loadingState.value = false;
        navigateTo('/');
    } catch (error) {
        datastore.launchNotif({
            id: 'error-response-created',
            tipe: 'error',
            message: error as string
        })
        loadingState.value = false;
    }
    
}
useHead({
    title: 'Create Customer - Arfan CRUD Test TKDN'
})
</script>