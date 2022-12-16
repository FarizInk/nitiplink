<script>
  import ProfileLayout from "@/Layouts/ProfileLayout.svelte";
  import {page, useForm} from "@inertiajs/inertia-svelte";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";
  import {router} from "@/helpers";

  let form = useForm({
    username: $page.props.auth.user?.username,
    name: $page.props.auth.user?.name,
  })

  const submit = () => {
    $form.post(router('profile.basic.action'), {
      onSuccess: () => {
        $form.errors = {};
      }
    })
  }
</script>

<ProfileLayout>
  <form class="max-w-md space-y-6" on:submit|preventDefault={submit}>
    <img class="h-40 w-40 rounded-full"
         src={`https://ui-avatars.com/api/?name=${encodeURI($page.props.auth.user?.name)}&background=5046e5&color=fff`}
         alt={$page.props.auth.user?.name}>
    <div>
      <label for="username" class="block text-md font-medium text-2">
        Username
      </label>
      <div class="mt-1">
        <input
          id="username"
          type="text"
          placeholder="Enter username here..."
          class="input input-sm"
          bind:value={$form.username}
          disabled={$form.processing}
        />
      </div>
    </div>
    <div>
      <label for="name" class="block text-md font-medium text-2">
        Name
      </label>
      <div class="mt-1">
        <input
          id="name"
          type="text"
          placeholder="Enter name here..."
          class="input input-sm"
          bind:value={$form.name}
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
