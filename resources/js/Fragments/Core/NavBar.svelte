<script>
  import {Transition, Menu, MenuButton, MenuItems} from '@rgossiaux/svelte-headlessui';
  import ModalSignIn from "@/Fragments/Core/Modals/ModalSignIn.svelte";
  import ModalSignUp from "@/Fragments/Core/Modals/ModalSignUp.svelte";
  import {slideCommunity, modalSignIn, modalSignUp} from "@/Stores/store";
  import SlideCommunity from "@/Fragments/Core/Slides/SlideCommunity.svelte";
  import ModalCreateCommunity from "@/Fragments/Core/Modals/ModalCreateCommunity.svelte";
  import {page} from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { router } from "@/helpers";

  const menu = [
    // {
    //     name: 'Discover',
    //     url: '/discover'
    // },
  ];

  const profileMenu = [
    {
      name: 'Your Profile',
      url: '/profile'
    },
    {
      name: 'Settings',
      url: '/setting'
    },
    {
      name: 'Sign Out',
      method: () => Inertia.post(router("logout")),
    },
  ];

  let mobileMenu = false;
</script>

<nav class="bg-gray-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 justify-between">
      <div class="flex">
        {#if $page.props.auth.user !== null || menu.length >= 1}
          <div class="-ml-2 mr-2 flex items-center md:hidden">
            <!-- Mobile menu button -->
            <button type="button"
                    on:click={() => mobileMenu = !mobileMenu}
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <!--
                Icon when menu is closed.

                Heroicon name: outline/bars-3

                Menu open: "hidden", Menu closed: "block"
              -->
              <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
              </svg>
              <!--
                Icon when menu is open.

                Heroicon name: outline/x-mark

                Menu open: "block", Menu closed: "hidden"
              -->
              <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        {/if}
        <div class="flex flex-shrink-0 items-center">
          <svg
            class="w-8 h-8 text-indigo-500"
            viewBox="0 0 170 229"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M0.16932 0.778884L1.41032 200.848L51.7966 165.228L51.5343 122.86L169.29 228.054L168.068 30.9264L117.699 69.4885L117.944 108.914L0.16932 0.778884Z"
              fill="currentColor"
            />
          </svg>
        </div>
        <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          {#each menu as item, i}
            <a href={item.url}
               class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{item.name}</a>
          {/each}
        </div>
      </div>
      <div class="flex items-center">
        <div class="flex-shrink-0 flex gap-2">
          {#if $page.props.auth.user !== null}
            <button type="button"
                    on:click={() => slideCommunity.set(true)}
                    class="btn-md btn-primary primary-color">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                   class="-ml-1 mr-2 h-5 w-5">
                <path fill-rule="evenodd"
                      d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                      clip-rule="evenodd"/>
                <path
                  d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"/>
              </svg>

              <span>Community</span>
            </button>
          {:else}
            <button type="button"
                    on:click={() => modalSignIn.set(true)}
                    class="btn-primary btn-md primary-color">
              <span>Sign In</span>
            </button>
            <button type="button"
                    on:click={() => modalSignUp.set(true)}
                    class="btn-simple btn-md">
              <span>Sign Up</span>
            </button>
          {/if}
        </div>
        {#if $page.props.auth.user !== null}
          <div class="hidden md:ml-4 md:flex md:flex-shrink-0 md:items-center">
            <!-- Profile dropdown -->

            <Menu let:open as="div" class="relative ml-3">
              <MenuButton as="button"
                          class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                          id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full"
                     src={`https://ui-avatars.com/api/?name=${encodeURI($page.props.auth.user?.name)}&background=5046e5&color=fff`}
                     alt={$page.props.auth.user?.name}>
              </MenuButton>

              <Transition
                show={open}
                enter="transition ease-out duration-200"
                enterFrom="transform opacity-0 scale-95"
                enterTo="transform opacity-100 scale-100"
                leave="transition ease-in duration-75"
                leaveFrom="transform opacity-100 scale-100"
                leaveTo="transform opacity-0 scale-95"
              >
                <MenuItems
                  static
                  as="div"
                  class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                >
                  <!-- Active: "bg-gray-100", Not Active: "" -->
                  {#each profileMenu as item, i}
                    {#if item.method !== undefined}
                      <button type="button" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" on:click={() => item.method()}>
                        {item.name}
                      </button>
                    {:else}
                      <a href={item.url} class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        tabindex="-1">{item.name}
                      </a>
                    {/if}
                  {/each}
                </MenuItems>
              </Transition>
            </Menu>
          </div>
        {/if}
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  {#if mobileMenu}
    <div class="md:hidden" id="mobile-menu">
      {#if menu.length >= 1}
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
          {#each menu as item, i}
            <a href={item.url}
               class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">{item.name}</a>
          {/each}
        </div>
      {/if}
      {#if $page.props.auth.user !== null}
        <div class="border-t border-gray-700 pt-4 pb-3">
          <div class="flex items-center px-5 sm:px-6">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full"
                   src={`https://ui-avatars.com/api/?name=${encodeURI($page.props.auth.user?.name)}&background=5046e5&color=fff`}
                   alt={$page.props.auth.user?.name}>
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-white">{$page.props.auth.user?.name}</div>
              <div class="text-sm font-medium text-gray-400">@{$page.props.auth.user?.username}</div>
            </div>
          </div>
          <div class="mt-3 space-y-1 px-2 sm:px-3">
            {#each profileMenu as item, i}
              {#if item.method !== undefined}
                <button type="button" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white w-full text-left" on:click={() => item.method()}>
                  {item.name}
                </button>
              {:else}
                <a href={item.url} class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                  {item.name}
                </a>
              {/if}
            {/each}
          </div>
        </div>
      {/if}
    </div>
  {/if}
</nav>

<ModalSignIn/>
<ModalSignUp/>
<SlideCommunity/>
<ModalCreateCommunity/>
