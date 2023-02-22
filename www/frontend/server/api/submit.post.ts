import {sendError, createError} from 'h3';
import { generateHeaderFetch } from '~~/composables';

export default defineEventHandler( async (event) => {
    const body = await readBody(event);
    const config = useRuntimeConfig();
    const submittedUrl = `${config.web}/api/costumers`;
    try {
        const response = await $fetch(submittedUrl, generateHeaderFetch('post',body));
        console.log(response);
        return response;
    } catch (error: any) {
        if(typeof error.data !== 'undefined') {
            if(error.data.status.code === 422){
                let errormessages = '';
                Object.keys(error.data.result).forEach(element => {
                    errormessages = error.data.result[element][0];
                });
                const err = createError({ statusText: errormessages, statusMessage: errormessages, message: errormessages, statusCode: error.data.status.code });
                return sendError(event, err, true);
            }
            
        }
        return sendError(event, error, true);
    }
});