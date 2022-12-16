<script>
  import ProfileLayout from "@/Layouts/ProfileLayout.svelte";
  import DiscordIcon from "@/Components/Icons/DiscordIcon.svelte";
  import {page, useForm} from "@inertiajs/inertia-svelte";
  import {router} from "@/helpers";
  import {onMount} from "svelte";

  let discordData = null;
  const getData = () => discordData = $page.props.payload.find((data) => data.type === 'discord')
  onMount(() => getData())

  let form = useForm({
    type: null,
  })

  const generateToken = (type) => {
    $form.transform(() => ({
      type: type,
    })).post(router('profile.bind.token'), {
      onSuccess: () => {
        getData()
        $form.errors = {};
      }
    })
  }

  const unbind = (type) => {
    $form.transform(() => ({
      type: type,
    })).post(router('profile.bind.unbind'), {
      onSuccess: () => {
        getData()
        $form.errors = {};
      }
    })
  }
</script>

<ProfileLayout>
  <div class="flex flex-col text-black dark:text-white">
    <div class="w-full rounded-lg flex justify-between items-center">
      <div class="flex gap-4">
        <div>
          <DiscordIcon/>
        </div>
        {#if discordData && discordData.bind_credential !== null}
          <div class="text-black dark:text-white">
            Binded at {new Date(discordData.binded_at).toLocaleDateString("en-US", {
            day: "numeric",
            month: "long",
            year: "numeric"
          })}
          </div>
        {:else}
          <div class="text-gray-700 dark:text-gray-400">
            Not binded yet.
          </div>
        {/if}
      </div>
      <div class="flex gap-4">
        {#if discordData && discordData.bind_credential === null}
          <div class="flex gap-2 items-center">
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
              <path fill-rule="evenodd"
                    d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z"
                    clip-rule="evenodd"/>
            </svg>
          </span>
            <pre class="bg-gray-200 dark:bg-black px-2 rounded-lg">{discordData.token}</pre>
          </div>
        {/if}
        {#if discordData && discordData.bind_credential !== null }
          <button class="btn-md btn-primary red-color" on:click={() => unbind('discord')}>
            Unbind
          </button>
        {:else}
          <button class="btn-md btn-primary primary-color" on:click={() => generateToken('discord')}>
            Generate
          </button>
        {/if}
      </div>
    </div>

  </div>
</ProfileLayout>
