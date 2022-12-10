<script>
  import Modal from "@/Components/Modal.svelte"
  import {loading, modalSignIn, modalSignUp} from "@/Stores/store";
  import LoadingIcon from "@/Components/Icons/LoadingIcon.svelte";
  import {router} from "@/helpers";
  import {useForm} from '@inertiajs/inertia-svelte'

  let form = useForm({
    name: null,
    email: null,
    username: null,
    password: null
  })

  const register = () => {
    $form.post(router('register'), {
      onSuccess: () => {
        $form.reset();
        $form.errors = {};
        modalSignUp.set(false)
      }
    })
  };

  modalSignUp.subscribe((newVal) => {
    if (newVal) {
      $form.errors = {}
      modalSignIn.set(false)
    }
  })
</script>

<Modal bind:isOpen={$modalSignUp} maxW="max-w-md" forceClose={!$form.processing}>
  <div class="m-8">
    <div class="flex justify-between">
      <div class="text-center text-3xl font-extrabold text-1">Register</div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <form class="space-y-6" on:submit|preventDefault={register}>
        <div>
          <label for="register-name" class="block text-md font-medium text-2"> Name </label>
          <div class="mt-1">
            <input
              id="register-name"
              type="text"
              placeholder="Enter name here..."
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
          <label for="register-email" class="block text-md font-medium text-2">
            Email address
          </label>
          <div class="mt-1">
            <input
              id="register-email"
              type="email"
              placeholder="Enter email here..."
              class="{$form.errors.email ? 'input-error' : ''} input input-sm"
              bind:value={$form.email}
              disabled={$form.processing}
            />
          </div>
          {#if $form.errors.email}
            <div class="form-error">{$form.errors.email}</div>
          {/if}
        </div>

        <div>
          <label for="register-username" class="block text-md font-medium text-2"> Username </label>
          <div class="mt-1">
            <input
              id="register-username"
              type="text"
              placeholder="Enter username here..."
              class="{$form.errors.username ? 'input-error' : ''} input input-sm"
              bind:value={$form.username}
              disabled={$form.processing}
            />
          </div>
          {#if $form.errors.username}
            <div class="form-error">{$form.errors.username}</div>
          {/if}
        </div>

        <div>
          <label for="register-password" class="block text-md font-medium text-2"> Password </label>
          <div class="mt-1">
            <input
              id="register-password"
              type="password"
              class="{$form.errors.password ? 'input-error' : ''} input input-sm"
              bind:value={$form.password}
              disabled={$form.processing}
            />
          </div>
          {#if $form.errors.password}
            <div class="form-error">{$form.errors.password}</div>
          {/if}
        </div>

        <div class="flex justify-between items-center">
          <button
            type="button"
            class="font-medium text-indigo-600 hover:text-indigo-500"
            on:click={() => $form.processing ? null : modalSignIn.set(true)}
          >
            Have account?
          </button>

          <button type="submit" class="btn-primary btn-md primary-color" disabled={$form.processing}>
            {#if $form.processing || $loading}
              <LoadingIcon class="-ml-1 mr-2 h-4 w-4"/>
            {/if}
            <span>Sign Up</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</Modal>
