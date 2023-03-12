<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    departments: { type: Object }
});

const form = useForm({
    id: ''
});

const deleteDepartments = (id, name) => {

    const alerta = Swal.mixin({
        buttonsStyling: true
    });
    alerta.fire({
        title: 'Esta seguro de eliminar ' + name + ' ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Si¡, Eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('departments.destroy', id));
        }
    });
}

</script>

<template>
    <Head title="Departamentos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Departamentos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Link :href="route('departments.create')"
                        :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                    <i class="fa-solid fa-plus-circle"></i> Crear
                    </Link>
                    <div class="bg-white grid v-screen place-items-center">
                        <table class="table-auto border border-gray-400 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-4">#</th>
                                    <th class="px-4 py-4">Departamentos</th>
                                    <th class="px-4 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dep, i in departments" :key="dep.id">
                                    <td class="border border-gray-400 px-4 py-4">{{ (i + 1) }}</td>
                                    <td class="border border-gray-400 px-4 py-4">{{ dep.name }}</td>
                                    <td class="border border-gray-400 px-4 py-4">
                                        <Link :href="route('departments.edit', dep.id)"
                                            :class="'px-4 py-2 bg-sky-400 hover:bg-sky-500 text-gray border rounded-md font-semibold text-xs'">
                                        <i class="fa-solid fa-edit"></i>
                                        </Link>
                                        <DangerButton @click="$event => deleteDepartments(dep.id, dep.name)">
                                            <i class="fa-solid fa-trash"></i>
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>