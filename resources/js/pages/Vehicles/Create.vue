<template>
    <div class="columns is-multiline">
        <div class="column is-9">
            <form
                method="post"
                novalidate
                class="form-layout is-stacked"
                @submit.prevent="onSubmit"
            >
                <div class="form-outer">
                    <div
                        :class="[isStuck && 'is-stuck']"
                        class="form-header stuck-header"
                    >
                        <div class="form-header-inner">
                            <div class="left">
                                <h3>Cadastrar Veículo</h3>
                            </div>
                            <div class="right">
                                <div class="buttons">
                                    <VButton
                                        icon="lnir lnir-arrow-left rem-100"
                                        to="/sidebar/layouts/profile-view"
                                        light
                                        dark-outlined
                                    >
                                        Cancelar
                                    </VButton>
                                    <VButton type="submit" color="primary" raised>
                                        Cadastrar
                                    </VButton>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-section">
                            <div class="form-section-header">
                                <div class="left">
                                    <VField>
                                        <VFlex column-gap="1rem">
                                            <VControl>
                                                <VCheckbox
                                                    v-model="form.active"
                                                    label="Ativo"
                                                    color="primary"
                                                    circle
                                                />
                                            </VControl>
                                            <VControl subcontrol>
                                                <VCheckbox
                                                    v-model="form.highlight"
                                                    label="Em destaque"
                                                    color="primary"
                                                    circle
                                                />
                                            </VControl>
                                            <VControl subcontrol>
                                                <VCheckbox
                                                    v-model="form.payroll_loan"
                                                    label="Consignado"
                                                    color="primary"
                                                    circle
                                                />
                                            </VControl>
                                        </VFlex>
                                    </VField>
                                </div>
                                <div class="right">
                                    <VControl>
                                        <VDropdown>
                                            <template #button="{ open, toggle }">
                                            <VTag
                                                color="primary"
                                                :label="props.statuses.find(status => status.id === form.vehicle_status_id).description"
                                                rounded
                                                outlined
                                                @mouseenter="open"
                                                @focusin="open"
                                                @click="toggle"
                                            />

                                            </template>

                                            <template #content="{ close }">
                                                <div
                                                    role="button"
                                                    tabIndex="0"
                                                    @mouseleave="close"
                                                    @focusout="close"
                                                >
                                                    <li 
                                                        v-for="status in props.statuses" 
                                                        class="dropdown-item"
                                                        @click="form.vehicle_status_id = status.id"
                                                    > 
                                                        {{ status.description }} 
                                                    </li>
                                                </div>
                                            </template>
                                        </VDropdown>
                                    </VControl>
                                </div>
                            </div>

                            <div class="columns is-multiline">
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Categoria</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.category_id"
                                                label="name"
                                                value-prop="id"
                                                :options="props.categories"
                                                placeholder="Selecione a categoria"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.category_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Tipo</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_type_id"
                                                label="name"
                                                value-prop="id"
                                                :options="types"
                                                placeholder="Selecione o tipo"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_type_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField class="is-image-select">
                                        <VLabel>Marca</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="brandId"
                                                label="name"
                                                value-prop="id"
                                                :options="props.brands"
                                                placeholder="Selecione a marca"
                                                :searchable="true"
                                            >
                                                <template #singlelabel="{ value }">
                                                    <div class="multiselect-single-label">
                                                        <img
                                                        class="select-label-icon"
                                                        :src="value.image_url"
                                                        alt=""
                                                        >
                                                        <span class="select-label-text">
                                                        {{ value.name }}
                                                        </span>
                                                    </div>
                                                </template>
                                                <template #option="{ option }">
                                                <img
                                                    class="select-option-icon"
                                                    :src="option.image_url"
                                                    alt=""
                                                >
                                                <span class="select-label-text">
                                                    {{ option.name }}
                                                </span>
                                                </template>
                                            </Multiselect>
                                            <VError :error="props.errors?.brand_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Modelo</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.brand_model_id"
                                                label="name"
                                                value-prop="id"
                                                :options="models"
                                                placeholder="Selecione o modelo"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.brand_model_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Versão</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.model_version_id"
                                                label="name"
                                                value-prop="id"
                                                :options="versions"
                                                placeholder="Selecione a versão"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.model_version_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Cor</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_color_id"
                                                label="name"
                                                value-prop="id"
                                                :options="props.colors"
                                                placeholder="Selecione a cor"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_color_id" />
                                        </VControl>
                                    </VField>
                                </div>

                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Portas</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_door_id"
                                                label="quantity"
                                                value-prop="id"
                                                :options="props.doors"
                                                placeholder="Selecione a quantidade de portas"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_door_id" />
                                        </VControl>
                                    </VField>
                                </div>

                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Tipo de Combustível</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_fuel_type_id"
                                                label="name"
                                                value-prop="id"
                                                :options="props.fuelTypes"
                                                placeholder="Selecione a versão"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_fuel_type_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Câmbio</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_transmission_id"
                                                label="name"
                                                value-prop="id"
                                                :options="props.transmissions"
                                                placeholder="Selecione o câmbio"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_transmission_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Condição do Veículo</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.vehicle_condition_id"
                                                label="name"
                                                value-prop="id"
                                                :options="props.conditions"
                                                placeholder="Selecione a condição do veículo"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.vehicle_condition_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Ano</VLabel>
                                        <VControl>
                                            <VInput 
                                                type="number" 
                                                placeholder="2024"
                                                v-model="form.year"
                                            />
                                            <VError :error="props.errors?.year" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6 ">
                                    <VField>
                                        <VLabel>Ano Modelo</VLabel>
                                        <VControl>
                                            <VInput
                                                type="number" 
                                                placeholder="2024" 
                                                v-model="form.year_model"
                                                :error="props.errors?.year_model"
                                            />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-12 ">
                                    <VField v-slot="{ id }">
                                        <VLabel>Acessórios</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.accessories"
                                                label="name"
                                                value-prop="id"
                                                :attrs="{ id }"
                                                mode="tags"
                                                :searchable="true"
                                                :create-tag="true"
                                                :options="props.accessories"
                                                placeholder="Adicione acessórios"
                                            />
                                        </VControl>
                                    </VField>
                                </div>
                            </div>

                            <div class="form-section-header"></div>

                            <div class="columns is-multiline">
                                <div class="column is-6 ">
                                    <VField>
                                        <VLabel>Placa</VLabel>
                                        <VControl>
                                            <VInput 
                                                type="text" 
                                                v-model="form.license_plate"
                                                placeholder="ABC1D234" 
                                            />
                                            <VError :error="props.errors?.license_plate" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6 ">
                                    <VField>
                                        <VLabel>Renavam</VLabel>
                                        <VControl>
                                            <VInput 
                                                type="text" 
                                                v-model="form.renavam"
                                                placeholder="00000000000" 
                                            />
                                            <VError :error="props.errors?.renavam" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Valor do Veículo</VLabel>
                                        <VControl>
                                            <VCurrencyInput
                                                label="Valor"
                                                hide-details="auto"
                                                v-model="form.value"
                                                :error="props.errors?.value"
                                            />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6 ">
                                    <VField>
                                        <VLabel>Quilometragem</VLabel>
                                        <VControl>
                                            <VInput 
                                                type="number"
                                                v-model="form.km_mileage"
                                                placeholder="50000" 
                                            />
                                            <VError :error="props.errors?.km_mileage" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>UF</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.state_id"
                                                label="name"
                                                value-prop="id"
                                                :options="states"
                                                placeholder="Selecione o estado"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.state_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-6">
                                    <VField>
                                        <VLabel>Cidade</VLabel>
                                        <VControl>
                                            <Multiselect
                                                v-model="form.city_id"
                                                label="name"
                                                value-prop="id"
                                                :options="cities"
                                                placeholder="Selecione a cidade"
                                                :searchable="true"
                                            />
                                            <VError :error="props.errors?.city_id" />
                                        </VControl>
                                    </VField>
                                </div>
                                <div class="column is-12">
                                    <VField>
                                        <VLabel>Observação</VLabel>
                                        <VControl>
                                            <VTextarea
                                                class="textarea"
                                                rows="4"
                                                v-model="form.observation"
                                                placeholder="Observações sobre o veículo..."
                                            />
                                        </VControl>
                                    </VField>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="form-layout column is-3">
            <div class="form-outer">
                <div class="form-header stuck-header">
                    <div class="form-header-inner">
                        <div class="left">
                            <h3>Imagens</h3>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-section">
                        <VField>
                            <VControl>
                                <VFilePond
                                    label-idle="<i class='lnil lnil-cloud-upload'></i>"
                                    :accepted-file-types="['image/png', 'image/jpeg', 'image/gif', 'image/webp']"
                                    @removefile="onRemoveFile"
                                    @addfile="onAddFile"
                                    :allow-multiple="true"
                                    :allow-reorder="true"
                                    :profile="false"
                                />
                            </VControl>
                        </VField>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useNotyf } from "@/composables/notyf";
