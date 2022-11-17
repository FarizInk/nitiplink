<script>
    import Modal from "../../Components/Modal.svelte"
    import {addNotif} from "../../Stores/notification";
    import {modalSignIn, modalSignUp, user, getUser} from "../../Stores/auth";
    import {useForm} from "@inertiajs/inertia-svelte";
    import {loading} from "../../Stores/main";

    let form = useForm({
        username: null,
        password: null,
        remember: false,
    })

    const login = () => {
        $form.post(route('login'), {
            onSuccess: () => {
                $form.reset();
                $form.errors = {};
                getUser(true);
            }
        })
    };

    modalSignIn.subscribe((newVal) => {
        if (newVal) {
            $form.errors = {}
            modalSignUp.set(false)
        }
    })
</script>


<Modal bind:isOpen={$modalSignIn} maxW="max-w-md">
    <div class="m-8">
        <div class="flex justify-between">
            <div class="text-center text-3xl font-extrabold text-1">Login</div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            {#if $form.errors.username}
                <div class="rounded-md bg-red-50 dark:bg-red-500 p-4 mb-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: mini/x-circle -->
                            <svg class="h-5 w-5 text-red-100" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-50">{$form.errors.username}</h3>
                        </div>
                    </div>
                </div>
            {/if}
            <form class="space-y-6" on:submit|preventDefault={login}>
                <div>
                    <label for="login-username" class="block text-md font-medium text-2">
                        Username or Email
                    </label>
                    <div class="mt-1">
                        <input
                            id="login-username"
                            type="text"
                            placeholder="Enter username or email here..."
                            class="input input-sm"
                            bind:value={$form.username}
                        />
                    </div>
                </div>

                <div>
                    <label for="login-password" class="block text-md font-medium text-2"> Password </label>
                    <div class="mt-1">
                        <input
                            id="login-password"
                            type="password"
                            class="input input-sm"
                            bind:value={$form.password}
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between gap-10">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="checkbox" bind:value={$form.remember} />
                        <label for="remember-me" class="ml-2 block text-sm text-2">Remember me</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button
                        type="button"
                        class="font-medium text-indigo-600 hover:text-indigo-500"
                        on:click={() => modalSignUp.set(true)}
                    >
                        Don't have account?
                    </button>

                    <button type="submit" class="btn-primary btn-md primary-color">Sign in</button>
                </div>
            </form>
        </div>
    </div>
</Modal>
