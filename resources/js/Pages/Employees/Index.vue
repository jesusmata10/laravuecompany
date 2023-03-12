<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import SecundaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination';

const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id = ref('');

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object }
});

const form = useForm({
    name: '', email: '', phone: '', department_id: ''
});

const formPage = useForm({});
const onPageClick = (event) => {
    formPage.get(route('employees.index', { page: event }));
}

const openModal = (op, name, email, phone, department, employee) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    if (op == 1) {
        title.value = 'Crear Empleado';
    } else {
        title.value = 'Editar Empleado';
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.department_id = department;
    }

}

const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {
    if (operation.value == 1) {
        form.post(route('employees.store'), {
            onSuccess: () => { ok('Empleado Creado Sastifatoriamente') }
        });
    } else {
        form.put(route('employees.update', id.value), {
            onSuccess: () => { ok('Empleado Actualizado Sastifatoriamente') }
        });
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: 'success' });
}

const deleteEmployee = (id, name) => {

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
            form.delete(route('employees.destroy', id));
            onSuccess: () => { ok('Empleado Eliminado') }
        }
    });
}

</script>

<template>
    <Head title="Empleados" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Empleados</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="bg-white grid v-screen place-items-center overflow-x-auto">
                        <PrimaryButton @click="$event => openModal(1)" class="my-2">
                            <i class="fa-solid fa-plus-circle"> Nuevo Empleado</i>
                        </PrimaryButton>
                        <table class="table-auto border border-gray-400 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-2">#</th>
                                    <th class="px-2 py-2">Empleados</th>
                                    <th class="px-2 py-2">Email</th>
                                    <th class="px-2 py-2">Telefono</th>
                                    <th class="px-2 py-2">Departamento</th>
                                    <th class="px-2 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="emp, i in employees.data" :key="emp.id">
                                    <td class="border border-gray-400 px-2 py-2">{{ (i + 1) }}</td>
                                    <td class="border border-gray-400 px-2 py-2">{{ emp.name }}</td>
                                    <td class="border border-gray-400 px-2 py-2">{{ emp.email }}</td>
                                    <td class="border border-gray-400 px-2 py-2">{{ emp.phone }}</td>
                                    <td class="border border-gray-400 px-2 py-2">{{ emp.department }}</td>
                                    <td class="border border-gray-400 px-2 py-2">
                                        <WarningButton
                                            @click="$event => openModal(2, emp.name, emp.email, emp.phone, emp.departmet_id, emp.id)">
                                            <i class="fa-solid fa-edit"></i>
                                        </WarningButton>
                                        <DangerButton @click="$event => deleteEmployee(emp.id, emp.name)">
                                            <i class="fa-solid fa-trash"></i>
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-white grid v-screen place-items-center overflow-x-auto ">
                        <VueTailwindPagination :current="employees.currentPage" :total="employees.total"
                            :per-page="employees.perPage" @page-changed="$event => onPageClick($event)">
                        </VueTailwindPagination>
                    </div>
                </div>
                <Modal :show="modal" @close="closeModal">
                    <h2 class="p-3 texl-lg font.mediun text-hray-900">
                        {{ title }}
                    </h2>
                    <div class="p-3 ">
                        <InputLabel for="name" value="Nombres:"></InputLabel>
                        <TextInput id="name" ref="nameInput" v-model="form.name" type="text" class="mt-1 block w-3/4"
                            placeholder="Nombres"></TextInput>
                        <InputError :message="form.errors.name" class="mt-2"></InputError>
                    </div>
                    <div class="p-3 ">
                        <InputLabel for="email" value="Email:"></InputLabel>
                        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-3/4"
                            placeholder="Email"></TextInput>
                        <InputError :message="form.errors.email" class="mt-2"></InputError>
                    </div>
                    <div class="p-3 ">
                        <InputLabel for="phone" value="Telefono:"></InputLabel>
                        <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-3/4"
                            placeholder="Telefono"></TextInput>
                        <InputError :message="form.errors.phone" class="mt-2"></InputError>
                    </div>
                    <div class="p-3">
                        <InputLabel for="department_id" value="Departamento:"></InputLabel>
                        <SelectInput id="department_id" :options="departments" v-model="form.department_id" type="text"
                            class="mt-1 block w-3/4" placeholder="Telefono"></SelectInput>
                        <InputError :message="form.errors.department_id" class="mt-2"></InputError>
                    </div>
                    <div>
                        <PrimaryButton class="p-3 mt-2" :disabled="form.processing" @click="save">
                            <i class="fa-solid fa-save"> Guardar</i>
                        </PrimaryButton>
                    </div>

                </Modal>
            </div>

        </div>
    </AuthenticatedLayout>
</template>