<script>
  import ProfileLayout from "@/Layouts/ProfileLayout.svelte";
  import {useForm, page} from "@inertiajs/inertia-svelte";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";
  import {router} from "@/helpers";

  let form = useForm({
    email: $page.props.auth.user?.email,
  })

  const submit = () => {
    $form.post(router('profile.change-email.action'), {
      onSuccess: () => {
        $form.errors = {};
      }
    })
  }
</script>

<ProfileLayout>
  <form class="max-w-md space-y-6" on:submit|preventDefault={submit}>
    <div>
      <label for="email" class="block text-md font-medium text-2">
        Email
      </label>
      <div class="mt-1">
        <input
          id="email"
          type="email"
          placeholder="Enter email here..."
          class="input input-sm"
          bind:value={$form.email}
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
