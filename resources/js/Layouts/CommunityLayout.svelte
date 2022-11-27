<script>
  import Profile from "@/Fragments/Core/Community/Profile.svelte";
  import ModalSettingCommunity from "@/Fragments/Core/ModalSettingCommunity.svelte";
  import ModalFormLink from "@/Fragments/Core/ModalFormLink.svelte";
  import SlideCommunity from "@/Fragments/Core/SlideCommunity.svelte";
  import ModalCreateCommunity from "@/Fragments/Core/ModalCreateCommunity.svelte";
  import ModalSignIn from "@/Fragments/Core/ModalSignIn.svelte";
  import ModalSignUp from "@/Fragments/Core/ModalSignUp.svelte";

  const menu = [
    // {
    //     name: 'User',
    //     url: '/user'
    // },
  ];

  export let title = null;
  export let buttonBack = false;
  console.log(title, buttonBack);
</script>

<div>
  <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
  <div class="relative z-40 md:hidden" role="dialog" aria-modal="true">
    <!--
      Off-canvas menu backdrop, show/hide based on off-canvas menu state.

      Entering: "transition-opacity ease-linear duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "transition-opacity ease-linear duration-300"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />

    <div class="fixed inset-0 z-40 flex">
      <!--
        Off-canvas menu, show/hide based on off-canvas menu state.

        Entering: "transition ease-in-out duration-300 transform"
          From: "-translate-x-full"
          To: "translate-x-0"
        Leaving: "transition ease-in-out duration-300 transform"
          From: "translate-x-0"
          To: "-translate-x-full"
      -->
      <div class="relative flex w-full max-w-xs flex-1 flex-col bg-gray-800">
        <!--
          Close button, show/hide based on off-canvas menu state.

          Entering: "ease-in-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="absolute top-0 right-0 -mr-12 pt-2">
          <button
            type="button"
            class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
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
        </div>
        <div class="flex-shrink-0">
          <Profile/>
        </div>
        <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
          <nav class="space-y-1 px-2">
            <!-- selected class: bg-gray-900 text-white group flex items-center px-2 py-2 text-base font-medium rounded-md -->
            {#each menu as item, i }
            <a
              href={item.url}
              class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-base font-medium rounded-md"
            >
              <!-- Heroicon name: outline/users -->
              <svg
                class="text-gray-400 group-hover:text-gray-300 mr-4 flex-shrink-0 h-6 w-6"
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
                  d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                />
              </svg>
              {item.name}
            </a>
            {/each}
          </nav>
        </div>
        <div class="flex flex-shrink-0 bg-gray-700 p-4">
          <a href="#" class="group block flex-shrink-0">
            <div class="flex items-center">
              <div>
                <img
                  class="inline-block h-10 w-10 rounded-full"
                  src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                />
              </div>
              <div class="ml-3">
                <p class="text-base font-medium text-white">Tom Cook</p>
                <p
                  class="text-sm font-medium text-gray-400 group-hover:text-gray-300"
                >
                  View profile
                </p>
              </div>
            </div>
          </a>
        </div>
      </div>

      <div class="w-14 flex-shrink-0">
        <!-- Force sidebar to shrink to fit close icon -->
      </div>
    </div>
  </div>

  <!-- Static sidebar for desktop -->
  <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex min-h-0 flex-1 flex-col bg-gray-800">
      <div class="flex-shrink-0">
        <Profile/>
      </div>
      <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
        <nav class="flex-1 space-y-1 px-2">
          <!-- selected class: bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md -->
          {#each menu as item, i }
            <a
            href={item.url}
            class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md"
          >
            <!-- Heroicon name: outline/users -->
            <svg
              class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6"
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
                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
              />
            </svg>
            {item.name}
          </a>
          {/each}
        </nav>
      </div>
      <div class="flex flex-shrink-0 bg-gray-700 p-4">
        <a href="#" class="group block w-full flex-shrink-0">
          <div class="flex items-center">
            <div>
              <img
                class="inline-block h-9 w-9 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt=""
              />
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-white">Tom Cook</p>
              <p
                class="text-xs font-medium text-gray-300 group-hover:text-gray-200"
              >
                View profile
              </p>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <div class="flex flex-1 flex-col md:pl-64">
    <div
      class="sticky top-0 z-10 bg-gray-100 pl-1 pt-1 sm:pl-3 sm:pt-3 md:hidden"
    >
      <button
        type="button"
        class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
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
      <div class="py-6">
        {#if title !== null}
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-3 flex gap-2 items-center">
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
        <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
          <!-- Replace with your content -->
          <slot />
          <!-- /End replace -->
        </div>
      </div>
    </main>
  </div>
</div>

<ModalFormLink/>
<ModalSettingCommunity/>
<ModalSignIn/>
<ModalSignUp/>
<SlideCommunity/>
<ModalCreateCommunity/>