import VError from "@/components/base/VError.vue";

    const props = defineProps({
        categories: Array,
        brands: Array,
        models: Array,
        types: Array,
        conditions: Array,
        fuelTypes: Array,
        transmissions: Array,
        colors: Array,
        doors: Array,
        statuses: Array,
        states: Array,
        accessories: Array,
        errors: Object,
    });

    const form = useForm({
        reseller_id: 1,
        category_id: null,
        vehicle_type_id: null,
        brand_model_id: null,
        model_version_id: null,
        vehicle_condition_id: null,
        vehicle_fuel_type_id: null,
        vehicle_transmission_id: null,
        vehicle_color_id: null,
        vehicle_door_id: null,
        state_id: null,
        city_id: null,
        year: null,
        year_model: null,
        value: null,
        highlight: false,
        payroll_loan: false,
        license_plate: null,
        km_mileage: null,
        renavam: null,
        observation: null,
        active: true,
        vehicle_status_id: 1,
        images: [],
        accessories: [],
    });

    const notyf = useNotyf();

    const brandId = ref(null)
    const versions = ref([])
    const cities = ref([])

    const { y } = useWindowScroll();
    const isStuck = computed(() => {
        return y.value > 30;
    });


    const types = computed(() => {
        return props.types.filter((type) => type.category_id === form.category_id);
    });

    const models = computed(() => {
        return props.models.filter((model) => model.brand_id === brandId.value);
    });


    const getModelVersions = () => {
        versions.value = [];
        axios.get(`/brand-models/${form.brand_model_id}/versions`)
            .then((response) => versions.value = response.data);
    }

    const getCities = () => {
        cities.value = [];
        axios.get(`/states/${form.state_id}/cities`)
            .then((response) => cities.value = response.data);
    }

    const onAddFile = (error, fileInfo) => {
        if (error) {
            console.error(error)
            return
        }

        form.images.push(fileInfo.file)
    }

    const onRemoveFile = (error, fileInfo) => {
        if (error) {
            console.error(error)
            return
        }

        form.images = form.images.filter((image) => image !== fileInfo.file)
    }


    const onSubmit = () => {
        form.post(route("vehicles.store"), {
            preserveScroll: true,
            onSuccess: () => {
                notyf?.primary("Veículo cadastrado com sucesso!");
                router.visit(route("vehicles.index"));
                form.reset();
            },
        });
    };

    watch(() => brandId.value, () => {
        form.brand_model_id = null;
        form.model_version_id = null;

        versions.value = [];
    });


    watch(() => form.brand_model_id, (value) => {
        if(!value) return;

        form.model_version_id = null;

        getModelVersions();
    });

    watch(() => form.state_id, (value) => {
        if(!value) return;

        getCities();
    });


