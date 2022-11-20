<script>
    import SlideOver from "../../Components/SlideOver.svelte";
    import {slideCommunity, modalCreateCommunity} from "../../Stores/store";
    import {communities} from "../../Stores/store";
    import {InertiaLink, Link} from "@inertiajs/inertia-svelte"
    import {spellReq, router} from "../../helpers";

    slideCommunity.subscribe((newVal) => {
        if (newVal) {
            spellReq({
                url: router('community.get'),
                callbackRes: (response) => communities.set(response.data)
            })
        }
    })
</script>

<SlideOver bind:isOpen={$slideCommunity} contentContainer={true} fixedTitle={true} forceClose={!$modalCreateCommunity}>
    <div slot="title" class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
             class="-ml-1 mr-2 h-8 w-8">
            <path fill-rule="evenodd"
                  d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                  clip-rule="evenodd"/>
            <path
                d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"/>
        </svg>
        <span>Community</span>
    </div>

    <div slot="widget">
        <div class="mx-4 sm:mx-6 mb-3 flex items-center">
            <div class="flex-1 text-gray-500 dark:text-gray-400 text-sm">
                Have a good day! 🙂
            </div>
            <button type="button" class="btn-md btn-primary primary-color" on:click={() => modalCreateCommunity.set(true)}>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="-ml-1 mr-2 w-5 h-5">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z" clip-rule="evenodd" />
                </svg>
                <span>Create</span>
            </button>
        </div>
    </div>

    <div class="flex flex-col gap-0.5">
        {#if $communities.length === 0}
            <div class="text-center p-3 pt-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                     class="mx-auto h-12 w-12 text-gray-400">
                    <path fill-rule="evenodd"
                          d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                          clip-rule="evenodd"/>
                    <path
                        d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No community</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new community or follow your favourite community.</p>
            </div>
        {/if}
        {#each $communities as community, i}
            <InertiaLink href="/@{community.prefix}" on:click={() => slideCommunity.set(false)} class="flex p-4 group">
                <img class="h-10 w-10 rounded-full group-hover:border group-hover:border-indigo-500 group-hover:p-0.5"
                     src={`https://ui-avatars.com/api/?name=${encodeURI(community.name)}&background=5046e5&color=fff`}
                     alt="">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-800 group-hover:text-gray-900 dark:text-gray-200 dark:group-hover:text-gray-50">{community.name}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">@{community.prefix}</p>
                </div>
            </InertiaLink>
        {/each}
    </div>
</SlideOver>
