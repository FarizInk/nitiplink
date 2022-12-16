<script>
  import AppLayout from "@/Layouts/AppLayout.svelte";
  import {router} from "@/helpers";
  import {InertiaLink} from "@inertiajs/inertia-svelte";
  import route from "ziggy-js/src/js";

  const menu = [
    {
      name: 'Basic',
      route: 'profile.basic'
    },
    {
      name: 'Change Email',
      route: 'profile.change-email'
    },
    {
      name: 'Change Password',
      route: 'profile.change-password'
    },
    {
      name: 'Bind Account',
      route: 'profile.bind'
    },
  ]
</script>

<AppLayout>
  <div class="bg-gray-100 dark:bg-gray-800 m-0 sm:m-4 rounded-none sm:rounded-lg">
    <div>
      <div class="sm:hidden mx-4 pt-4">
        <label for="tabs" class="sr-only">Select a tab</label>
        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
        <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
          {#each menu as item, i}
          <option selected={route().current() === item.route}>{item.name}</option>
          {/each}
        </select>
      </div>
      <div class="hidden sm:block">
        <nav class="flex rounded-lg shadow overflow-hidden">
          {#each menu as item, i}
          <InertiaLink href={router(item.route)} class="group relative min-w-0 flex-1 overflow-hidden bg-white dark:bg-gray-800 py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10 {route().current() !== item.route ? 'text-gray-500 dark:text-gray-200 hover:text-gray-700 hover:dark:text-white' : 'text-gray-900 dark:text-white border-b-2 border-indigo-500'}">
            <span>{item.name}</span>
          </InertiaLink>
          {/each}
        </nav>
      </div>
    </div>
    <div class="p-4">
      <slot />
    </div>
  </div>
</AppLayout>
