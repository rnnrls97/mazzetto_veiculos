<template>
    <VCard radius="large">
        <div class="columns is-multiline">
            <h2 class="title is-4 ">Lista de Qauntidade de Portas</h2>
            <div
                class="column is-12"
                style="display: flex; justify-content: flex-start"
            >
                <VButton
                    color="primary"
                    icon="fas fa-check"
                    elevated
                    @click="dialogNewVehicleDoor = true"
                >
                    Adicionar Quantidade de Portas
                </VButton>
            </div>
        </div>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Quantidade</th>
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
                <tr v-for="vehicleDoors in props.vehicleDoors">
                    <td>{{ vehicleDoors.id }}</td>
                    <td>{{ vehicleDoors.quantity }}</td>
                    <td class="is-end">
                        <div class="is-flex is-justify-content-flex-end">
                            <VIconButton
                                color="danger"
                                light
                                raised
                                circle
                                @click="deleteVehicleDoors(vehicleDoors.id)"
                                icon="lucide:x"
                            />
                            <VIconButton
                                color="primary"
                                light
                                raised
                                circle
                                @click="editVehicleDoors(vehicleDoors)"
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
        :open="dialogNewVehicleDoor"
        title="Nova Quantidade de Portas"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveVehicleDoors"
        @close="dialogNewVehicleDoor = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Quantidade de Portas</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="form.quantity"
                                    type="number"
                                    placeholder="Quantidade de Portas"
                                    autocomplete="vehicleDoors-name"
                                    maxlength="2"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="form.errors?.quantity"
                                >
                                    {{ form.errors.quantity }}
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
        :open="modelEditVehicleDoors.show"
        title="Editar Quantidade de Portas"
        size="small"
        actions="center"
        cancel-label="Cancelar"
        @submit.prevent="saveEditVehicleDoors"
        @close="modelEditVehicleDoors.show = false"
    >
        <template #content>
            <div class="fieldset">
                <div class="columns is-multiline">
                    <div class="column is-12">
                        <label>Quantidade de Portas</label>
                        <VField>
                            <VControl >
                                <VInput
                                    v-model="formEdit.quantity"
                                    type="number"
                                    placeholder="Quantidade de Portas"
                                    autocomplete="vehicleDoors-name"
                                    maxlength="255"
                                />
                                <p
                                    class="help has-text-danger"
                                    v-if="formEdit.errors?.quantity"
                                >
                                    {{ formEdit.errors.quantity }}
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
    vehicleDoors: Array,
});

const notyf       = new Notyf();
const isUploading = ref(false)
const isLoading   = ref(false)

const modelVehicleDoors = reactive({
    show: false,
    id: null,
});

const modelEditVehicleDoors = reactive({
    show: false,
    id: null,
});

const dialogNewVehicleDoor= ref(false);
const loading = ref(false);

const form = useForm({
    quantity: "",
});

const formEdit = useForm({
    quantity: "",
});

const saveVehicleDoors = () => {
    console.log(form.value);
    form.clearErrors();
    form.post(route("vehicleDoors.store"), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Quantidade adicionada com sucesso!");
            dialogNewVehicleDoor.value = false;
            form.reset();
            router.reload({ only: ["vehicleDoors"] });
        },
        onFinish: () => {},
    });
};

const deleteVehicleDoors= (id) => {
    loading.value = true;
    form.delete(route("vehicleDoors.destroy", id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Quantidade removida com sucesso!");
            router.reload({ only: ["vehicleDoors"] });
            modelVehicleDoors.show = false;
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const editVehicleDoors = (vehicleFuelType) => {
    modelEditVehicleDoors.show = true;
    modelEditVehicleDoors.id = vehicleFuelType.id;
    formEdit.name = vehicleFuelType.name;
};

const saveEditVehicleDoors = () => {
    loading.value = true;
    formEdit.clearErrors();
    formEdit.put(route("vehicleDoors.update", modelEditVehicleDoors.id), {
        preserveScroll: true,
        onSuccess: () => {
            notyf.success("Quantidade atualizada com sucesso!");
            modelEditVehicleDoors.show = false;
            formEdit.reset();
            router.reload({ only: ["vehicleDoors"] });
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

</script>

