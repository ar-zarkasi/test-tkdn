import { methodhttp } from "./CollectTypes";

export const generateHeaderFetch = (method: methodhttp, body?: any): any => {
    return {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        method,
        body: body ? JSON.stringify(body) : null
    }
}

export const firedModal = (modalId: string, open: boolean) => {
    const inputModal = document.getElementById(modalId) as HTMLInputElement
    inputModal.checked = open;
}