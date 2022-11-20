<script>
    import NavBar from "../Fragments/Core/NavBar.svelte";
</script>

<div class="flex flex-col h-full">
    <NavBar/>
    <main class="mx-auto max-w-7xl w-full flex-1">
        <slot/>
    </main>
</div>
