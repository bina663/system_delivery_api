@extends('template.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/web/cardapio.css') }}">
@endsection

@section('title','Cardápio')

@section('content')
<div class="container">

    <h2 class="mt-4 mb-4">Hambúrgueres</h2>
    
    <div class="d-flex flex-wrap gap-4">
        @foreach($products as $product)
        
            <div class="card" style="width: 18rem;">
            <img
                src="{{ asset('storage/products/' . $product->image) }}"
                class="card-img-top"
                alt="{{ $product->name }}">

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="text-success">R$ {{ number_format($product->value, 2, ',', '.') }}</p>

                    <div class="d-flex gap-2">
                        <button
                            class="btn btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#modalCompleto"
                        >
                            Completos
                        </button>

                        <button
                            class="btn btn-danger"
                            onclick="adicionarCarrinho('{{ addslashes($product->name) }}', {{ $product->value }})"
                        >
                            Adicionar
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- CARRINHO --}}
    <div id="carrinhoFixo" class="carrinho-fixo border bg-light shadow" style="display: none;">
        <h5>Carrinho</h5>

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

    {{-- MODAL COMPLETO --}}
    <div class="modal fade" id="modalCompleto" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Completos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Escolha os adicionais:</p>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="checkbox" id="addQueijo" onchange="atualizarTotalCompleto()">
                            <label for="addQueijo"> Queijo extra</label>
                        </div>
                        <p class="text-success mb-0">+ R$ 5,00</p>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <input type="checkbox" id="addBacon" onchange="atualizarTotalCompleto()">
                            <label for="addBacon"> Bacon extra</label>
                        </div>
                        <p class="text-success mb-0">+ R$ 7,00</p>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <p class="text-success mb-0">R$ <span id="totalCompleto">20,00</span></p>

                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>

                        <button
                            class="btn btn-success"
                            onclick="confirmarCompleto()"
                            data-bs-dismiss="modal"
                        >
                            Confirmar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- WHATSAPP --}}
    <a
        id="whatsappLink"
        href="#"
        target="_blank"
        class="whatsapp-fixo"
    >
        <i class="fa-brands fa-whatsapp"></i>
    </a>

</div>

<script>
    // Telefone vindo do backend (ex: model Config)
    const PHONE = "{{ $config->phone ?? '' }}";
    const PRECO_BASE = 20;

    let carrinho = [];

    function formatarMoeda(valor) {
        return Number(valor).toFixed(2).replace('.', ',');
    }

    // ===== COMPLETO (adicionais) =====
    function atualizarTotalCompleto() {
        let total = PRECO_BASE;

        if (document.getElementById('addQueijo').checked) total += 5;
        if (document.getElementById('addBacon').checked) total += 7;

        document.getElementById('totalCompleto').innerText = formatarMoeda(total);
    }

    function confirmarCompleto() {
        const queijo = document.getElementById('addQueijo').checked;
        const bacon = document.getElementById('addBacon').checked;

        let extras = [];
        let preco = PRECO_BASE;

        if (queijo) {
            extras.push('Queijo');
            preco += 5;
        }

        if (bacon) {
            extras.push('Bacon');
            preco += 7;
        }

        const nome = 'Burger ' + (extras.length ? '(' + extras.join(', ') + ')' : '');
        adicionarCarrinho(nome, preco);

        document.getElementById('addQueijo').checked = false;
        document.getElementById('addBacon').checked = false;
        atualizarTotalCompleto();
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

        document.getElementById('carrinhoFixo').style.display = 'block';
        renderCarrinho();
    }

    function limparCarrinho() {
        carrinho = [];
        renderCarrinho();
    }

    function calcularTotalCarrinho() {
        return carrinho.reduce(
            (total, i) => total + (Number(i.preco) * i.quantidade),
            0
        );
    }

    function renderCarrinho() {
        const lista = document.getElementById('carrinhoLista');
        lista.innerHTML = '';

        carrinho.forEach(item => {
            const li = document.createElement('li');
            li.innerText = `${item.nome} (${item.quantidade}) - R$ ${formatarMoeda(item.preco * item.quantidade)}`;
            lista.appendChild(li);
        });

        document.getElementById('carrinhoTotal').innerText = formatarMoeda(calcularTotalCarrinho());
        atualizarLinkWhatsApp();
    }

    function realizarPagamento() {
        if (carrinho.length === 0) {
            alert("O carrinho está vazio!");
            return;
        }

        alert(`Pagamento realizado!\nTotal: R$ ${formatarMoeda(calcularTotalCarrinho())}`);
        limparCarrinho();
        document.getElementById('carrinhoFixo').style.display = 'none';
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
