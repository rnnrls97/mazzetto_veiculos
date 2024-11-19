<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Cores</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleColor= true"
                >
                    Adicionar Cor de Veiculo
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
                <tr v-for="vehicleColor in props.vehicleColors">
                    <td>{{ vehicleColor.id }}</td>
                    <td>{{ vehicleColor.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteBusinessSectors(vehicleColor.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editBusinessSector(vehicleColor)"
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
        :open="dialogNewVehicleColor"
        title="Novo Setor Empresarial"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleColor"
        @close="dialogNewVehicleColor = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Cor do Veiculo</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Cor do Veiculo"
                                    autocomplete="vehicleColor-name"
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
        :open="modelEditVehicleColor.show"
        title="Editar Cor do Veiculo"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditionVehicleColor"
        @close="modelEditVehicleColor.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Cor do veiculo</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Cor do veiculo"
                                    autocomplete="vehicleColor-name"
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
import { router, useForm } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import { Notyf } from "notyf";

const props = defineProps({
    vehicleColors: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const modelBusinessSector = reactive({
    show: false,
    id: null,
});

const modelEditVehicleColor = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewVehicleColor = ref(false);
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

const saveVehicleColor = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleColors.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Cor adicionada com sucesso!");
            dialogNewVehicleColor.value = false;
            form.reset();
            router.reload({ only: ["vehicleColors"] });
        },
        onFinish: () => {},
    });
};

const deleteBusinessSectors = (id) => {
    loading.value = true;
    form.delete(route("vehicleColors.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Cor removida com sucesso!");
            router.reload({ only: ["vehicleColors"] });
            dialogNewVehicleColor.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const saveEditionVehicleColor = () => {
    formEdit.clearErrors();
    formEdit.put(route("vehicleColors.update", modelEditVehicleColor.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Cor editada com sucesso!");
            modelEditVehicleColor.show = false;
            router.reload({ only: ["vehicleColors"] });
        },
        onFinish: () => {},
    });
};

const editBusinessSector = (vehicleColor) => {
    modelEditVehicleColor.show = true;
    modelEditVehicleColor.id = vehicleColor.id;
    formEdit.name = vehicleColor.name;
};


</script>

