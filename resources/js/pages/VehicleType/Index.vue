<template>
    <VCard radius="large">
        <h2 class="title is-4">Lista de Tipos</h2>
        <VButton
            color="primary"
            icon="fas fa-plus"
            elevated
            @click="dialogNewVehicleType = true"
            class="mb-4"
        >
            Adicionar
        </VButton>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Categoria ID</th>
                    <th scope="col" class="is-end">
                        <div
                            class="dark-inverted is-flex is-justify-content-flex-end mr-5"
                        >
                            Acoes
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="vehicleTypes in props.vehicleType">
                    <td>{{ vehicleTypes.id }}</td>
                    <td>{{ vehicleTypes.name }}</td>
                    <td>{{getVehicleTypeName(vehicleTypes.category_id)}}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleType(vehicleTypes.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleType(vehicleTypes)"
                                icon="lucide:pencil"
                            />   
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>

    <VModal
        is="form"
        :open="dialogNewVehicleType"
        title="Cadastrar Tipo"
        actions="center"
        @submit.prevent="saveVehicleType"
        @close="dialogNewVehicleType = false"
    >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Tipo</label>
                    <div class="control">
                        <input
                            v-model="form.name"
                            type="text"
                            class="input"
                            placeholder="Nome Tipo"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.name"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>Categoria ID</label>
                    <VControl>
                        <Multiselect
                            v-model="form.category_id"
                            label="name"
                            value-prop="id"
                            :options="props.categories"
                            placeholder="Selecione a categoria"
                        />
                    </VControl>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>

    <VModal
        is="form"
        :open="modalEditVehicleType.show"
        title="Editar Tipo"
        actions="center"
        @submit.prevent="saveEditVehicleType"
        @close="modalEditVehicleType = false"
        >
        <template #content>
            <div class="modal-form">
                <div class="field">
                    <label>Nome Tipo</label>
                    <div class="control">
                        <input
                            v-model="formEdit.name"
                            type="text"
                            class="input"
                            placeholder="Nome Tipo"
                        />
                        <p
                            class="help has-text-danger"
                            v-if="form.errors?.name"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>
                </div>
                <div class="field">
                    <label>Categoria ID</label>
                    <VControl>
                        <Multiselect
                            v-model="formEdit.category_id"
                            label="name"
                            value-prop="id"
                            :options="props.categories"
                            placeholder="Selecione a categoria"
                        />
                    </VControl>
                </div>
            </div>
            </template>
            <template #action>
                <VButton type="submit" color="primary" raised> Salvar </VButton>
            </template>
        </VModal>
</template>

<script setup>
import VIcon from "@/components/base/VIcon.vue";
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";

const props = defineProps({
    vehicleType: Array,
    categories: Array,
});
const dialogNewVehicleType = ref(false);
const form = useForm({
    name: "",
    category_id: "",
});

const formEdit = useForm({
    name: "",
    category_id: "",
});

const categorias = props.categories.map((category) => ({
    id: category.id,
    label: category.name,
}));

const modalEditVehicleType = reactive({
    show: false,
    id: null,
});

const saveVehicleType = () => {
    form.clearErrors();
    form.post(route("vehicleType.store"), {
        preserveScroll: true,
        onSuccess: () => {
            dialogNewVehicleType.value = false;
            form.reset();
            router.reload({ only: ["vehicleType"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleType = (id) => {
    form.delete(route("vehicleType.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            router.reload({ only: ["vehicleType"] });
        },
    });
};

const saveEditVehicleType = () => {
    formEdit.clearErrors();

    formEdit.put(route("vehicleType.update", modalEditVehicleType.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalEditVehicleType.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleType"] });
        },
        onFinish: () => {},
    });
};

const editVehicleType = (vehicleType) => {
    modalEditVehicleType.show = true;
    modalEditVehicleType.id = vehicleType.id;
    formEdit.name = vehicleType.name;
    formEdit.category_id = vehicleType.category_id;
};

const getVehicleTypeName = (vehicleTypeId) => {
    const vehicleType = props.categories.find((vt) => vt.id === vehicleTypeId);
    return vehicleType ? vehicleType.name : "Desconhecido";
};
</script>
