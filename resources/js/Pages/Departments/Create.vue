<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: ''
});

</script>

<template>
    <Head title="Crear Departamento" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Departamento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <form @submit.prevent="$event => form.post(route('departments.store'))" class="mt-6 spae-y-6 max-w-xl">
                        <InputLabel for="name" value="Departamento:"></InputLabel>
                        <TextInput id="name" v-model="form.name" autofocus required type="text" class="mt-2 block w-full"></TextInput>
                        <InputError :message="form.errors.name" class="mt-4"></InputError>
                        <PrimaryButton class="mt-2" :disabled="form.processing">
                            <i class="fa-solid fa-save"> Guardar</i>
                        </PrimaryButton>
                        <Link :href="route('departments.index')"
                            :class="'px-4 py-2 bg-sky-400 hover:bg-sky-500 text-gray border rounded-md font-semibold text-xs'">
                        <i class="fa-solid fa-times-circle"> Cancelar</i>
                        </Link>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>