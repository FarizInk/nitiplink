<script>
  import Modal from "@/Components/Modal.svelte"
  import {addNotif} from "@/Stores/notification";
  import {useForm, page} from "@inertiajs/inertia-svelte";
  import {loading, modalFormLink, selectedLink} from "@/Stores/store";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";
  import InputTag from "@/Components/InputTag.svelte";
  import {router} from "@/helpers";

  let form = useForm({
    url: null,
    note: null,
    tags: [],
  })
  let tagInputValue = null;

  const submit = () => {
    if ($selectedLink === null) {
      $form.post(router('community.link.create', {community: $page.props.community?.hash}), {
        onSuccess: () => {
          $form.reset();
          $form.errors = {};
          modalFormLink.set(false)
        }
      })
    } else {
      $form.put(router('community.link.update', {
        community: $page.props.community?.hash,
        link: $selectedLink.hash
      }), {
        onSuccess: () => {
          $form.reset();
          $form.errors = {};
          modalFormLink.set(false)
        }
      })
    }
  };

  const addTag = (value) => {
    form.update(data => {
      if (!data.tags.find((item) => item === value) && value !== null) {
        data.tags = [
          ...data.tags,
          value
        ]
      }
      return data;
    });
    tagInputValue = null;
  }

  const removeTag = (index) => {
    form.update(data => {
      data.tags.splice(index, 1);
      return data;
    });
  }

  selectedLink.subscribe((newVal) => {
    if (newVal !== null) {
      $form.url = newVal.url
      $form.note = newVal.note
      $form.tags = newVal.tags.map(tag => tag.name)
    } else {
      $form.reset();
    }
  })
</script>

<Modal bind:isOpen={$modalFormLink} maxW="max-w-md" forceClose={!$form.processing}>
  <div class="m-8">
    <div class="flex justify-between">
      <div
        class="text-center text-3xl font-extrabold text-1">{$selectedLink === null ? 'Create Link' : 'Edit Link'}</div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <form class="space-y-6" on:submit|preventDefault={submit}>
        <div>
          <label for="link-url" class="block text-md font-medium text-2">
            Link
          </label>
          <div class="mt-1">
            <input
              id="link-url"
              type="text"
              placeholder="Enter link here..."
              class="{$form.errors.url ? 'input-error' : ''} input input-sm"
              bind:value={$form.url}
              disabled={$form.processing}
            />
          </div>
          {#if $form.errors.url}
            <div class="form-error">{$form.errors.url}</div>
          {/if}
        </div>

        <div>
          <label for="link-note" class="block text-md font-medium text-2">Note</label>
          <div class="mt-1">
            <textarea rows="4" id="link-note" class="{$form.errors.note ? 'input-error' : ''} block input"
                      bind:value={$form.note}></textarea>
          </div>
          {#if $form.errors.note}
            <div class="form-error">{$form.errors.note}</div>
          {/if}
        </div>

        <div>
          <label for="link-note" class="block text-md font-medium text-2">Tags</label>
          <div class="mt-1">
            <InputTag bind:tags={$form.tags} bind:value={tagInputValue} bind:error={$form.errors.data}
                      removeData={(i) => removeTag(i)} addData={(val) => addTag(val)}/>
          </div>
          {#if $form.errors.data}
            <div class="form-error">{$form.errors.data}</div>
          {/if}
        </div>

        <div class="flex justify-end items-center gap-2">
          <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>
            {#if $form.processing || $loading}
              <LoadingIcon class="-ml-1 mr-2 h-4 w-4"/>
            {/if}
            <span>{$selectedLink === null ? 'Create!' : 'Update!'}</span>
          </button>
          <button type="button" class="btn-simple btn-md" disabled={$form.processing}
                  on:click={() => modalFormLink.set(false)}>Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</Modal>
