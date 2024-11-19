export const debounce = (fn, delay) => {
    let timeoutId = null;

    return function () {
        clearTimeout(timeoutId);
        let args = arguments;
        let that = this;

        timeoutId = setTimeout(() => fn.apply(that, args), delay);
    };
};

export const toCurrency = (val) => {
    const value = !val ? 0 : val;

    return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
    }).format(value);
};

export const formatDateTime = (date) => {
    return new Date(date).toLocaleString("pt-BR");
};

export const formatDate = (date) => {
    if (!date) {
        return "";
    }
    const parts = date.split(" ");
    const datePart = parts[0];
    const dateParts = datePart.split("-");
    const formattedDate =
        dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0];

    return formattedDate;
};

export const formateDateInput = (dateString) => {
    // Verifica se a entrada é uma string não vazia
    if (typeof dateString !== "string" || dateString.trim() === "") {
        throw new Error("A data fornecida não é uma string válida.");
    }

    const date = new Date(dateString);

    // Verifica se a data é válida
    if (isNaN(date.getTime())) {
        throw new Error("A data fornecida não é válida.");
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
};

export const formatPhone = (phone, mask = true) => {
    const regex =
        phone.length > 10 ? /(\d{2})(\d{5})(\d{4})/ : /(\d{2})(\d{4})(\d{4})/;
    const formattedNumber = phone.replace(regex, "($1) $2-$3");
    const parts = formattedNumber.split("-");

    if (mask) {
        const repeat = phone.length > 8 ? 4 : 3;

        parts[0] = parts[0].substring(0, 6) + "*".repeat(repeat);
    }

    return parts.join("-");
};


export const joinDateTime = (date = new Date(), time = "00:00") => {
    const data = new Date(date);

    const [horaDoDia, minutos] = time.split(":");

    // Definir a hora na data, agora usando setUTCHours
    data.setUTCHours(horaDoDia);
    data.setMinutes(minutos);

    return `${data.toISOString()}`;
};

export const formatDocument = (val) => {
    const document = val.replace(/\D/g, "");
    // Verifica se é CPF (11 dígitos) ou CNPJ (14 dígitos)
    if (document.length === 11) {
        // Formata CPF: XXX.XXX.XXX-XX
        return "********" + document.slice(-3);
    } else if (document.length === 14) {
        // Formata CNPJ: XX.XXX.XXX/XXXX-XX
        return document.replace(
            /(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,
            "$1.$2.$3/$4-$5"
        );
    } else {
        // Retorna o valor original se não for um CPF ou CNPJ válido
        return document;
    }
};

export const formatCEP = (cep) => {
    // Remove todos os caracteres não numéricos
    cep = cep.replace(/\D/g, "");

    // Adiciona a formatação desejada (por exemplo, "XXXXX-XXX")
    return cep.replace(/(\d{5})(\d{3})/, "$1-$2");
};

export const getTimeDateTime = (dateTime) => {
    const dataFormatada = new Date(dateTime);

    // Extrair a hora, minutos e segundos
    const horas = dataFormatada.getHours();
    const minutos = dataFormatada.getMinutes();

    // Formatar a hora como uma string no formato desejado (HH:mm:ss)
    return (
        horas.toString().padStart(2, "0") +
        ":" +
        minutos.toString().padStart(2, "0")
    );
};

export const convertDateTime = (date) => {
    // Criar um objeto de data a partir da string
    const data = new Date(date);

    // Extrair ano, mês, dia, horas e minutos
    const ano = data.getFullYear();
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const dia = data.getDate().toString().padStart(2, "0");
    const horas = data.getHours().toString().padStart(2, "0");
    const minutos = data.getMinutes().toString().padStart(2, "0");

    return `${ano}-${mes}-${dia} ${horas}:${minutos}`;
};

export const can = (permissions, ability) => {
    return permissions.includes(ability);
};

export const getZipCode = async (zipCode) => {
    const response = await fetch(`https://viacep.com.br/ws/${zipCode}/json/`);
    return response.json();
};

export const copyToClipboard = (item) => {
    if (navigator.clipboard) {
        navigator.clipboard
            .writeText(item)
            .then(function () {
                toastSuccessMessage("Texto copiado com sucesso!");
            })
            .catch(function (err) {
                fallbackCopyToClipboard(item);
            });
    } else {
        fallbackCopyToClipboard(item);
    }
};

const fallbackCopyToClipboard = (item) => {
    const textArea = document.createElement("textarea");
    textArea.value = item;

    textArea.style.position = "fixed";
    textArea.style.top = "0";
    textArea.style.left = "0";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        const successful = document.execCommand("copy");

        if (successful) {
            toastSuccessMessage("Texto copiado com sucesso!");
        } else {
            toastErrorMessage("Falha ao copiar o texto selecionado!");
        }
    } catch (err) {
        toastErrorMessage("Falha ao copiar o texto selecionado!");
    }

    document.body.removeChild(textArea);
};
