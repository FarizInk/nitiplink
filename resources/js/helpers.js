export function showError(error) {
    if (error.response !== undefined) {
        const err = error.response.data
        for (let key in err.data) {
            addNotif({ title: 'Something Wrong!', description: err.data[key], status: 'warning' });
        }
    }
}
