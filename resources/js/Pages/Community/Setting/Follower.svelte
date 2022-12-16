<script>
  import {page} from "@inertiajs/inertia-svelte";
  import {Inertia} from "@inertiajs/inertia";
  import {router} from "@/helpers";
  import CommunityLayout from "@/Layouts/CommunityLayout.svelte";

  const roles = [
    {
      name: 'Owner',
      value: 'owner',
    },
    {
      name: 'Moderator',
      value: 'moderator',
    },
    {
      name: 'Contributor',
      value: 'contributor',
    },
    {
      name: 'Follower',
      value: 'follower',
    },
  ]
  let active = null;

  const update = (hash, role) => {
    Inertia.post(router('community.follower.update', {community: $page.props.community.hash}), {
      hash: hash,
      role: role
    })
  }

  const openPermissionSetting = (index) => {
    if (active === index) {
      active = null
    } else {
      active = index
    }
  }
</script>

<CommunityLayout title="Follower Setting" buttonBack={true}>
  <div class="flex flex-col gap-2 px-4 sm:px-6 md:px-8">
    {#each $page.props.followers?.data as item, i}
      <div class="bg-gray-800 rounded-lg overflow-hidden text-black dark:text-white">
        <div class="relative flex items-center space-x-3 py-2 px-4 hover:bg-gray-700 rounded-lg hover:cursor-pointer"
             on:click={() => openPermissionSetting(i)}>
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full"
                 src={`https://ui-avatars.com/api/?name=${encodeURI(item.name)}&background=5046e5&color=fff`}
                 alt="{item.name}">
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-sm font-medium">{item.name}</p>
            <p class="truncate text-sm">{item.communities[0]?.pivot?.role}</p>
          </div>
        </div>
        {#if active === i}
          <div class="flex m-2 gap-2 justify-start items-center">
            {#each roles as role, i}
              <button type="button" class="btn-primary btn-md primary-color"
                      on:click={() => update(item.hash, role.value)}>
                {role.name}
              </button>
            {/each}
          </div>
        {/if}
      </div>
    {/each}
  </div>
</CommunityLayout>
