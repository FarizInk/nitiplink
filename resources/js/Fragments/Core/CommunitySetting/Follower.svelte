<script>
    import {spellReq} from "../../../helpers";
    import {page} from "@inertiajs/inertia-svelte";
    import {Inertia} from "@inertiajs/inertia";
    import {router} from "../../../helpers";

    const roles = [
        {
            name: 'Owner',
            value: 'owner',
        },
        {
            name: 'Moderator',
            value: 'moderator',
        },
        {
            name: 'Contributor',
            value: 'contributor',
        },
        {
            name: 'Follower',
            value: 'follower',
        },
    ]
    let active = null;

    const update = (hash, role) => {
        console.log(hash, role)
        Inertia.post(router('community.follower.update', {community_hash: $page.props.community.hash}), {
            hash: hash,
            role: role
        })
    }

    const openPermissionSetting = (index) => {
        if (active === index) {
            active = null
        } else {
            active = index
        }
    }

    let data = [];
    const getData = () => {
        spellReq({
            url: router('community.follower.get', {community_hash: $page.props.community.hash}),
            callbackRes: (response) => data = response.data
        })
    }
    getData()
</script>

<div class="flex flex-col gap-2">
    {#each data as item, i}
        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <div class="relative flex items-center space-x-3 py-2 px-4 hover:bg-gray-700 rounded-lg hover:cursor-pointer" on:click={() => openPermissionSetting(i)}>
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src={`https://ui-avatars.com/api/?name=${encodeURI(item.name)}&background=5046e5&color=fff`} alt="{item.name}">
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium">{item.name}</p>
                    <p class="truncate text-sm">{item.pivot?.role}</p>
                </div>
            </div>
            {#if active === i}
                <div class="flex m-2 gap-2 justify-start items-center">
                    {#each roles as role, i}
                        <button type="button" class="btn-primary btn-md primary-color" on:click={() => update(item.hash, role.value)}>
                            {role.name}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>
    {/each}
</div>
