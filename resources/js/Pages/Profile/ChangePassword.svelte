<script>
  import ProfileLayout from "@/Layouts/ProfileLayout.svelte";
  import {useForm} from "@inertiajs/inertia-svelte";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";

  let form = useForm({
    password: null,
    password_confirmation: null,
  })

  const submit = () => {

  }
</script>

<ProfileLayout>
  <form class="max-w-md space-y-6" on:submit|preventDefault={submit}>
    <div>
      <label for="password" class="block text-md font-medium text-2">
        New Password
      </label>
      <div class="mt-1">
        <input
          id="password"
          type="password"
          placeholder="Enter password here..."
          class="input input-sm"
          bind:value={$form.password}
          disabled={$form.processing}
        />
      </div>
    </div>
    <div>
      <label for="password_confirmation" class="block text-md font-medium text-2">
        Password Confirmation
      </label>
      <div class="mt-1">
        <input
          id="password_confirmation"
          type="password"
          placeholder="Enter password again here..."
          class="input input-sm"
          bind:value={$form.password_confirmation}
          disabled={$form.processing}
        />
      </div>
    </div>
    <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>
      {#if $form.processing}
        <LoadingIcon class="-ml-1 mr-2 h-4 w-4"/>
      {/if}
      <span>Save</span>
    </button>
  </form>
</ProfileLayout>
