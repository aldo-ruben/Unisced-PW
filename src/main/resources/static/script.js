const pedidoSelect = document.getElementById('pedido');
const declaracaoSubopcoes = document.getElementById('declaracao_subopcoes');
const realizacaoExameSubopcoes = document.getElementById('realizacao_exame_subopcoes');
const justificativaInput = document.getElementById('justificativa');
const dataInput = document.getElementById('data');
const enviarButton = document.querySelector('button[type="submit"]');

// Função para mostrar ou ocultar as subopções específicas de determinados pedidos
const toggleSubopcoes = () => {
    const pedidoSelecionado = pedidoSelect.value;

    // Mostrar as subopções específicas de Declaração
    declaracaoSubopcoes.style.display = pedidoSelecionado === 'declaracao' ? 'block' : 'none';

    // Mostrar as subopções específicas de Realização de Exame
    realizacaoExameSubopcoes.style.display = pedidoSelecionado === 'realizacao_exame' ? 'block' : 'none';
};

// Adicionar um ouvinte de evento de mudança ao selecionar um pedido
pedidoSelect.addEventListener('change', toggleSubopcoes);

// Adicionar um ouvinte de evento de entrada à justificativa para habilitar/desabilitar o campo de data e o botão "Enviar"
justificativaInput.addEventListener('input', () => {
    const justificativaPreenchida = justificativaInput.value.trim() !== '';
    dataInput.required = justificativaPreenchida;
    enviarButton.disabled = !justificativaPreenchida;
});

// Função para validar a data (opcional)
function validateDate(date) {
    // Implementar a validação da data
    return true;
}

// Adicionar um ouvinte de evento de perda de foco ao campo de data para validar a data (opcional)
dataInput.addEventListener('blur', () => {
    if (!validateDate(dataInput.value)) {
        dataInput.classList.add('error');
    } else {
        dataInput.classList.remove('error');
    }
});

// Inicializar a função para mostrar/ocultar as subopções
toggleSubopcoes();
