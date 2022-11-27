<script>
  import {page} from "@inertiajs/inertia-svelte";
  import {modalFormLink, selectedLink} from "@/Stores/store";
  import {Inertia} from "@inertiajs/inertia";
  import {router} from "@/helpers";
  import CommunityLayout from "@/Layouts/CommunityLayout.svelte";

  const edit = () => {
    selectedLink.set($page.props.link)
    modalFormLink.set(true)
  }

  const destroy = () => {
    Inertia.delete(router('community.link.delete', {community:$page.props.community.hash, link: $page.props.link.hash}))
  }
</script>

<CommunityLayout title="Detail Link" buttonBack={true}>
  <div class="flex flex-col gap-2 text-gray-900 dark:text-white mt-4">
    <a href={$page.props.link.url} target="_blank"
       rel="noreferrer"
       class="font-medium text-indigo-600 truncate hover:underline hover:decoration-dashed underline-offset-4">{$page.props.link.url}</a>
    <div class="text-xs text-gray-500 dark:text-gray-400">
      Created By {$page.props.link.creator.name}
    </div>
    {#if $page.props.link.note !== null}
      <div
        class="text-sm text-gray-800 dark:text-gray-100 px-3 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 min-h-20 my-1">
        {$page.props.link.note}
      </div>
    {/if}
    <div>
      {#if $page.props.link.tags.length === 0}
        <p>No tag provided.</p>
      {:else}
        <div class="flex flex-wrap gap-1">
          {#each $page.props.link.tags as tag, i}
            <button type="button"
                    class="px-2 py-0.5 text-xs rounded-full bg-indigo-500 bg-opacity-30 text-indigo-500 border border-transparent hover:border-indigo-500">
              {tag.name}
            </button>
          {/each}
        </div>
      {/if}
    </div>
    {#if $page.props.user_community_role === 'owner' || $page.props.user_community_role === 'moderator' || $page.props.auth.user?.hash === $page.props.link.created_hash }
      <div class="flex gap-2 mt-2 justify-end">
        <button type="button" on:click={() => destroy() } class="btn-primary btn-md red-color">
          Delete
        </button>
        <button type="button" on:click={() => edit() } class="btn-primary btn-md primary-color">
          Edit
        </button>
      </div>
    {/if}
  </div>
</CommunityLayout>
