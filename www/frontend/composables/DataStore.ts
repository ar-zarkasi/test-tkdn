import { detailResource, notification } from "./CollectTypes";

export const DataStore = defineStore('data-store',() => {
    const detail = ref<detailResource>();
    const setDetail = (data: detailResource) => {
        detail.value = data;
    }
    const getDetail = computed(()=>{
        return detail.value
    })

    const notifdata = ref<notification[]>([]);
    const launchNotif = (data: notification) => {
        notifdata.value.push(data);
    }
    const removeNotif = (id: string | number) => {
        const index = notifdata.value.findIndex((el)=>el.id === id);
        if(index > -1){
            notifdata.value.splice(index,1);
        }
    }
    const getNotif = computed(()=>{
        return notifdata.value;
    })

    return {
        setDetail,
        getDetail,
        launchNotif,
        removeNotif,
        getNotif,
    }
})