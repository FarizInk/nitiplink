<script>
  import {page} from "@inertiajs/inertia-svelte"
  import {selectedLink} from "@/Stores/store";
  import CommunityFragment from "@/Fragments/Core/CommunityFragment.svelte";
  import {Inertia} from "@inertiajs/inertia";
  import {router} from "@/helpers";
  import CommunityLayout from "@/Layouts/CommunityLayout.svelte";

  const openDetail = (link) => {
    Inertia.visit('/@' + $page.props.community.prefix + '/' + link.hash)
  }
</script>

<CommunityLayout>
  {#if $page.props.links.length === 0}
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
        </svg>

        <h3 class="mt-2 text-sm font-medium text-gray-900">No link</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by adding a new link.</p>
      </div>
    {:else}
      <div class="bg-white shadow overflow-hidden sm:rounded-md w-full">
        <ul class="divide-y divide-gray-200">
          {#each $page.props.links as link, i}
            <li>
              <div class="block hover:bg-gray-50 w-full">
                <div class="px-4 py-4 flex items-center sm:px-6">
                  <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                    <div class="truncate">
                      <div class="flex items-center gap-2 text-sm group">
                        <a href={link.url} target="_blank" rel="noreferrer" class="font-medium text-indigo-600 truncate hover:underline hover:decoration-dashed underline-offset-4">{link.url}</a>
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
                                <button type="button"
                                        class="px-2 py-0.5 text-xs rounded-full bg-indigo-500 bg-opacity-30 text-indigo-500 border border-transparent hover:border-indigo-500">
                                  {tag.name}
                                </button>
                              {/each}
                            </div>
                          {/if}
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                      <!--                                            <div class="flex overflow-hidden -space-x-1">-->
                      <!--                                                {#each Array(4) as _, i}-->
                      <!--                                                    <img-->
                      <!--                                                        class="inline-block h-6 w-6 rounded-full ring-2 ring-white"-->
                      <!--                                                        src={`https://ui-avatars.com/api/?name=${encodeURI('Fariz')}&background=5046e5&color=fff`}-->
                      <!--                                                        alt="Fariz"-->
                      <!--                                                    />-->
                      <!--                                                {/each}-->
                      <!--                                            </div>-->
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
</CommunityLayout>
