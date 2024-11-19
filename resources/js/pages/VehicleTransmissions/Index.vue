<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Tipo de Transmissão</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleTransmission = true"
                >
                    Adicionar Transmissão
                </VButton>
            </div>
        </div>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
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
                <tr v-for="vehicleTransmission in props.vehicleTransmissions">
                    <td>{{ vehicleTransmission.id }}</td>
                    <td>{{ vehicleTransmission.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleTransmission(vehicleTransmission.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleTransmission(vehicleTransmission)"
                                icon="lucide:pencil"
                            />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </VCard>
    <!-- ------------------------------------------------------------------------------------------- MODAL NOVO -->
    <VModal
        is="form"
        :open="dialogNewVehicleTransmission"
        title="Nova Trasmissão"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleTransmission"
        @close="dialogNewVehicleTransmission = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Transmissão</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Transmissão"
                                    autocomplete="vehicleTransmission-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.name"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>

    <!-- ------------------------------------------------------------------------------------------- MODAL EDITAR -->
    <VModal
        is="form"
        :open="modelEditVehicleTransmission.show"
        title="Editar Transmissão"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditVehicleTransmission"
        @close="modelEditVehicleTransmission.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Transmissão</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Combustivel"
                                    autocomplete="vehicleTransmission-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.name"
                                >
                                    {{ formEdit.errors.name }}
                                </p>
                            </VControl>
                        </VField>
                    </div>
                </div>
            </div>
        </template>
        <template #action>
            <VButton type="submit" color="primary" raised> Salvar </VButton>
        </template>
    </VModal>
</template>

<script setup>
import sleep from "@/utils/sleep";
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";

const props = defineProps({
    vehicleTransmissions: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const modelVehicleTransmission = reactive({
    show: false,
    id: null,
});

const modelEditVehicleTransmission = reactive({
    show: false,
    id: null,
});

const dialogNewVehicleTransmission= ref(false);
const loading = ref(false);


const form = useForm({
    name: "",
});

const formEdit = useForm({
    name: "",
});

const saveVehicleTransmission = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleTransmissions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Transmissão adicionada com sucesso!");
            dialogNewVehicleTransmission.value = false;
            form.reset();
            router.reload({ only: ["vehicleTransmissions"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleTransmission= (id) => {
    loading.value = true;
    form.delete(route("vehicleTransmissions.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Transmissão removida com sucesso!");
            router.reload({ only: ["vehicleTransmissions"] });
            modelVehicleTransmission.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editVehicleTransmission = (vehicleTransmissions) => {
    modelEditVehicleTransmission.show = true;
    modelEditVehicleTransmission.id = vehicleTransmissions.id;
    formEdit.name = vehicleTransmissions.name;
};

const saveEditVehicleTransmission = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("vehicleTransmissions.update", modelEditVehicleTransmission.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Transmissão atualizada com sucesso!");
            modelEditVehicleTransmission.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleTransmissions"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};



</script>

