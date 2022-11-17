
<script>
    import Modal from "../../Components/Modal.svelte"
    import {addNotif} from "../../Stores/notification";
    import {loading, modalCreateCommunity} from "../../Stores/main";
    import {onMount} from "svelte"

    import { useForm } from '@inertiajs/inertia-svelte'

    let form = useForm({
        name: null,
        email: null,
        username: null,
        password: null
    })

    const create = () => {
        loading.set(true);
        $form.post(route('community.create'), {
            onSuccess: () => {
                $form.reset();
                $form.errors = {};
                console.log('success create community')
            }
        })
    };

    modalCreateCommunity.subscribe((newVal) => {
        if (newVal) {
            $form.errors = {}
        }
    })
</script>

<Modal bind:isOpen={$modalCreateCommunity} maxW="max-w-md">
    <div class="m-8">
        <div class="flex justify-between">
            <div class="text-center text-3xl font-extrabold text-1">Create Community</div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <form class="space-y-6" on:submit|preventDefault={create}>
                <div>
                    <label for="community-name" class="block text-md font-medium text-2"> Name </label>
                    <div class="mt-1">
                        <input
                            id="community-name"
                            type="text"
                            placeholder="Enter community name here..."
                            class="{$form.errors.name ? 'input-error' : ''} input input-sm"
                            bind:value={$form.name}
                        />
                    </div>
                    {#if $form.errors.name}
                        <div class="form-error">{$form.errors.name}</div>
                    {/if}
                </div>

                <div>
                    <label for="community-prefix" class="block text-md font-medium text-2"> Prefix </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3 text-gray-500 dark:text-gray-400 sm:text-sm">{window.location.origin + '/@'}</span>
                        <input type="text" id="community-prefix" class="{$form.errors.name ? 'input-error' : ''} input input-sm rounded-tl-none rounded-bl-none" placeholder="devsign">
                    </div>
                </div>

                <div class="flex justify-end items-center gap-2">
                    <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>Create!</button>
                    <button type="button" class="btn-simple btn-md" disabled={$form.processing} on:click={() => modalCreateCommunity.set(false)}>Cancel</button>
                </div>
            </form>
        </div>
    </div>
</Modal>
