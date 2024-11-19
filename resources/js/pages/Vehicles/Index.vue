<template>
    <VCard radius="large">
        <h2 class="title is-4">Lista de Veículos</h2>
        <VButton
            color="primary"
            icon="fas fa-plus"
            elevated
            @click="router.visit(route('vehicles.create'))"
            class="mb-4"
        >
            Adicionar
        </VButton>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Versão</th>
                    <th scope="col">Ano</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Valor</th>
                    <th scope="col" class="is-end">
                        <div class="dark-inverted is-flex is-justify-content-flex-end"
                        >
                            Acoes
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="vehicle in props.vehicles">
                    <td>{{ vehicle.id }}</td>
                    <td><VAvatar squared size="medium" :picture="vehicle.main_image.image_url" /></td>
                    <td>{{ vehicle.category.name }}</td>
                    <td><VAvatar :picture="vehicle.brand_model.brand.image_url" /></td>
                    <td>{{ vehicle.brand_model.name }}</td>
                    <td>{{ vehicle.brand_model.version ? vehicle.brand_model.version : 'N/A' }}</td>
                    <td>{{ `${vehicle.year}/${vehicle.year_model}` }}</td>
                    <td>{{ vehicle.state.uf }}</td>
                    <td>{{ vehicle.city.name }}</td>
                    <td>{{ vehicle.license_plate }}</td>
                    <td>{{ toCurrency(vehicle.value) }}</td>
                    <td class="is-end">
                        <VDropdown icon="lucide:more-vertical">
                            <template #content>
                                <li class="dropdown-item" style="cursor: pointer;" @click="view(vehicle)"> Visualizar </li>
                                <li class="dropdown-item" style="cursor: pointer;" @click="modalDelete(vehicle)"> Excluir </li>
                            </template>
                        </VDropdown>
                    </td>
                </tr>
            </tbody>
        </table>

        <VModal
            :open="modal.show"
            size="small"
            actions="center"
            @close="modal.show = false"
            :title="`Veículo #${modal.data?.id} - ${modal.data?.brand_model?.brand.name} ${modal.data?.brand_model?.name} `"
        >
            <template #content>
                <VPlaceholderSection
                    title="Deseja excluir?"
                    :subtitle="`Deseja excluir o veículo #${modal.data?.id}?`"
                />
            </template>
            <template #action>
                <VButton color="danger" raised @click="deleteVehicle">
                    Excluir
                </VButton>
            </template>
        </VModal>
    </VCard>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { onMounted, reactive } from "vue";
import { toCurrency } from  "../../utils/helpers"
import { useNotyf } from "@/composables/notyf";

const notyf = useNotyf();

const props = defineProps({
    vehicles: Array,
});

const form = useForm({});

const modal = reactive({
    show: false,
    data: null
})

const view = (vehicle) => {
    router.visit(route("vehicles.show", vehicle.id));
};

const modalDelete = (vehicle) => {
    modal.data = vehicle;
    modal.show = true;
};

const deleteVehicle = () => {
    form.delete(route("vehicles.destroy", {vehicle: modal.data.id}), {
        preserveScroll: true,
        onSuccess: () => {
            notyf?.success("Veículo excluído com sucesso!");
            modal.show = false;
            router.reload({ only: ["vehicles"] });
        },
    });
};

onMounted(() => {
    console.log(props.vehicles);
});
</script>