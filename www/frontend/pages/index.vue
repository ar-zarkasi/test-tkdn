<template>
    <div class="mt-[5%]">
        <div class="container mx-auto">
            <div v-if="show" class="flex flex-nowrap w-full">
                <Table :header="tableHeader">
                    <template v-if="database !== null && database.length > 0" #row-table>
                        <tr v-for="(row, idx) in database" :key="idx">
                            <td>{{ row.name }}</td>
                            <td>{{ row.email }}</td>
                            <td>{{ row.gender }}</td>
                            <td>{{ row.married }}</td>
                            <td>{{ row.created_at }}</td>
                            <td>{{ row.updated_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-info btn-outline btn-sm" @click="gotoEdit(row.id)">View</button>
                                    <button class="btn btn-success btn-outline btn-sm" @click="gotoUpdate(row.id)">Edit</button>
                                    <button class="btn btn-error btn-outline btn-sm" @click="confirmationDelete(row.id)">Delete</button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-if="database !== null && database.length <= 0" #row-table>
                        <tr>
                            <td colspan="7" class="text-center">No Data Available</td>
                        </tr>
                    </template>
                </Table>
            </div>
            <div v-else class="w-full flex justify-center items-center">
                <Loader />
            </div>
        </div>
    </div>
    <PagesModalConfirmation 
        :id="modalConfirmationId" 
        :text="textDeleted" \
        @accept="deleteData" @cancel="cancelDelete" 
    />
</template>

<script setup lang="ts">
import { detailResource } from '~~/composables/CollectTypes';

const url = ref('/api/data')
const modalConfirmationId = 'modal-confirm-delete';
const idSelected = ref<string>('');
const database = ref<Array<detailResource> | null>(null);
const tableHeader = [
    'Name',
    'Email',
    'Gender',
    "Married ?",
    'created',
    'updated',
    ''
];
const textDeleted = ref('Are You Sure Want to Delete ?')
const gotoEdit = (id: string) => {
    database.value = null // reset
    navigateTo(`/detail/${id}`);
}
const gotoUpdate = (id: string) => {
    database.value = null // reset
    navigateTo(`/update/${id}`);
}
const show = computed(()=>{
    return database.value !== null
})
const deleteData = async () => {
    firedModal(modalConfirmationId, false);
    const urldelete = `/api/remove`
    database.value = null
    const deleting = await fetch(urldelete,generateHeaderFetch('post',{id: idSelected.value }));
    if(deleting.ok) {
        idSelected.value = '';
        await syncronize();
    }
}
const cancelDelete = () => {
    idSelected.value = '';
    firedModal(modalConfirmationId, false);
}
const confirmationDelete = (id: string) => {
    idSelected.value = id;
    firedModal(modalConfirmationId, true);
}
const syncronize = async () => {
    database.value = null;
    const response = await fetch(url.value,generateHeaderFetch('get'));
    database.value = (await response.json()).result
}
onMounted(async()=>{
    await syncronize();
})
</script>