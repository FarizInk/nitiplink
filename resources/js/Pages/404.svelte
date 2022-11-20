<script>
    import AppLayout from "../Layouts/AppLayout.svelte";
    import { Link } from '@inertiajs/inertia-svelte'
</script>

<AppLayout>
    <div class="min-h-full bg-white px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
        <div class="py-16">
            <div class="text-center">
                <p class="text-base font-semibold text-indigo-600">404</p>
                <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page not found.</h1>
                <p class="mt-2 text-base text-gray-500">Sorry, we couldn’t find the page you’re looking for.</p>
                <div class="mt-6">
                    <Link href="/" class="text-base font-medium text-indigo-600 hover:text-indigo-500">
                        Go back home
                        <span aria-hidden="true"> &rarr;</span>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</AppLayout>
