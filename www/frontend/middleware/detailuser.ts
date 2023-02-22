import { detailResource, responseServer } from "~~/composables/CollectTypes";

export default defineNuxtRouteMiddleware(async (to, from) => {
    if(process.client) {
        const { setDetail } = DataStore()
        const uid = to.params.id;

        const detail: responseServer = await $fetch('/api/detail',{
            method: 'POST',
            body: JSON.stringify({id:uid})
        });
        setDetail(detail.result as detailResource);
    }
})