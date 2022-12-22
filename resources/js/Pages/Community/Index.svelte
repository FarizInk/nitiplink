<script>
  import {page, InertiaLink, useForm} from "@inertiajs/inertia-svelte"
  import {router, urlParser} from "@/helpers";
  import CommunityLayout from "@/Layouts/CommunityLayout.svelte";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";
  import route from "ziggy-js/src/js";
  import {onMount} from "svelte";
  import {Transition, Menu, MenuButton, MenuItems} from '@rgossiaux/svelte-headlessui';
  import InputTag from "@/Components/InputTag.svelte";

  let form = useForm({
    q: null,
  })

  onMount(() => {
    const params = urlParser();
    $form.q = params.q ?? null;
  })

  const search = () => {
    const url = decodeURIComponent(route('app.community.index', {
      prefix: `@${$page.props.community.prefix}`,
      q: $form.q ?? null,
    }));
    $form.get(url)
  }
</script>

<CommunityLayout>
  <div class="pb-4 sm:px-6 md:px-8 flex flex-col gap-2">
    <form on:submit|preventDefault={search} class="flex gap-3">
<!--      <Menu let:openFilter as="div">-->
<!--        <MenuButton as="button" class="btn-sm btn-simple" id="filter-tag-search" aria-expanded="false"-->
<!--                    aria-haspopup="true">-->
<!--          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">-->
<!--            <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0112 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 011.541 1.836v1.044a3 3 0 01-.879 2.121l-6.182 6.182a1.5 1.5 0 00-.439 1.061v2.927a3 3 0 01-1.658 2.684l-1.757.878A.75.75 0 019.75 21v-5.818a1.5 1.5 0 00-.44-1.06L3.13 7.938a3 3 0 01-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836z" clip-rule="evenodd" />-->
<!--          </svg>-->
<!--        </MenuButton>-->

<!--        <Transition-->
<!--          show={openFilter}-->
<!--          enter="transition ease-out duration-200"-->
<!--          enterFrom="transform opacity-0 scale-95"-->
<!--          enterTo="transform opacity-100 scale-100"-->
<!--          leave="transition ease-in duration-75"-->
<!--          leaveFrom="transform opacity-100 scale-100"-->
<!--          leaveTo="transform opacity-0 scale-95"-->
<!--          as="div"-->
<!--          class="absolute top-16 z-10 mt-2 w-48 origin-bottom-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"-->
<!--        >-->
<!--          <MenuItems-->
<!--            static-->
<!--            as="div"-->
<!--            role="menu" aria-orientation="vertical" aria-labelledby="filter-tag-search" tabindex="-1"-->
<!--          >-->

<!--          </MenuItems>-->
<!--        </Transition>-->
<!--      </Menu>-->

      <input type="text" placeholder="Search here..." class="input input-sm" bind:value={$form.q}
             disabled={$form.processing}/>
      <button type="submit" class="btn-primary btn-sm primary-color" disabled={$form.processing}>
        {#if $form.processing}
          <LoadingIcon class="-ml-1 mr-2 h-4 w-4"/>
        {:else}
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
            <path fill-rule="evenodd"
                  d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z"
                  clip-rule="evenodd"/>
          </svg>
        {/if}
      </button>
    </form>
<!--    <div class="w-full sm:flex sm:items-center">-->
<!--      <h3 class="text-sm font-medium text-gray-500 dark:text-gray-300">-->
<!--        Filters-->
<!--        <span class="sr-only">, active</span>-->
<!--      </h3>-->

<!--      <div aria-hidden="true" class="hidden h-5 w-px bg-gray-300 dark:bg-gray-700 sm:ml-4 sm:block"></div>-->

<!--      <div class="mt-2 sm:mt-0 sm:ml-4">-->
<!--        <div class="-m-1 flex flex-wrap items-center">-->

<!--        <span class="m-1 inline-flex items-center rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-900 dark:text-white">-->
<!--          <span>Objects</span>-->
<!--          <button type="button"-->
<!--                  class="ml-1 inline-flex h-4 w-4 flex-shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-500 dark:hover:text-white">-->
<!--            <span class="sr-only">Remove filter for Objects</span>-->
<!--            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">-->
<!--              <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7"></path>-->
<!--            </svg>-->
<!--          </button>-->
<!--        </span>-->

<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
  </div>
  <div class="px-0 sm:px-6 md:px-8">
    {#if $page.props.links.length === 0}
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="mx-auto h-12 w-12 text-gray-400">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
        </svg>

        <h3 class="mt-2 text-sm font-medium text-gray-900">No link</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by adding a new link.</p>
      </div>
    {:else}
      <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md w-full">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
          {#each $page.props.links as link, i}
            <li>
              <div class="block hover:bg-white dark:hover:bg-gray-800 w-full">
                <div class="px-4 py-4 flex items-center sm:px-6">
                  <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                    <div class="truncate">
                      <div class="flex items-center gap-2 text-sm group">
                        <a href={link.url} target="_blank" rel="noreferrer"
                           class="font-medium text-indigo-600 truncate hover:underline hover:decoration-dashed underline-offset-4">{link.url}</a>
                      </div>
                      <div class="mt-2 flex">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                          <img
                            class="inline-block h-6 w-6 rounded-full"
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
                    <!--                    <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">-->
                    <!--                      <div class="flex overflow-hidden -space-x-1">-->
                    <!--                        {#each Array(4) as _, i}-->
                    <!--                          <img-->
                    <!--                            class="inline-block h-6 w-6 rounded-full ring-2 ring-white"-->
                    <!--                            src={`https://ui-avatars.com/api/?name=${encodeURI('Fariz')}&background=5046e5&color=fff`}-->
                    <!--                            alt="Fariz"-->
                    <!--                          />-->
                    <!--                        {/each}-->
                    <!--                      </div>-->
                    <!--                    </div>-->
                  </div>
                  <InertiaLink
                    href={decodeURIComponent(router('app.community.link', {prefix: '@' + $page.props.community.prefix, link: link.hash}))}
                    class="ml-5 flex-shrink-0">
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
                  </InertiaLink>
                </div>
              </div>
            </li>
          {/each}
        </ul>
      </div>
    {/if}
  </div>
</CommunityLayout>
