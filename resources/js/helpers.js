import {addNotif} from "./Stores/notification";
import {loading} from "./Stores/store";

export function showError(error) {
    if (error.response !== undefined) {
        const err = error.response.data
        for (let key in err.data) {
            addNotif({ title: 'Something Wrong!', description: err.data[key], status: 'warning' });
        }
    }
}

export function handleAxiosError(err) {
    console.log(err)
}

export function spellReq({ method = 'get', url, data = null, callbackRes, callbackErr }) {
    let a = {}
    a.method = method
    a.url = url
    if (data !== null) a.data = data
    loading.set(true);
    axios(a)
        .then((response) => (!callbackRes) ? console.log(response) : callbackRes(response))
        .catch((error) => (!callbackErr) ? handleAxiosError() : callbackErr(error) )
        .finally(() => loading.set(false));
}
