<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    department: { type: Object }
});
const form = useForm({
    name:props.department.name
});

</script>

<template>
    <Head title="Editar Departamento" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Departamento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <form @submit.prevent="$event => form.patch(route('departments.update',department ))" class="mt-6 spae-y-6 max-w-xl">
                        <InputLabel for="name" value="Departamento:"></InputLabel>

                        <input id="name" v-model="form.name" autofocus required type="text" class="mt-2 block w-full">
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