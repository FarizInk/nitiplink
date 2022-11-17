import { writable } from 'svelte/store';
export const notifications = writable([]);

export const addNotif = ({ title = 'success', description = 'Success!', status = 'success', to = 5 }) => {
    notifications.update(val => {
        const id = (Math.random() + 1).toString(36).substring(7)
        timeOutNotif(id, to);

        return [...val, {
            id: id,
            title: title,
            description: description,
            status: status,
            show: true,
        }]
    })
}

export const removeNotif = (id) => {
    notifications.update((val) => {
        return val.map(function (item) {
            if (item.id === id) {
                item.show = false;
            }
            return item;
        });
    })

    setTimeout(() => {
        notifications.update((val) => val.filter(item => item.id !== id))
    }, 100)
}

const timeOutNotif = (id, time) => {
    setTimeout(() => {
        notifications.update((val) => {
            return val.map(function (item) {
                if (item.id === id) {
                    item.show = false;
                }
                return item;
            });
        })
    }, (time * 1000) - 100)

    setTimeout(() => {
        notifications.update((val) => val.filter(item => item.id !== id))
    }, time * 1000)
}
