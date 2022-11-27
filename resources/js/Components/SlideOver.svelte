<script>
  import {Dialog, DialogOverlay, Transition, TransitionChild} from '@rgossiaux/svelte-headlessui';

  export let isOpen = false;
  export let forceClose = true;
  export let contentContainer = false;
  export let fixedTitle = false;
</script>

<Transition appear show={isOpen}>
  <Dialog
    as="div"
    class="relative z-10"
    on:close={forceClose ? () => (isOpen = false) : null}
  >
    <TransitionChild
      enter="ease-in-out duration-500"
      enterFrom="opacity-0"
      enterTo="opacity-100"
      leave="ease-in-out duration-500"
      leaveFrom="opacity-100"
      leaveTo="opacity-0"
    >
      <DialogOverlay
        class="fixed inset-0 bg-gray-500 dark:bg-gray-800 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
      />
    </TransitionChild>

    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
      <TransitionChild
        enter="transform transition ease-in-out duration-500 sm:duration-700"
        enterFrom="translate-x-full"
        enterTo="translate-x-0"
        leave="transform transition ease-in-out duration-500 sm:duration-700"
        leaveFrom="translate-x-0"
        leaveTo="translate-x-full"
        as="div"
        class="pointer-events-auto w-screen max-w-md"
      >
        <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-900 shadow-xl">
          <div class="px-4 sm:px-6 my-6">
            <div class="flex items-start justify-between">
              <slot name="title">
                <div class="text-lg font-medium text-gray-900 dark:text-white">Panel Title</div>
              </slot>
              <div class="ml-3 flex h-7 items-center">
                <button type="button"
                        class="rounded-md bg-white dark:bg-gray-900 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        on:click={() => isOpen = false}>
                  <span class="sr-only">Close panel</span>
                  <!-- Heroicon name: outline/x-mark -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                       viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                       aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <slot name="widget"/>
          <div
            class="relative flex-1 {contentContainer ? 'mx-4 sm:mx-6 mb-6 bg-gray-100 dark:bg-gray-800 rounded-xl' : 'px-4 sm:px-6'} {fixedTitle ? 'overflow-scroll' : ''}">
            <!-- Replace with your content -->
            <slot/>
            <!-- /End replace -->
          </div>
        </div>
      </TransitionChild>
    </div>
  </Dialog>
</Transition>
