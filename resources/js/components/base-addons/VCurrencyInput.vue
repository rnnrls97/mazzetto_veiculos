<template>
    <VInput
        v-model="formattedValue"
        ref="inputRef"
        type="text"
    />
</template>

<script setup>
import { useCurrencyInput } from 'vue-currency-input';
import { watch } from 'vue';

const props = defineProps({ modelValue: Number });

const { inputRef, formattedValue, setValue } = useCurrencyInput({
    locale: 'pt-BR',
    currency: 'BRL',
    hideCurrencySymbolOnFocus: false,
    hideGroupingSeparatorOnFocus: false,
    hideNegligibleDecimalDigitsOnFocus: false,
    autoDecimalDigits: true,
    useGrouping: true,
    accountingSign: false
});

watch(
    () => props.modelValue,
    (value) => {
        setValue(value);
    }
)
</script>