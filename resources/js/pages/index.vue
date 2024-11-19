<template>
    <div class="personal-dashboard personal-dashboard-v1">
        <div class="dashboard-header">
            <VAvatar picture="/images/avatars/svg/vuero-1.svg" size="large" />
            <div class="start">
                <h3>Bem-vindo, {{ $page.props.auth.user.name }}!</h3>
            </div>

        </div>

        <!--Body-->
        <div class="dashboard-body">
         
        </div>
    </div>
</template>

<script setup >
const { t } = useI18n()


const pageTitle = useVueroContext('page-title')
onMounted(() => {
    pageTitle.value = t('pages.dashboard-personnal-1.page-title')
})

useHead(() => ({
    title: `${t('pages.dashboard-personnal-1.page-title')} - Sidebar - Vuero`,
}))

const props = defineProps({
    title: {
        type: String,
    },
})

</script>

<style lang="scss">
@import '/@src/scss/abstracts/all';

.is-navbar {
    .personal-dashboard {
        margin-top: 30px;
    }
}

.personal-dashboard-v1 {
    .dashboard-header {
        display: flex;
        align-items: center;
        font-family: var(--font);
        margin-bottom: 30px;

        .start {
            margin-inline-start: 12px;

            h3 {
                font-family: var(--font-alt);
                font-weight: 600;
                font-size: 1.3rem;
                color: var(--dark-text);
            }
        }

        .end {
            margin-inline-start: auto;
            display: flex;
            justify-content: flex-end;

            .button {
                margin-inline-start: 10px;
            }
        }
    }

    .dashboard-body {
        .dashboard-card {
            @include vuero-s-card;

            font-family: var(--font);

            >h4,
            .ApexCharts-title-text {
                font-family: var(--font-alt);
                font-size: 1rem;
                font-weight: 600;
                color: var(--dark-text);
                margin-bottom: 12px;
            }

            .quick-stats {
                .quick-stats-inner {
                    display: flex;
                    flex-wrap: wrap;
                    margin-inline-start: -8px;
                    margin-inline-end: -8px;

                    .quick-stat {
                        width: calc(50% - 16px);
                        padding: 40px 20px;
                        background: var(--widget-grey);
                        margin: 8px;
                        border-radius: var(--radius-large);
                        transition: all 0.3s; // transition-all test

                        :deep(.media-flex-center) {
                            .flex-meta {
                                span {
                                    &:first-child {
                                        font-size: 1.4rem;
                                        font-weight: 600;
                                        color: var(--dark-text);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        .dashboard-card {
            &.is-upgrade {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                background: color-mix(in oklab, var(--primary), white 8%);
                border-color: color-mix(in oklab, var(--primary), white 8%);
                padding: 20px 40px;
                min-height: 320px;
                border-radius: var(--radius-large);
                box-shadow: var(--primary-box-shadow);

                .lnil,
                .lnir {
                    position: absolute;
                    bottom: 1rem;
                    inset-inline-end: 1rem;
                    font-size: 4rem;
                    opacity: 0.3;
                }

                .cta-content {
                    text-align: center;

                    h4 {
                        font-family: var(--font-alt);
                        font-weight: 600;
                        font-size: 1.2rem;
                        color: var(--smoke-white);
                        margin-bottom: 8px;
                    }
                }

                .link {
                    display: block;
                    font-family: var(--font-alt);
                    font-weight: 500;
                    margin-top: 0.5rem;

                    &:hover,
                    &:focus {
                        color: var(--smoke-white);
                        opacity: 0.6;
                    }
                }
            }

            &.is-gauge {
                position: relative;

                .people {
                    position: absolute;
                    top: 80px;
                    inset-inline-start: 0;
                    inset-inline-end: 0;
                    margin: 0 auto;
                    display: flex;
                    justify-content: center;
                    z-index: 5;

                    .v-avatar {
                        margin: 0 4px;
                    }
                }
            }
        }
    }
}

.is-dark {
    .personal-dashboard-v1 {
        .dashboard-header {
            .start {
                h3 {
                    color: var(--dark-dark-text);
                }
            }
        }

        .dashboard-body {
            .dashboard-card {
                @include vuero-card--dark;

                &.is-upgrade {
                    background: var(--primary);
                    border-color: var(--primary);
                    box-shadow: var(--primary-box-shadow);
                }

                .quick-stats {
                    .quick-stats-inner {
                        .quick-stat {
                            background: color-mix(in oklab, var(--dark-sidebar), white 2%);
                            border: 1px solid color-mix(in oklab, var(--dark-sidebar), white 12%);

                            .media-flex-center {
                                .flex-meta {
                                    span {
                                        &:first-child {
                                            color: var(--dark-dark-text);
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
}

@media only screen and (width <=767px) {
    .personal-dashboard-v1 {
        .dashboard-header {
            text-align: center;
            flex-direction: column;

            .start {
                margin: 10px auto;
            }

            .end {
                margin: 0;
                justify-content: space-between;
            }
        }

        .dashboard-body {
            .dashboard-card {
                .quick-stats {
                    .quick-stats-inner {
                        .quick-stat {
                            padding: 20px;

                            .media-flex-center {
                                flex-direction: column;

                                .flex-meta {
                                    margin: 10px 0;
                                    text-align: center;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

@media only screen and (width >=768px) and (width <=1024px) and (orientation: landscape) {
    .personal-dashboard-v1 {
        .dashboard-body {
            .dashboard-card {
                .quick-stats {
                    .quick-stats-inner {
                        .quick-stat {
                            padding: 20px;

                            .media-flex-center {
                                flex-direction: column;

                                .flex-meta {
                                    margin: 2px 0 0;
                                    text-align: center;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>