</script>


<style lang="scss">
    @import "/@src/scss/abstracts/all";
    @import "/@src/scss/components/forms-outer";

    .is-navbar {
        .form-layout {
            margin-top: 30px;
        }
    }

    .form-layout {
        max-width: 740px;
        margin: 0 auto;

        &.is-stacked {
            .form-outer {
                .form-body {
                    padding: 0;

                    .form-section {
                        padding: 40px;
                        border-bottom: 1px solid
                            color-mix(in oklab, var(--fade-grey), black 4%);

                        &.is-grey {
                            background: #fafafa;
                        }

                        .form-section-header {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            border-bottom: 1px solid
                                color-mix(in oklab, var(--fade-grey), black 4%);
                            padding-bottom: 20px;
                            margin-bottom: 30px;

                            .left {
                                h3 {
                                    font-family: var(--font-alt);
                                    font-weight: 600;
                                    color: var(--dark-text);
                                }
                            }
                        }

                        .form-section-inner {
                            &.is-horizontal {
                                max-width: 540px;
                            }

                            .field {
                                &.is-horizontal {
                                    .field-label {
                                        padding-top: 0.75em;
                                    }
                                }
                            }
                        }

                        .columns {
                            .column {
                                padding-top: 0.5rem;
                                padding-bottom: 0.5rem;
                            }
                        }

                        .field {
                            .control {
                                .checkbox {
                                    padding: 0;
                                    padding-inline-end: 10px;
                                    font-size: 0.9rem;
                                }
                            }
                        }

                        .participants {
                            display: flex;
                            padding-bottom: 10px;

                            .v-avatar {
                                margin-inline-end: 8px;
                            }

                            .add-participant {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 40px;
                                width: 40px;
                                min-width: 40px;
                                border-radius: var(--radius-rounded);
                                border: 1.6px dashed var(--light-text);
                                color: var(--light-text);
                                padding: 0;
                                background: none;
                                margin-inline-start: 4px;
                                cursor: pointer;
                                transition: color 0.3s, background-color 0.3s,
                                    border-color 0.3s, height 0.3s, width 0.3s;

                                &:hover,
                                &:focus {
                                    border: 1.6px solid var(--primary);
                                    color: var(--primary);
                                }

                                &:focus-visible {
                                    outline-offset: var(
                                        --accessibility-focus-outline-offset
                                    );
                                    outline-width: var(
                                        --accessibility-focus-outline-width
                                    );
                                    outline-style: var(
                                        --accessibility-focus-outline-style
                                    );
                                    outline-color: var(
                                        --accessibility-focus-outline-color
                                    );
                                }

                                .iconify {
                                    height: 16px;
                                    width: 16px;
                                }
                            }
                        }

                        .color-codes {
                            display: flex;
                            align-items: center;
                            height: 38px;

                            .color-code {
                                height: 14px;
                                width: 14px;
                                border-radius: var(--radius-rounded);
                                background: var(--white);
                                margin-inline-end: 10px;
                                border: 3px solid var(--light-text);
                                cursor: pointer;
                                opacity: 0.6;
                                transition: color 0.3s, background-color 0.3s,
                                    border-color 0.3s, height 0.3s, width 0.3s;

                                &:hover,
                                &:focus {
                                    opacity: 1;
                                }

                                &:focus-visible {
                                    outline-offset: var(
                                        --accessibility-focus-outline-offset
                                    );
                                    outline-width: var(
                                        --accessibility-focus-outline-width
                                    );
                                    outline-style: var(
                                        --accessibility-focus-outline-style
                                    );
                                    outline-color: var(
                                        --accessibility-focus-outline-color
                                    );
                                }

                                &.is-primary {
                                    border-color: var(--primary);

                                    &.is-active {
                                        background: var(--primary);
                                    }
                                }

                                &.is-secondary {
                                    border-color: var(--secondary);

                                    &.is-active {
                                        background: var(--secondary);
                                    }
                                }

                                &.is-info {
                                    border-color: var(--info);

                                    &.is-active {
                                        background: var(--info);
                                    }
                                }

                                &.is-success {
                                    border-color: var(--success);

                                    &.is-active {
                                        background: var(--success);
                                    }
                                }

                                &.is-purple {
                                    border-color: var(--purple);

                                    &.is-active {
                                        background: var(--purple);
                                    }
                                }
                            }
                        }

                        .add-link {
                            display: inline-block;
                            padding: 4px 0;
                            font-family: var(--font);
                            font-weight: 500;
                            font-size: 0.9rem;
                            color: var(--primary);
                        }
                    }
                }
            }
        }
    }

    .is-dark {
        .form-layout {
            &.is-stacked {
                .form-outer {
                    .form-body {
                        .form-section {
                            border-color: color-mix(
                                in oklab,
                                var(--dark-sidebar),
                                white 12%
                            );

                            &.is-grey {
                                background: color-mix(
                                    in oklab,
                                    var(--dark-sidebar),
                                    white 4%
                                );
                            }

                            .form-section-header {
                                border-color: color-mix(
                                    in oklab,
                                    var(--dark-sidebar),
                                    white 12%
                                );

                                .left {
                                    h3 {
                                        color: var(--dark-dark-text);
                                    }
                                }
                            }

                            .form-section-inner {
                                .add-link {
                                    color: var(--primary);
                                }

                                .color-codes {
                                    .color-code {
                                        background: color-mix(
                                            in oklab,
                                            var(--dark-sidebar),
                                            white 6%
                                        );

                                        &.is-primary {
                                            border-color: var(--primary);
                                        }
                                    }
                                }

                                .participants {
                                    .add-participant {
                                        &:hover {
                                            border: 1.6px solid var(--primary);
                                            color: var(--primary);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    @media only screen and (width <= 767px) {
        .form-layout {
            &.is-stacked {
                .form-outer {
                    .form-body {
                        .is-vhidden {
                            display: none !important;
                        }
                    }
                }

                .v-calendar-combo {
                    margin: 0 !important;

                    .column {
                        padding-top: 0 !important;
                        padding-bottom: 0 !important;

                        &:first-child {
                            padding-inline-start: 0 !important;
                        }

                        &:last-child {
                            padding-inline-end: 0 !important;
                        }
                    }
                }
            }
        }
    }

    .dropdown-item {
        cursor: pointer;
    }
    
    .filepond--credits {
        display: none;
    }
</style>