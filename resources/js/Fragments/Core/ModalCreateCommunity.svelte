<script>
  import Modal from "../../Components/Modal.svelte"
  import {addNotif} from "../../Stores/notification";
  import {loading, modalCreateCommunity} from "../../Stores/store";
  import {onMount} from "svelte"
  import LoadingIcon from "../../Components/Icons/LoadingIcon.svelte";
  import {router} from "../../helpers";

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
        modalCreateCommunity.set(false);
      }
    })
  };

  modalCreateCommunity.subscribe((newVal) => {
    if (newVal) {
      $form.errors = {}
    }
  })
</script>

<Modal bind:isOpen={$modalCreateCommunity} maxW="max-w-md" forceClose={!$form.processing}>
  <div class="m-8">
    <div class="flex justify-between">
      <div class="text-center text-3xl font-extrabold text-1">Create Community</div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <form class="space-y-6" on:submit|preventDefault={create}>
        <div>
          <label for="community-name" class="block text-md font-medium text-2"> Name </label>
          <div class="mt-1">
            <input
              id="community-name"
              type="text"
              placeholder="Enter community name here..."
              class="{$form.errors.name ? 'input-error' : ''} input input-sm"
              bind:value={$form.name}
              disabled={$form.processing}
            />
          </div>
          {#if $form.errors.name}
            <div class="form-error">{$form.errors.name}</div>
          {/if}
        </div>

        <div>
          <label for="community-prefix" class="block text-md font-medium text-2"> Prefix </label>
          <div class="mt-1 flex rounded-md shadow-sm">
            <span
              class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3 text-gray-500 dark:text-gray-400 sm:text-sm">{window.location.origin + '/@'}</span>
            <input type="text" id="community-prefix"
                   class="{$form.errors.prefix ? 'input-error' : ''} input input-sm rounded-tl-none rounded-bl-none"
                   placeholder="devsign" bind:value={$form.prefix} disabled={$form.processing}>
          </div>
          {#if $form.errors.prefix}
            <div class="form-error">{$form.errors.prefix}</div>
          {/if}
        </div>

        <div class="flex justify-end items-center gap-2">
          <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>
            {#if $form.processing || $loading}
              <LoadingIcon class="-ml-1 mr-2 h-4 w-4"/>
            {/if}
            <span>Create!</span>
          </button>
          <button type="button" class="btn-simple btn-md" disabled={$form.processing}
                  on:click={() => modalCreateCommunity.set(false)}>Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</Modal>
