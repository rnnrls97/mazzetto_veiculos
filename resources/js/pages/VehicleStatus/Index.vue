<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Status do Veiculo </h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleStatus = true"
                >
                    Adicionar Status
                </VButton>
            </div>
        </div>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Descrição</th>
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
                <tr v-for="vehicleStatus in props.vehicleStatus">
                    <td>{{ vehicleStatus.id }}</td>
                    <td>{{ vehicleStatus.description }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleStatus(vehicleStatus.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleStatus(vehicleStatus)"
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
        :open="dialogNewVehicleStatus"
        title="Novo Status"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleStatus"
        @close="dialogNewVehicleStatus = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Status</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.description"
                                    type="text"
                                    placeholder="Nome Status"
                                    autocomplete="vehicleStatus-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.description"
                                >
                                    {{ form.errors.description }}
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
        :open="modelEditVehicleStatus.show"
        title="Editar Status"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditVehicleStatus"
        @close="modelEditVehicleStatus.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Status</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.description"
                                    type="text"
                                    placeholder="Nome Status"
                                    autocomplete="vehicleStatus-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.description"
                                >
                                    {{ formEdit.errors.description }}
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
    vehicleStatus: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const modelVehicleStatus = reactive({
    show: false,
    id: null,
});

const modelEditVehicleStatus = reactive({
    show: false,
    id: null,
});

const dialogNewVehicleStatus= ref(false);
const loading = ref(false);

const form = useForm({
    description: "",
});

const formEdit = useForm({
    description: "",
});

const saveVehicleStatus = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleStatus.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível adicionada com sucesso!");
            dialogNewVehicleStatus.value = false;
            form.reset();
            router.reload({ only: ["vehicleStatus"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleStatus= (id) => {
    loading.value = true;
    form.delete(route("vehicleStatus.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível removida com sucesso!");
            router.reload({ only: ["vehicleStatus"] });
            modelVehicleStatus.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editVehicleStatus = (vehicleStatus) => {
    modelEditVehicleStatus.show = true;
    modelEditVehicleStatus.id = vehicleStatus.id;
    formEdit.description = vehicleStatus.description;
};

const saveEditVehicleStatus = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("vehicleStatus.update", modelEditVehicleStatus.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível atualizada com sucesso!");
            modelEditVehicleStatus.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleStatus"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};



</script>

