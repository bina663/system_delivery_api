@extends('template.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/web/cardapio.css') }}">
@endsection

@section('title','Cardápio')

@section('content')
<div class="container">

    <div class="cardapio-hero text-center p-5 mb-4">
        <h1 class="cardapio-hero-title">Seja bem-vindo ao nosso Cardápio</h1>
        <p class="cardapio-hero-subtitle">Escolha seus favoritos e monte seu pedido</p>
    </div>

    @foreach($categories as $category)
        <h2 class="mt-4">{{ $category->name }}</h2>

        <div class="d-flex flex-wrap gap-4 mb-5">
            @forelse($category->products as $product)

                <div class="card" style="width: 18rem;">
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        class="card-img-top"
                        alt="{{ $product->name }}">

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="text-success">R$ {{ number_format($product->value, 2, ',', '.') }}</p>

                        <div class="d-flex gap-2">
                            @if($product->additionals->count() > 0)
                                <button
                                    class="btn btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCompleto{{ $product->id }}"
                                >
                                    Complementos
                                </button>
                            @endif

                            <button
                                class="btn btn-danger"
                                onclick="adicionarCarrinho('{{ addslashes($product->name) }}', {{ $product->value }})"
                            >
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- MODAL COMPLEMENTOS (só existe se tiver additionals) --}}
                @if($product->additionals->count() > 0)
                    <div class="modal fade" id="modalCompleto{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Complementos — {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>Escolha os adicionais:</p>

                                    @foreach($product->additionals as $additional)
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <input
                                                    type="checkbox"
                                                    class="add-check"
                                                    id="add{{ $product->id }}_{{ $additional->id }}"
                                                    data-price="{{ $additional->price }}"
                                                    data-name="{{ addslashes($additional->name) }}"
                                                    onchange="atualizarTotalCompleto({{ $product->id }}, {{ $product->value }})"
                                                >
                                                <label for="add{{ $product->id }}_{{ $additional->id }}"> {{ $additional->name }}</label>
                                            </div>
                                            <p class="text-success mb-0">+ R$ {{ number_format($additional->price, 2, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="modal-footer d-flex justify-content-between align-items-center">
                                    <p class="text-success mb-0">
                                        R$ <span id="totalCompleto{{ $product->id }}">{{ number_format($product->value, 2, ',', '.') }}</span>
                                    </p>

                                    <div class="d-flex gap-2">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                                            Fechar
                                        </button>

                                        <button
                                            class="btn btn-success"
                                            onclick="confirmarCompleto({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->value }})"
                                            data-bs-dismiss="modal"
                                        >
                                            Confirmar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

            @empty
                <p class="text-muted">Nenhum item nessa categoria.</p>
            @endforelse
        </div>
    @endforeach

    {{-- OVERLAY (fecha o carrinho ao clicar fora) --}}
    <div id="carrinhoOverlay" class="carrinho-overlay" style="display: none;" onclick="fecharCarrinho()"></div>

    {{-- BOTÃO FLUTUANTE CENTRALIZADO --}}
    <button id="carrinhoBotao" class="carrinho-botao" style="display: none;" onclick="abrirCarrinho()">
        <span class="badge-count" id="carrinhoQtd">0</span>
        <span>Ver carrinho</span>
        <span class="badge-total">R$ <span id="carrinhoTotalBotao">0,00</span></span>
    </button>

    {{-- PAINEL DO CARRINHO (bottom sheet) --}}
    <div id="carrinhoFixo" class="carrinho-fixo shadow" style="display: none;">
        <div class="carrinho-handle"></div>

        <div class="carrinho-header">
            <h5>Seu carrinho</h5>
            <button class="btn-close-carrinho" onclick="fecharCarrinho()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <ul class="list-unstyled" id="carrinhoLista"></ul>

        <p><strong>Total: R$ <span id="carrinhoTotal">0,00</span></strong></p>

        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-secondary flex-fill" onclick="limparCarrinho()">
                Limpar
            </button>
            <button class="btn btn-sm btn-success flex-fill" onclick="realizarPagamento()">
                Pagar
            </button>
        </div>
    </div>

    {{-- WHATSAPP --}}
    
        id="whatsappLink"
        href="#"
        target="_blank"
        class="whatsapp-fixo"
    >
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</div>

<script>
    const PHONE = "{{ $config->phone ?? '' }}";

    let carrinho = [];

    function formatarMoeda(valor) {
        return Number(valor).toFixed(2).replace('.', ',');
    }

    // ===== COMPLEMENTOS DINÂMICOS =====
    function atualizarTotalCompleto(productId, precoBase) {
        let total = Number(precoBase);

        document.querySelectorAll(`#modalCompleto${productId} .add-check:checked`).forEach(chk => {
            total += parseFloat(chk.dataset.price);
        });

        document.getElementById(`totalCompleto${productId}`).innerText = formatarMoeda(total);
    }

    function confirmarCompleto(productId, nomeBase, precoBase) {
        let total = Number(precoBase);
        let extras = [];

        document.querySelectorAll(`#modalCompleto${productId} .add-check:checked`).forEach(chk => {
            extras.push(chk.dataset.name);
            total += parseFloat(chk.dataset.price);
        });

        const nome = nomeBase + (extras.length ? ' (' + extras.join(', ') + ')' : '');
        adicionarCarrinho(nome, total);

        document.querySelectorAll(`#modalCompleto${productId} .add-check`).forEach(chk => {
            chk.checked = false;
        });
        atualizarTotalCompleto(productId, precoBase);
    }

    // ===== CARRINHO =====
    function adicionarCarrinho(nome, preco) {
        const itemExistente = carrinho.find(
            item => item.nome === nome && item.preco === preco
        );

        if (itemExistente) {
            itemExistente.quantidade++;
        } else {
            carrinho.push({ nome, preco, quantidade: 1 });
        }

        document.getElementById('carrinhoBotao').style.display = 'flex';
        renderCarrinho();
    }

    function limparCarrinho() {
        carrinho = [];
        renderCarrinho();
        fecharCarrinho();
    }

    function calcularTotalCarrinho() {
        return carrinho.reduce(
            (total, i) => total + (Number(i.preco) * i.quantidade),
            0
        );
    }

    function calcularQtdCarrinho() {
        return carrinho.reduce((total, i) => total + i.quantidade, 0);
    }

    function renderCarrinho() {
        const lista = document.getElementById('carrinhoLista');
        lista.innerHTML = '';

        carrinho.forEach(item => {
            const li = document.createElement('li');
            li.innerText = `${item.nome} (${item.quantidade}) - R$ ${formatarMoeda(item.preco * item.quantidade)}`;
            lista.appendChild(li);
        });

        const total = calcularTotalCarrinho();
        const qtd = calcularQtdCarrinho();

        document.getElementById('carrinhoTotal').innerText = formatarMoeda(total);
        document.getElementById('carrinhoTotalBotao').innerText = formatarMoeda(total);
        document.getElementById('carrinhoQtd').innerText = qtd;

        if (qtd === 0) {
            document.getElementById('carrinhoBotao').style.display = 'none';
            fecharCarrinho();
        }

        atualizarLinkWhatsApp();
    }

    // ===== ABRIR / FECHAR PAINEL =====
    function abrirCarrinho() {
        document.getElementById('carrinhoFixo').style.display = 'block';
        document.getElementById('carrinhoOverlay').style.display = 'block';
        document.getElementById('carrinhoBotao').style.display = 'none';
    }

    function fecharCarrinho() {
        document.getElementById('carrinhoFixo').style.display = 'none';
        document.getElementById('carrinhoOverlay').style.display = 'none';

        if (calcularQtdCarrinho() > 0) {
            document.getElementById('carrinhoBotao').style.display = 'flex';
        }
    }

    function realizarPagamento() {
        if (carrinho.length === 0) {
            alert("O carrinho está vazio!");
            return;
        }

        alert(`Pagamento realizado!\nTotal: R$ ${formatarMoeda(calcularTotalCarrinho())}`);
        limparCarrinho();
    }

    // ===== WHATSAPP =====
    function gerarMensagemWhatsApp() {
        let mensagem = '🛒 Pedido:\n\n';

        carrinho.forEach(item => {
            mensagem += `- ${item.nome} (${item.quantidade}x) - R$ ${formatarMoeda(item.preco * item.quantidade)}\n`;
        });

        mensagem += `\nTotal: R$ ${formatarMoeda(calcularTotalCarrinho())}`;

        return encodeURIComponent(mensagem);
    }

    function atualizarLinkWhatsApp() {
        document.getElementById('whatsappLink').href =
            `https://wa.me/55${PHONE}?text=${gerarMensagemWhatsApp()}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        atualizarLinkWhatsApp();
    });
</script>
@endsection