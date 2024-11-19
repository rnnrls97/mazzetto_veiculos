<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Consições do Veiculo</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleConditions = true"
                >
                    Adicionar Condição Veiculo
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
                <tr v-for="vehicleConditions in props.vehicleConditions">
                    <td>{{ vehicleConditions.id }}</td>
                    <td>{{ vehicleConditions.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleConditions(vehicleConditions.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleConditions(vehicleConditions)"
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
        :open="dialogNewVehicleConditions"
        title="Nova Condição Veiculo"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleConditions"
        @close="dialogNewVehicleConditions = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Condição</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Condição"
                                    autocomplete="vehicleConditions-name"
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
        :open="modelEditVehicleConditions.show"
        title="Editar Condição"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditVehicleConditions"
        @close="modelEditVehicleConditions.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Condição</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Condição"
                                    autocomplete="vehicleConditions-name"
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
    vehicleConditions: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
// Estado do CSRF Token
// Configuração do servidor

const modelVehicleConditions = reactive({
    show: false,
    id: null,
});

const modelEditVehicleConditions = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewVehicleConditions= ref(false);
const loading = ref(false);

// Estado do CSRF Token
const csrfToken = ref('');

// Configuração do servidor

const form = useForm({
    name: "",
});

const formEdit = useForm({
    name: "",
});

const saveVehicleConditions = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleConditions.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Condição adicionada com sucesso!");
            dialogNewVehicleConditions.value = false;
            form.reset();
            router.reload({ only: ["vehicleConditions"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleConditions= (id) => {
    loading.value = true;
    form.delete(route("vehicleConditions.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Condição removida com sucesso!");
            router.reload({ only: ["vehicleConditions"] });
            modelVehicleConditions.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editVehicleConditions = (vehicleFuelType) => {
    modelEditVehicleConditions.show = true;
    modelEditVehicleConditions.id = vehicleFuelType.id;
    formEdit.name = vehicleFuelType.name;
};

const saveEditVehicleConditions = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("vehicleConditions.update", modelEditVehicleConditions.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Condição atualizada com sucesso!");
            modelEditVehicleConditions.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleConditions"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};



</script>

