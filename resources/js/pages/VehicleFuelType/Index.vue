<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Tipo de Combistível</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleFuelType = true"
                >
                    Adicionar Combustível
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
                <tr v-for="vehicleFuelType in props.vehicleFuelType">
                    <td>{{ vehicleFuelType.id }}</td>
                    <td>{{ vehicleFuelType.name }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleFuelType(vehicleFuelType.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleFuelType(vehicleFuelType)"
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
        :open="dialogNewVehicleFuelType"
        title="Nova Categoria"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleFuelType"
        @close="dialogNewVehicleFuelType = false"
    >
        <template #content>
            <!--Fieldset-->
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Combustível</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.name"
                                    type="text"
                                    placeholder="Nome Combustivel"
                                    autocomplete="vehicleFuelType-name"
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
        :open="modelEditVehicleFuelType.show"
        title="Editar Combustível"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditVehicleFuelType"
        @close="modelEditVehicleFuelType.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Nome Combustível</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.name"
                                    type="text"
                                    placeholder="Nome Combustivel"
                                    autocomplete="vehicleFuelType-name"
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
    vehicleFuelType: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
// Estado do CSRF Token
// Configuração do servidor

const modelVehicleFuelType = reactive({
    show: false,
    id: null,
});

const modelEditVehicleFuelType = reactive({
    show: false,
    id: null,
});


const { y } = useWindowScroll();

const dialogNewVehicleFuelType= ref(false);
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

const saveVehicleFuelType = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleFuelType.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível adicionada com sucesso!");
            dialogNewVehicleFuelType.value = false;
            form.reset();
            router.reload({ only: ["vehicleFuelType"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleFuelType= (id) => {
    loading.value = true;
    form.delete(route("vehicleFuelType.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível removida com sucesso!");
            router.reload({ only: ["vehicleFuelType"] });
            modelVehicleFuelType.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editVehicleFuelType = (vehicleFuelType) => {
    modelEditVehicleFuelType.show = true;
    modelEditVehicleFuelType.id = vehicleFuelType.id;
    formEdit.name = vehicleFuelType.name;
};

const saveEditVehicleFuelType = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("vehicleFuelType.update", modelEditVehicleFuelType.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Combustível atualizada com sucesso!");
            modelEditVehicleFuelType.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleFuelType"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};



</script>

