import {writable} from "svelte/store";
import axios from "axios";
import {loading} from "./main";

export const modalSignUp = writable(false);
export const modalSignIn = writable(false);
export const user = writable(null);

export const getUser = (closeModalAuth = false) => {
    loading.set(true);
    axios.get('/api/private/user')
        .then((response) => user.set(response.data))
        .catch((error) => console.log(error))
        .finally(() => {
            loading.set(false)
            if (closeModalAuth) {
                modalSignIn.set(false)
                modalSignUp.set(false)
            }
        })
}
