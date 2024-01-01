<template>
  <section class="bg-white dark:bg-gray-900">
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Dashboard</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Log in</Link
        >

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
          >Register</Link
        >
      </template>
    </div>
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
      <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
        <h2
          class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white"
        >
          Our Blog
        </h2>
        <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">
          This our blog
        </p>
      </div>
      <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
        <input
          class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
          type="text"
          name="title"
          id="title"
          placeholder="Search Blog...."
          v-model="search"
        />
      </div>
      <div class="grid gap-8 lg:grid-cols-2">
        <article
          v-for="blog in blogs.data"
          :key="blog.id"
          class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700"
        >
          <div class="flex justify-between items-center mb-5 text-gray-500">
            <span class="text-sm">{{ formatDate(blog.published_date) }}</span>
          </div>
          <h2
            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
          >
            <Link :href="blog.view_route">
              {{ blog.title }}
            </Link>
          </h2>
          <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
            {{
              blog.content.length > 100
                ? blog.content.slice(0, 100) + "..."
                : blog.content
            }}
          </p>
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
              <span class="font-medium dark:text-white"> </span>
            </div>
            <Link :href="blog.view_route" 
            class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
              Read more
              <svg
                class="ml-2 w-4 h-4"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </Link>
          </div>
        </article>
      </div>
      <div class="mt-4">
        <Pagination :links="blogs.links" class="mt-6" />
      </div>
    </div>
  </section>
</template>
<script setup>
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
// need to install "npm install lodash"
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  blogs: Object,
  filters: Object,
});

let search = ref(usePage().props.filters.search);

watch(
  search,
  debounce((value) => {
    router.get("/", { search: value }, { preserveState: true, replace: true });
  }, 300)
);

const formatDate = (date) => {
  return dayjs(date).fromNow();
};
</script>