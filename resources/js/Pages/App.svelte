<script>
    import AppLayout from "../Layouts/AppLayout.svelte";
    import {page} from "@inertiajs/inertia-svelte"
    import SlideDetailLink from "../Fragments/Core/SlideDetailLink.svelte";
    import {selectedLink, slideDetailLink, modalFormLink, modalSignIn, modalSettingCommunity} from "../Stores/store";
    import ModalFormLink from "../Fragments/Core/ModalFormLink.svelte";
    import {Inertia} from "@inertiajs/inertia";
    import ModalSettingCommunity from "../Fragments/Core/ModalSettingCommunity.svelte";

    console.log($page.props)

    const openDetail = (link) => {
        selectedLink.set(link)
        slideDetailLink.set(true);
    }

    const follow = () => {
        if ($page.props.auth.user === null) {
            modalSignIn.set(true);
        } else {
            Inertia.post(route('community.follow', {community_hash: $page.props.community.hash}))
        }
    }

    const unfollow = () => {
        Inertia.post(route('community.unfollow', {community_hash: $page.props.community.hash}))
    }
</script>

<AppLayout>
    <div class="mx-auto max-w-5xl w-full">
        <div class="flex mt-10 gap-4">
            <div class="w-4/12 flex justify-center">
                <div class="flex flex-col gap-3">
                    <img class="h-32 w-32 rounded-xl"
                         src={`https://ui-avatars.com/api/?name=${encodeURI($page.props.community?.name)}&background=5046e5&color=fff`}
                         alt={$page.props.community?.name}>
                    <div>
                        <div class="text-3xl font-bold">
                            {$page.props.community?.name}
                        </div>
                        <div class="text-base text-gray-500 mt-1">
                            {$page.props.community?.bio ?? 'No bio provided.'}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        {#if $page.props.user_community_role !== null && $page.props.user_community_role !== 'follower'}
                            <button type="button" on:click={() => modalFormLink.set(true)}
                                    class="btn-sm btn-primary primary-color">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                     class="-ml-1 mr-2 w-4 h-4">
                                    <path fill-rule="evenodd"
                                          d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <span>Link</span>
                            </button>
                        {/if}
                        {#if $page.props.user_community_role === 'owner' || $page.props.user_community_role === 'moderator'}
                            <button type="button" on:click={() => modalSettingCommunity.set(true)}
                                    class="btn-sm btn-simple">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="-ml-1 mr-2 w-4 h-4">
                                    <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                                </svg>
                                <span>Settings</span>
                            </button>
                        {/if}
                    </div>
                    <div>
                        {#if $page.props.user_community_role === null}
                            <button type="button" on:click={() => follow()} class="btn-sm btn-primary primary-color">
                                <span>Follow</span>
                            </button>
                        {:else}
                            <button type="button" on:click={() => unfollow()} class="btn-sm btn-primary red-color">
                                <span>Unfollow</span>
                            </button>
                        {/if}
                    </div>
                </div>
            </div>

            <div class="flex-1">
                {#if $page.props.links.length === 0}
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>

                        <h3 class="mt-2 text-sm font-medium text-gray-900">No link</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by adding a new link.</p>
                    </div>
                {:else}
                <div class="bg-white shadow overflow-hidden sm:rounded-md w-full max-w-2xl">
                    <ul class="divide-y divide-gray-200">
                        {#each $page.props.links as link, i}
                            <li>
                                <div class="block hover:bg-gray-50 w-full">
                                    <div class="px-4 py-4 flex items-center sm:px-6">
                                        <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                            <div class="truncate">
                                                <div class="flex text-sm">
                                                    <a href={link.url} target="_blank"
                                                       rel="noreferrer"
                                                       class="font-medium text-indigo-600 truncate hover:underline hover:decoration-dashed underline-offset-4">{link.url}</a>
                                                </div>
                                                <div class="mt-2 flex">
                                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                                        <img
                                                            class="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                                                            src={`https://ui-avatars.com/api/?name=${encodeURI(link.creator.name)}&background=5046e5&color=fff`}
                                                            alt={link.creator.name}
                                                        />
                                                        {#if link.tags.length === 0}
                                                            <p>No tag provided.</p>
                                                        {:else}
                                                            <div class="flex flex-wrap gap-1">
                                                                {#each link.tags as tag, i}
                                                                    <button type="button" class="px-2 py-0.5 text-xs rounded-full bg-indigo-500 bg-opacity-30 text-indigo-500 border border-transparent hover:border-indigo-500">
                                                                        {tag.name}
                                                                    </button>
                                                                {/each}
                                                            </div>
                                                        {/if}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                <div class="flex overflow-hidden -space-x-1">
                                                    {#each Array(4) as _, i}
                                                        <img
                                                            class="inline-block h-6 w-6 rounded-full ring-2 ring-white"
                                                            src={`https://ui-avatars.com/api/?name=${encodeURI('Fariz')}&background=5046e5&color=fff`}
                                                            alt="Fariz"
                                                        />
                                                    {/each}
                                                </div>
                                            </div>
                                        </div>
                                        <button on:click={() => openDetail(link)} class="ml-5 flex-shrink-0">
                                            <!-- Heroicon name: solid/chevron-right -->
                                            <svg
                                                class="h-5 w-5 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        {/each}
                    </ul>
                </div>
                {/if}
            </div>
        </div>
    </div>
    <SlideDetailLink/>
    <ModalFormLink/>
    <ModalSettingCommunity />
</AppLayout>
