<script>
  import Modal from "@/Components/Modal.svelte"
  import {loading, modalSettingCommunity, modalSettingCommunityActiveTab} from "@/Stores/store";
  import Overview from "@/Fragments/Core/Community/Overview.svelte";
  import Follower from "@/Fragments/Core/Community/Follower.svelte";
  import Webhook from "@/Fragments/Core/Community/Webhook.svelte";
  import {router} from "@/helpers";
  import {useForm} from '@inertiajs/inertia-svelte'

  let form = useForm({
    name: null,
    prefix: null,
  })

  const create = () => {
    loading.set(true);
    $form.post(router('community.create'), {
      onSuccess: () => {
        $form.reset();
        $form.errors = {};
      }
    })
  };

  const menu = [
    {
      name: 'Overview',
      prefix: 'overview'
    },
    {
      name: 'Follower',
      prefix: 'follower'
    },
    {
      name: 'Webhook',
      prefix: 'webhook'
    },
  ];
</script>

<Modal bind:isOpen={$modalSettingCommunity} maxW="max-w-4xl" forceClose={!$form.processing} positionY="start">
  <div class="p-2">
    <div class="sm:hidden">
      <label for="tabs" class="sr-only">Menu</label>
      <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
      <select id="tabs" bind:value={$modalSettingCommunityActiveTab}
              class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
        {#each menu as item, i}
          <option value={item.prefix}>{item.name}</option>
        {/each}
      </select>
    </div>
    <div class="hidden sm:block">
      <nav class="flex space-x-4" aria-label="Tabs">
        {#each menu as item, i}
          <button
            class="px-3 py-2 text-sm rounded-md font-medium {$modalSettingCommunityActiveTab === item.prefix ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700'}"
            on:click={() => modalSettingCommunityActiveTab.set(item.prefix)}>{item.name}</button>
        {/each}
      </nav>
    </div>
  </div>
  <div class="p-2 text-gray-900 dark:text-white">
    {#if $modalSettingCommunityActiveTab === 'overview'}
      <Overview/>
    {:else if $modalSettingCommunityActiveTab === 'follower'}
      <Follower/>
    {:else if $modalSettingCommunityActiveTab === 'webhook'}
      <Webhook/>
    {/if}
  </div>
</Modal>
