<script>
  import { page } from "@inertiajs/inertia-svelte";
  import {
    modalFormLink,
    modalSettingCommunity,
  } from "@/Stores/store";

  const follow = () => {
    if ($page.props.auth.user === null) {
      modalSignIn.set(true);
    } else {
      Inertia.post(router('community.follow', {community_hash: $page.props.community.hash}))
    }
  }

  const unfollow = () => {
    Inertia.post(router('community.unfollow', {community_hash: $page.props.community.hash}))
  }
</script>

<div class="flex flex-col gap-3 p-4">
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
    {#if $page.props.user_community_role !== null && $page.props.user_community_role !== "follower"}
      <button
        type="button"
        on:click={() => modalFormLink.set(true)}
        class="btn-sm btn-primary primary-color"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="-ml-1 mr-2 w-4 h-4"
        >
          <path
            fill-rule="evenodd"
            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z"
            clip-rule="evenodd"
          />
        </svg>
        <span>Link</span>
      </button>
    {/if}
    {#if $page.props.user_community_role === "owner" || $page.props.user_community_role === "moderator"}
      <button
        type="button"
        on:click={() => modalSettingCommunity.set(true)}
        class="btn-sm btn-simple"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="-ml-1 mr-2 w-4 h-4"
        >
          <path
            fill-rule="evenodd"
            d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"
            clip-rule="evenodd"
          />
        </svg>
        <span>Settings</span>
      </button>
    {/if}
  </div>
  <div>
    {#if $page.props.user_community_role === null}
      <button
        type="button"
        on:click={() => follow()}
        class="btn-sm btn-primary primary-color"
      >
        <span>Follow</span>
      </button>
    {:else}
      <button
        type="button"
        on:click={() => unfollow()}
        class="btn-sm btn-primary red-color"
      >
        <span>Unfollow</span>
      </button>
    {/if}
  </div>
</div>
