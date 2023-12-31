<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Blogs created by you
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-6">
              <Link :href="route('blog.create')" class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500">+ Create a Blog</Link>
            </div>

            <table class="min-w-full border border-gray-300">
              <thead>
                <tr>
                  <th class="py-2 px-4 border border-gray-300">Title</th>
                  <th class="py-2 px-4 border border-gray-300">Content</th>
                  <th class="py-2 px-4 border border-gray-300">Status</th>
                  <th class="py-2 px-4 border border-gray-300">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="blog in blogs.data" :key="blog.id">
                  <td class="py-2 px-4 border border-gray-300">
                    {{ blog.title }}
                  </td>
                  <td class="py-2 px-4 border border-gray-300">
                    {{
                      blog.content.length > 80
                        ? blog.content.slice(0, 80) + "..."
                        : blog.content
                    }}
                  </td>
                  <td class="py-2 px-4 border border-gray-300">
                    {{ getStatus(blog) }}
                  </td>
                  <td class="py-2 px-4 border border-gray-300">
                     <Link href="" class="text-blue-500 hover:underline mr-2">Edit</Link>
                  </td>
                </tr>
              </tbody>
            </table>

            <Pagination :links="blogs.links" class="mt-6" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const getStatus = (blog) => {
  return blog.published_date ? "Published" : "Not Published";
};

defineProps({
  blogs: Object,
});
</script>