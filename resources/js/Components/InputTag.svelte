<script>
    export let inputClass = null;
    export let error = false;
    export let tags = [];
    export let value = null;

    // must be functions
    export let removeData;
    export let addData;

    const submit = () => addData(value)
</script>

<form on:submit|preventDefault={submit}>
    <input type="text" class="{inputClass ?? 'input input-sm'} {error ? 'input-error' : ''}" bind:value={value}>
    <div class="flex flex-wrap gap-2 mt-2 text-sm">
        {#each tags as item, i}
            <div class="rounded-md px-2 py-1 bg-gray-100 dark:bg-gray-800 flex gap-2 justify-center items-center text-gray-700 dark:text-gray-200">
                <div>{item}</div>
                <button type="button" on:click={() => removeData(i)}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-1.72 6.97a.75.75 0 10-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 101.06 1.06L12 13.06l1.72 1.72a.75.75 0 101.06-1.06L13.06 12l1.72-1.72a.75.75 0 10-1.06-1.06L12 10.94l-1.72-1.72z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        {/each}
    </div>
</form>
