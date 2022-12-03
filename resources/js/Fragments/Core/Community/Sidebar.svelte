<script>
  import { page } from "@inertiajs/inertia-svelte";
  import {
    modalSettingCommunity,
    modalSignIn,
    selectedLink,
    modalFormLink
  } from "@/Stores/store";
  import { Inertia } from "@inertiajs/inertia";
  import { router } from "@/helpers";
  import {Transition, Menu, MenuButton, MenuItems} from '@rgossiaux/svelte-headlessui';

  const follow = () => {
    if ($page.props.auth.user === null) {
      modalSignIn.set(true);
    } else {
      Inertia.post(
        router("community.follow", { community: $page.props.community.hash })
      );
    }
  };

  const unfollow = () => {
    Inertia.post(
      router("community.unfollow", { community: $page.props.community.hash })
    );
  };

  const menu = [
    // {
    //   name: "User",
    //   url: "/user",
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

  const createLink = () => {
    selectedLink.set(null);
    modalFormLink.set(true);
  }
</script>

<div class="flex-shrink-0">
  <div class="m-2 mb-2 pb-2 {menu.length >= 1 ? 'border-b border-gray-700' : null}">
    <div class="flex flex-col gap-3 m-2 mt-4">
      <img
        class="h-32 w-32 rounded-xl"
        src={`https://ui-avatars.com/api/?name=${encodeURI(
          $page.props.community?.name
        )}&background=5046e5&color=fff`}
        alt={$page.props.community?.name}
      />
      <div>
        <div class="text-2xl font-bold text-white">
          {$page.props.community?.name}
        </div>
        <div class="text-base text-gray-500 mt-1">
          {$page.props.community?.bio ?? "No bio provided."}
        </div>
      </div>
      <div class="flex flex-wrap gap-2">
        {#if $page.props.user_community_role === null}
          <button
            type="button"
            on:click={() => follow()}
            class="btn-xs btn-primary green-color"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-4 h-4 mr-1"
            >
              <path
                fill-rule="evenodd"
                d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                clip-rule="evenodd"
              />
            </svg>
            <span>Follow</span>
          </button>
        {:else}
          <button
            type="button"
            on:click={() => unfollow()}
            class="btn-xs btn-primary red-color flex-1"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-4 h-4 mr-1"
            >
              <path
                fill-rule="evenodd"
                d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z"
                clip-rule="evenodd"
              />
            </svg>
            <span>Unfollow</span>
          </button>
        {/if}
        {#if $page.props.user_community_role !== null && $page.props.user_community_role !== "follower"}
          <button
            type="button"
            on:click={() => createLink()}
            class="btn-xs btn-primary primary-color flex-1"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-4 h-4 mr-1"
            >
              <path
                fill-rule="evenodd"
                d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z"
                clip-rule="evenodd"
              />
            </svg>
            <span>Link</span>
          </button>
        {/if}
      </div>
    </div>
    {#if $page.props.user_community_role === "owner" || $page.props.user_community_role === "moderator"}
      <button
        type="button"
        on:click={() => modalSettingCommunity.set(true)}
        class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md w-full"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6"
        >
          <path
            fill-rule="evenodd"
            d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
            clip-rule="evenodd"
          />
        </svg>
        Settings
      </button>
    {/if}
  </div>
</div>
<div class="flex flex-1 flex-col overflow-y-auto pb-4">
  <nav class="flex-1 space-y-1 px-2">
    <!-- selected class: bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md -->
    {#each menu as item, i}
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
  {#if $page.props.auth.user !== null}
    <Menu let:open as="div" class="group block w-full flex-shrink-0">
      <MenuButton as="button" class="flex items-center" id="sidebar-menu-button" aria-expanded="false" aria-haspopup="true">
        <div>
          <img
            class="inline-block h-9 w-9 rounded-full"
            src={`https://ui-avatars.com/api/?name=${encodeURI(
              $page.props.auth.user?.name
            )}&background=5046e5&color=fff`}
            alt={$page.props.auth.user?.name}
          />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-white text-left">
            {$page.props.auth.user.name}
          </p>
          <p
            class="text-xs font-medium text-gray-300 group-hover:text-gray-200"
          >
            View profile
          </p>
        </div>
      </MenuButton>

      <Transition
        show={open}
        enter="transition ease-out duration-200"
        enterFrom="transform opacity-0 scale-95"
        enterTo="transform opacity-100 scale-100"
        leave="transition ease-in duration-75"
        leaveFrom="transform opacity-100 scale-100"
        leaveTo="transform opacity-0 scale-95"
        as="div"
        class="absolute right-0 bottom-14 z-10 mt-2 w-48 origin-bottom-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <MenuItems
          static
          as="div"
          role="menu" aria-orientation="vertical" aria-labelledby="sidebar-menu-button" tabindex="-1"
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
                tabindex="-1">
                {item.name}
              </a>
            {/if}
          {/each}
        </MenuItems>
      </Transition>
    </Menu>
  {:else}
    <button
      class="btn-sm btn-primary primary-color"
      on:click={() => modalSignIn.set(true)}
    >
      Sign In
    </button>
  {/if}
</div>
