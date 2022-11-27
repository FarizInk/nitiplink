<script>
  import {Dialog, DialogOverlay, Transition, TransitionChild} from '@rgossiaux/svelte-headlessui';

  export let isOpen = false;
  export let maxW = 'max-w-full';
  export let positionY = 'center';
  export let positionX = 'center';
  export let forceClose = true;
</script>

<Transition appear show={isOpen}>
  <Dialog
    as="div"
    class="fixed inset-0 z-40 overflow-y-auto"
    on:close={forceClose ? () => (isOpen = false) : null}
  >
    <TransitionChild
      enter="ease-out duration-300"
      enterFrom="opacity-0"
      enterTo="opacity-100"
      leave="ease-in duration-200"
      leaveFrom="opacity-100"
      leaveTo="opacity-0"
    >
      <DialogOverlay
        class="fixed inset-0 bg-gray-500 dark:bg-gray-800 bg-opacity-75 dark:bg-opacity-75 transition-opacity"
      />
    </TransitionChild>

    <div class="flex items-{positionY} justify-{positionX} min-h-full p-4">
      <TransitionChild
        enter="ease-out duration-300"
        enterFrom="opacity-0 scale-95"
        enterTo="opacity-100 scale-100"
        leave="ease-in duration-200"
        leaveFrom="opacity-100 scale-100"
        leaveTo="opacity-0 scale-95"
        as="div"
        class="relative bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all my-8 w-full {maxW}"
      >
        <slot/>
      </TransitionChild>
    </div>
  </Dialog>
</Transition>
