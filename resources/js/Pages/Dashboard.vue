<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    question: '',
});

defineProps({
    chats: {
        type: Array,
    },
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                     <div class="flex-1 overflow-y-auto px-4 py-6">
                                        <!-- Sender Message -->
                                        <div v-for="chat in chats" :key="chat.id">
                                            <div class="flex flex-row-reverse mb-4">
                                                <div class="max-w-xs rounded-lg bg-blue-500 text-white py-2 px-4">
                                                    <p>{{ chat.question }}</p>
                                                </div>
                                            </div>
                                            <!-- Receiver Message -->
                                            <div class="flex mb-4">
                                                <div class="max-w-xs rounded-lg bg-white text-gray-800 py-2 px-4">
                                                    <p>{{ chat.answer }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form @submit.prevent="form.post(route('openai.ask'))" class="mt-6 space-y-6">
                                        <TextInput
                                            id="question"
                                            name="question"
                                            type="text"
                                            v-model="form.question"
                                            required
                                            autofocus
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                            placeholder="Type your message..."
                                        />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
