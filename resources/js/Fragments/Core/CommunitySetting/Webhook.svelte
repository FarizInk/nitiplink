<script>
import {spellReq} from "../../../helpers";
import {page, useForm} from "@inertiajs/inertia-svelte";
import LoadingIcon from "../../../Components/Icons/LoadingIcon.svelte";
import {modalSignIn} from "../../../Stores/store";
import {Inertia} from "@inertiajs/inertia";

let data = [];
const getData = () => {
    spellReq({
        url: route("community.webhook.get", {community_hash: $page.props.community.hash}),
        callbackRes: (response) => data = response.data
    })
}
getData()

let form = useForm({
    name: null,
    url: null,
})

const create = () => {
    $form.post(route('community.webhook.create', {community_hash: $page.props.community.hash}), {
        onSuccess: () => {
            $form.reset();
            $form.errors = {};
            getData()
        }
    })
}

const destroy = (hash) => {
    Inertia.delete(route('community.webhook.delete', {community_hash: $page.props.community.hash, hash: hash }), {
        onSuccess: () => getData()
    })
}
</script>

<div class="rounded-md bg-gray-100 dark:bg-gray-800 p-4">
    <div class="text-lg mb-3">
        Create Webhook
    </div>
    <form class="space-y-6" on:submit|preventDefault={create}>
        <div>
            <label for="webhook-name" class="block text-md font-medium text-2">
                Name
            </label>
            <div class="mt-1">
                <input
                    id="webhook-name"
                    type="text"
                    placeholder="Enter webhook name here..."
                    class="{$form.errors.name ? 'input-error' : ''} input input-sm"
                    bind:value={$form.name}
                    disabled={$form.processing}
                />
            </div>
            {#if $form.errors.name}
                <div class="form-error">{$form.errors.name}</div>
            {/if}
        </div>

        <div>
            <label for="webhook-url" class="block text-md font-medium text-2">
                Url
            </label>
            <div class="mt-1">
                <input
                    id="webhook-url"
                    type="text"
                    placeholder="Enter webhook url here..."
                    class="{$form.errors.url ? 'input-error' : ''} input input-sm"
                    bind:value={$form.url}
                    disabled={$form.processing}
                />
            </div>
            {#if $form.errors.url}
                <div class="form-error">{$form.errors.url}</div>
            {/if}
        </div>

        <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>
            {#if $form.processing}
                <LoadingIcon class="-ml-1 mr-2 h-4 w-4" />
            {/if}
            <span>Create</span>
        </button>
    </form>
</div>
<div class="flex flex-col gap-2 mt-4">
    {#each data as item, i}
        <div class="bg-gray-800 rounded-lg overflow-hidden flex justify-between items-center py-2 px-4 hover:bg-gray-700 rounded-lg">
            <div class="relative flex items-center space-x-3">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium">{item.name}</p>
                    <p class="truncate text-sm">{item.url}</p>
                </div>
            </div>
            <div>
                <button type="button" class="btn-primary btn-md red-color" on:click={() => destroy(item.hash)}>
                    Delete
                </button>
            </div>
        </div>
    {/each}
</div>
