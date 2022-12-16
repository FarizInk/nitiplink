<script>
  import Sidebar from "@/Fragments/Core/Community/Sidebar.svelte";
  import ModalFormLink from "@/Fragments/Core/Modals/ModalFormLink.svelte";
  import SlideCommunity from "@/Fragments/Core/Slides/SlideCommunity.svelte";
  import ModalCreateCommunity from "@/Fragments/Core/Modals/ModalCreateCommunity.svelte";
  import ModalSignIn from "@/Fragments/Core/Modals/ModalSignIn.svelte";
  import ModalSignUp from "@/Fragments/Core/Modals/ModalSignUp.svelte";
  import {Transition, TransitionChild} from '@rgossiaux/svelte-headlessui';
  import {sidebarMobile} from "@/Stores/store";

  export let title = null;
  export let buttonBack = false;
  export let maxW = 'max-w-4xl'
</script>

<div>
  <Transition appear show={$sidebarMobile} class="relative z-40 md:hidden">
    <TransitionChild
      enter="transition-opacity ease-linear duration-300"
      enterFrom="opacity-0"
      enterTo="opacity-100"
      leave="transition-opacity ease-linear duration-300"
      leaveFrom="opacity-100"
      leaveTo="opacity-0"
      class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75"
    >
    </TransitionChild>

    <div class="fixed inset-0 z-40 flex">
      <TransitionChild
        enter="transition ease-in-out duration-300 transform"
        enterFrom="-translate-x-full"
        enterTo="translate-x-0"
        leave="transition ease-in-out duration-300 transform"
        leaveFrom="translate-x-0"
        leaveTo="-translate-x-full"
        class="relative flex w-full max-w-xs flex-1 flex-col bg-gray-800"
      >
        <TransitionChild
          enter="ease-in-out duration-300"
          enterFrom="opacity-0"
          enterTo="opacity-100"
          leave="ease-in-out duration-300"
          leaveFrom="opacity-100"
          leaveTo="opacity-0"
          class="absolute top-0 right-0 -mr-12 pt-2"
        >
          <button
            on:click={() => sidebarMobile.set(false)}
            type="button"
            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:ousticky top-0 z-10 sm:pl-3 sm:pt-3 md:hiddentline-none focus:ring-2 focus:ring-inset focus:ring-white"
          >
            <span class="sr-only">Close sidebar</span>
            <!-- Heroicon name: outline/x-mark -->
            <svg
              class="h-6 w-6 text-white"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              aria-hidden="true"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </TransitionChild>
        <Sidebar/>
      </TransitionChild>

      <div class="w-14 flex-shrink-0">
        <!-- Force sidebar to shrink to fit close icon -->
      </div>
    </div>
  </Transition>

  <!-- Static sidebar for desktop -->
  <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex min-h-0 flex-1 flex-col bg-gray-800">
      <Sidebar/>
    </div>
  </div>
  <div class="flex flex-1 flex-col md:pl-64">
    <div
      class="sticky top-0 z-10 bg-gray-100 dark:bg-gray-900 shadow-lg py-1 px-1 sm:py-3 sm:px-3 md:hidden"
    >
      <button
        on:click={() => sidebarMobile.set(true)}
        type="button"
        class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
      >
        <span class="sr-only">Open sidebar</span>
        <!-- Heroicon name: outline/bars-3 -->
        <svg
          class="h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          aria-hidden="true"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
          />
        </svg>
      </button>
    </div>
    <main class="flex-1 bg-white dark:bg-gray-900 min-h-screen">
      <div class="py-2 md:py-6">
        {#if title !== null}
        <div class="mx-auto {maxW} px-4 sm:px-6 lg:px-8 mb-5 flex gap-3 items-center">
          {#if history.length >= 1 && buttonBack}
            <button class="rounded-full p-2 btn-md btn-primary primary-color" on:click={() => history.back()}>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd"
                      d="M20.25 12a.75.75 0 01-.75.75H6.31l5.47 5.47a.75.75 0 11-1.06 1.06l-6.75-6.75a.75.75 0 010-1.06l6.75-6.75a.75.75 0 111.06 1.06l-5.47 5.47H19.5a.75.75 0 01.75.75z"
                      clip-rule="evenodd"/>
              </svg>
            </button>
          {/if}
          <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{title}</h1>
        </div>
        {/if}
        <div class="mx-auto {maxW}">
          <!-- Replace with your content -->
          <slot />
          <!-- /End replace -->
        </div>
      </div>
    </main>
  </div>
</div>

<ModalFormLink/>
<ModalSignIn/>
<ModalSignUp/>
<SlideCommunity/>
<ModalCreateCommunity/>
