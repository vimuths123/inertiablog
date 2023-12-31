<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Blog
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submit" class="mt-6 space-y-6">
              <div class="mb-6">
                <label for="title"> Title </label>
                <input
                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                  type="text"
                  name="title"
                  id="title"
                  v-model="form.title"
                />
                <div
                  v-if="form.errors.title"
                  v-text="form.errors.title"
                  class="text-red-500 text-xs mt-1"
                ></div>
              </div>

              <div class="mb-6">
                <label for="content"> Content </label>
                <textarea
                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                  v-model="form.content"
                ></textarea>
                <div
                  v-if="form.errors.content"
                  v-text="form.errors.content"
                  class="text-red-500 text-xs mt-1"
                ></div>
              </div>

              <div class="mb-6">
                <button
                  type="submit"
                  class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                  :disabled="form.processing"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  title: "",
  content: "",
});

let submit = () => {
  form.post("/blogs/store");
};
</script>