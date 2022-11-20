<script>
    import SlideOver from "../../Components/SlideOver.svelte";
    import {selectedLink, slideDetailLink} from "../../Stores/store";
</script>

<SlideOver bind:isOpen={$slideDetailLink}>
    <div slot="title" class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-ml-1 mr-2 h-8 w-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
        </svg>
        <span>Detail Link</span>
    </div>

    <div class="flex flex-col gap-2 text-gray-900 dark:text-white">
        <a href={$selectedLink.url} target="_blank"
           rel="noreferrer"
           class="font-medium text-indigo-600 truncate hover:underline hover:decoration-dashed underline-offset-4">{$selectedLink.url}</a>
        <div class="text-xs text-gray-500 dark:text-gray-400">
            Created By {$selectedLink.creator.name}
        </div>
        {#if $selectedLink.note !== null}
            <div class="text-sm text-gray-800 dark:text-gray-100 px-3 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 min-h-20 my-1">
                {$selectedLink.note}
            </div>
        {/if}
        <div>
            {#if $selectedLink.tags.length === 0}
                <p>No tag provided.</p>
            {:else}
                <div class="flex flex-wrap gap-1">
                    {#each $selectedLink.tags as tag, i}
                        <button type="button" class="px-2 py-0.5 text-xs rounded-full bg-indigo-500 bg-opacity-30 text-indigo-500 border border-transparent hover:border-indigo-500">
                            {tag.name}
                        </button>
                    {/each}
                </div>
            {/if}
        </div>
    </div>
</SlideOver>
