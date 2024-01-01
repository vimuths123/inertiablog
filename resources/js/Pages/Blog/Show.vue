<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        View Blog - {{ blog.title }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div class="mb-6">
              <label for="title"> Title </label>
              <div class="border-solid border-2 border-blue-600 p-4 rounded-md">{{ blog.title }}</div>
              
            </div>

            <div class="mb-6">
              <label for="content"> Content </label>
              <div class="border-solid border-2 border-blue-600 p-4 rounded-md">{{ blog.content }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import debounce from "lodash/debounce";

const getStatus = (blog) => {
  return blog.published_date ? "Published" : "Not Published";
};

defineProps({
  blog: Object,
});
</script>