<script>
  import CommunityLayout from "@/Layouts/CommunityLayout.svelte";
  import {router} from "@/helpers";
  import {page, InertiaLink} from "@inertiajs/inertia-svelte";

  const routeTo = (type) => decodeURIComponent(router('app.community.setting.' + type, {prefix: '@' + $page.props.community.prefix}))
  const lists = [
    {
      title: 'Overview',
      description: 'Basic setting community.',
      url: routeTo('overview'),
    },
    {
      title: 'Follower',
      description: 'Setting follower role or remove.',
      url: routeTo('follower'),
    },
    {
      title: 'Webhook',
      description: 'Webhooks settings.',
      url: routeTo('webhook'),
    },
  ]
</script>

<CommunityLayout title="Settings" buttonBack={true}>
  <div class="px-4 sm:px-6 md:px-8">
    <div class="overflow-hidden bg-white dark:bg-gray-800 shadow sm:rounded-md">
      <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
        {#each lists as list, i}
          <li>
            <InertiaLink href={list.url} class="block hover:bg-gray-50 dark:hover:bg-gray-700">
              <div class="flex items-center px-4 py-4 sm:px-6">
                <div class="flex min-w-0 flex-1 items-center">
                  <div class="min-w-0 flex-1 md:grid md:grid-cols-2 md:gap-4">
                    <div>
                      <p class="truncate text-sm font-medium text-indigo-600">{list.title}</p>
                      <p class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-300">
                        <span class="truncate">{list.description ?? ''}</span>
                      </p>
                    </div>
                  </div>
                </div>
                <div>
                  <!-- Heroicon name: mini/chevron-right -->
                  <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                       fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                          clip-rule="evenodd"/>
                  </svg>
                </div>
              </div>
            </InertiaLink>
          </li>
        {/each}
      </ul>
    </div>
  </div>
</CommunityLayout>
