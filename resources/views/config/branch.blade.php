@extends('template.admin')

@section('title', 'Loja')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/branch.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Loja</h2>
            <p class="text-muted mb-0">
                Gerencie as informações da sua loja.
            </p>
        </div>

    </div>


    {{-- MENSAGENS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>
        </div>
    @endif


    {{-- ERROS --}}
    @if($errors->any())
        <div class="alert alert-danger">

            <strong>Corrija os seguintes erros:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- FORMULÁRIO DA LOJA --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <h5 class="mb-3">
                <i class="bi bi-shop"></i>
                Dados da loja
            </h5>

            <form
                action="{{ route('admin.branch.update') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                <div class="row g-3">


                    {{-- LOGO ATUAL + UPLOAD --}}
                    <div class="col-12">

                        <label class="form-label fw-bold">
                            Logo da loja
                        </label>

                        <div class="d-flex align-items-center gap-3">

                            <div>

                                @if($branch->image ?? null)

                                    <img
                                        src="{{ asset('storage/' . $branch->image) }}"
                                        alt="Logo da loja"
                                        style="
                                            width:100px;
                                            height:100px;
                                            object-fit:cover;
                                            border-radius:10px;
                                        "
                                    >

                                @else

                                    <div
                                        class="d-flex align-items-center justify-content-center bg-light"
                                        style="
                                            width:100px;
                                            height:100px;
                                            border-radius:10px;
                                        "
                                    >
                                        <i class="bi bi-image text-muted fs-2"></i>
                                    </div>

                                @endif

                            </div>

                            <div class="flex-grow-1">

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                                <small class="text-muted">
                                    JPG, JPEG, PNG ou WEBP. Deixe vazio para manter a logo atual.
                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="col-12">
                        <hr>
                    </div>


                    {{-- NOME DA LOJA --}}
                    <div class="col-md-8">

                        <label class="form-label">
                            Nome da loja
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $branch->name ?? '') }}"
                            placeholder="{{ old('name', $branch->name ?? 'Ex: Burger House') }}"
                            required
                        >

                    </div>


                    {{-- VALOR DO FRETE --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Valor do frete (Por KM)
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                name="shipping_value"
                                class="form-control"
                                step="0.01"
                                min="0"
                                value="{{ old('shipping_value', $branch->shipping_value ?? '') }}"
                                placeholder="{{ old('shipping_value', $branch->shipping_value ?? '0,00') }}"
                                required
                            >

                        </div>

                    </div>


                    {{-- TELEFONE WHATSAPP --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Telefone WhatsApp
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-whatsapp"></i>
                            </span>

                            <input
                                type="text"
                                name="whatsapp"
                                id="whatsappInput"
                                class="form-control"
                                value="{{ old('whatsapp', $branch->whatsapp ?? '') }}"
                                placeholder="{{ old('whatsapp', $branch->whatsapp ?? '(00) 00000-0000') }}"
                                required
                            >

                        </div>

                    </div>


                    {{-- CEP --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            CEP
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="cep"
                            id="cepInput"
                            class="form-control"
                            value="{{ old('cep', $branch->cep ?? '') }}"
                            placeholder="{{ old('cep', $branch->cep ?? '00000-000') }}"
                            maxlength="9"
                            required
                        >
                        <small id="cepStatus" class="text-muted"></small>
                    </div>

                    {{-- RUA --}}
                    <div class="col-md-6">
                        <label class="form-label">
                            Rua
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="street"
                            id="streetInput"
                            class="form-control"
                            value="{{ old('street', $branch->street ?? '') }}"
                            placeholder="{{ old('street', $branch->street ?? 'Nome da rua') }}"
                            required
                        >
                    </div>

                    {{-- NÚMERO --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            Número
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="number"
                            class="form-control"
                            value="{{ old('number', $branch->number ?? '') }}"
                            placeholder="{{ old('number', $branch->number ?? 'Ex: 123 ou S/N') }}"
                            required
                        >
                    </div>

                    {{-- COMPLEMENTO --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Complemento
                        </label>
                        <input
                            type="text"
                            name="complement"
                            class="form-control"
                            value="{{ old('complement', $branch->complement ?? '') }}"
                            placeholder="{{ old('complement', $branch->complement ?? 'Sala, bloco, referência...') }}"
                        >
                    </div>

                    {{-- BAIRRO --}}
                    <div class="col-md-4">
                        <label class="form-label">
                            Bairro
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="neighborhood"
                            id="neighborhoodInput"
                            class="form-control"
                            value="{{ old('neighborhood', $branch->neighborhood ?? '') }}"
                            placeholder="{{ old('neighborhood', $branch->neighborhood ?? 'Bairro') }}"
                            required
                        >
                    </div>

                    {{-- CIDADE --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            Cidade
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="city"
                            id="cityInput"
                            class="form-control"
                            value="{{ old('city', $branch->city ?? '') }}"
                            placeholder="{{ old('city', $branch->city ?? 'Cidade') }}"
                            required
                        >
                    </div>

                    {{-- UF --}}
                    <div class="col-md-1">
                        <label class="form-label">
                            UF
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="uf"
                            id="ufInput"
                            class="form-control text-uppercase"
                            value="{{ old('uf', $branch->uf ?? '') }}"
                            placeholder="{{ old('uf', $branch->uf ?? 'UF') }}"
                            maxlength="2"
                            required
                        >
                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="d-flex justify-content-end mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-lg"></i>
                        Salvar alterações
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- CUPONS --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="mb-0">
            <i class="bi bi-ticket-perforated"></i>
            Cupons
        </h5>

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createCouponModal"
        >
            <i class="bi bi-plus-lg"></i>
            Novo cupom
        </button>

    </div>


    {{-- FILTRO --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- BUSCA --}}
                <div class="col-md-8">

                    <label class="form-label">
                        Buscar cupom
                    </label>

                    <input
                        type="text"
                        id="searchCoupon"
                        class="form-control"
                        placeholder="Digite o código do cupom..."
                    >

                </div>


                {{-- STATUS --}}
                <div class="col-md-4">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        id="filterCouponStatus"
                        class="form-select"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option value="1">
                            Ativo
                        </option>

                        <option value="0">
                            Inativo
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- LISTA DE CUPONS --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                Código
                            </th>

                            <th>
                                Nome
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Uso
                            </th>

                            <th>
                                Validade
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="180">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody id="couponsTable">

                        @forelse($coupons as $coupon)

                            <tr
                                class="coupon-row"
                                data-code="{{ strtolower($coupon->code) }}"
                                data-status="{{ $coupon->_status ? '1' : '0' }}"
                            >

                                {{-- CÓDIGO --}}
                                <td>

                                    <strong>
                                        {{ $coupon->code }}
                                    </strong>

                                </td>


                                {{-- NOME --}}
                                <td>
                                    {{ $coupon->name ?? '—' }}
                                </td>


                                {{-- VALOR --}}
                                <td>

                                    <strong>
                                        R$ {{ number_format($coupon->value, 2, ',', '.') }}
                                    </strong>

                                </td>


                                {{-- USO --}}
                                <td>
                                    {{ $coupon->used_count ?? 0 }}
                                    /
                                    {{ $coupon->usage_limit ?? '∞' }}
                                </td>


                                {{-- VALIDADE --}}
                                <td>
                                    @if($coupon->expires_at)
                                        {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Sem validade</span>
                                    @endif
                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($coupon->_status)

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inativo
                                        </span>

                                    @endif

                                </td>


                                {{-- AÇÕES --}}
                                <td>

                                    <div class="d-flex gap-2">

                                        {{-- EDITAR --}}
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCouponModal{{ $coupon->id }}"
                                        >
                                            Editar
                                        </button>


                                        {{-- ATIVAR / DESATIVAR --}}
                                        <form
                                            class="toggle-status-form"
                                            action="{{ route('admin.coupons.toggle-status', $coupon->id) }}"
                                            method="POST"
                                            data-confirm="Tem certeza que deseja {{ $coupon->_status ? 'desativar' : 'ativar' }} este cupom?"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="_status" value="{{ $coupon->_status ? 0 : 1 }}">

                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $coupon->_status ? 'btn-danger' : 'btn-success' }}"
                                                title="{{ $coupon->_status ? 'Desativar' : 'Ativar' }}"
                                            >
                                                {{ $coupon->_status ? 'Desativar' : 'Ativar' }}
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        <i
                                            class="bi bi-ticket-perforated"
                                            style="font-size:40px;"
                                        ></i>

                                        <p class="mt-2 mb-0">
                                            Nenhum cupom cadastrado.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAL CRIAR CUPOM --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createCouponModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.coupons.create') }}"
                method="POST"
            >

                @csrf


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i>
                        Criar cupom
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <div class="row g-3">


                        {{-- CÓDIGO --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Código do cupom
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="code"
                                class="form-control text-uppercase"
                                placeholder="Ex: PROMO10"
                                style="text-transform: uppercase;"
                                required
                            >

                        </div>


                        {{-- NOME --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Nome do cupom
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Ex: Promoção de aniversário"
                            >

                        </div>


                        {{-- VALOR --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Valor
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    R$
                                </span>

                                <input
                                    type="number"
                                    name="value"
                                    class="form-control"
                                    step="0.01"
                                    min="0"
                                    placeholder="0,00"
                                    required
                                >

                            </div>

                        </div>


                        {{-- LIMITE DE USO --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Limite de uso
                            </label>

                            <input
                                type="number"
                                name="usage_limit"
                                class="form-control"
                                min="1"
                                placeholder="Deixe vazio para ilimitado"
                            >

                        </div>


                        {{-- VALIDADE --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Data de validade
                            </label>

                            <input
                                type="date"
                                name="expires_at"
                                class="form-control"
                            >

                        </div>


                        {{-- STATUS --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="_status"
                                class="form-select"
                                required
                            >

                                <option value="1">
                                    Ativo
                                </option>

                                <option value="0">
                                    Inativo
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-lg"></i>
                        Criar cupom
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAIS EDITAR CUPOM --}}
{{-- ========================================================= --}}

@foreach($coupons as $coupon)

<div
    class="modal fade"
    id="editCouponModal{{ $coupon->id }}"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                id="editCouponForm{{ $coupon->id }}"
                action="{{ route('admin.coupons.update', ['id' => $coupon->id]) }}"
                method="POST"
            >
                @csrf
                @method('PUT')


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil"></i>

                        Editar cupom

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <div class="row g-3">


                        {{-- CÓDIGO --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Código do cupom
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="code"
                                class="form-control text-uppercase"
                                style="text-transform: uppercase;"
                                value="{{ $coupon->code }}"
                                required
                            >

                        </div>


                        {{-- NOME --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Nome do cupom
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ $coupon->name }}"
                            >

                        </div>


                        {{-- VALOR --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Valor
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    R$
                                </span>

                                <input
                                    type="number"
                                    name="value"
                                    class="form-control"
                                    step="0.01"
                                    min="0"
                                    value="{{ $coupon->value }}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- LIMITE DE USO --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Limite de uso
                            </label>

                            <input
                                type="number"
                                name="usage_limit"
                                class="form-control"
                                min="1"
                                value="{{ $coupon->usage_limit }}"
                                placeholder="Deixe vazio para ilimitado"
                            >

                        </div>


                        {{-- USOS REALIZADOS (somente leitura) --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Usos realizados
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $coupon->used_count ?? 0 }}"
                                disabled
                            >

                            <small class="text-muted">
                                Esse valor é atualizado automaticamente pelo sistema.
                            </small>

                        </div>


                        {{-- VALIDADE --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Data de validade
                            </label>

                            <input
                                type="date"
                                name="expires_at"
                                class="form-control"
                                value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}"
                            >

                        </div>


                        {{-- STATUS --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="_status"
                                class="form-select"
                                required
                            >

                                <option
                                    value="1"
                                    {{ $coupon->_status ? 'selected' : '' }}
                                >
                                    Ativo
                                </option>

                                <option
                                    value="0"
                                    {{ !$coupon->_status ? 'selected' : '' }}
                                >
                                    Inativo
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </form>


            {{-- FOOTER --}}
            <div class="modal-footer d-flex justify-content-between">

                {{-- EXCLUIR PERMANENTEMENTE --}}
                <form
                    action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE este cupom? Essa ação não pode ser desfeita.')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                    >
                        <i class="bi bi-trash"></i>
                        Excluir permanentemente
                    </button>

                </form>


                <div class="d-flex gap-2">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        form="editCouponForm{{ $coupon->id }}"
                        class="btn btn-warning"
                    >
                        <i class="bi bi-save"></i>
                        Salvar alterações
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const whatsappInput = document.getElementById('whatsappInput');

    if (!whatsappInput) return;

    whatsappInput.addEventListener('input', function () {

        let value = whatsappInput.value.replace(/\D/g, '');

        value = value.slice(0, 11);

        if (value.length > 6) {
            value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
        } else if (value.length > 2) {
            value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
        } else if (value.length > 0) {
            value = value.replace(/^(\d*)/, '($1');
        }

        whatsappInput.value = value;

    });

});


/*
|--------------------------------------------------------------------------
| CEP: MÁSCARA + AUTOCOMPLETE (ViaCEP)
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {

    const cepInput = document.getElementById('cepInput');
    const cepStatus = document.getElementById('cepStatus');
    const streetInput = document.getElementById('streetInput');
    const neighborhoodInput = document.getElementById('neighborhoodInput');
    const cityInput = document.getElementById('cityInput');
    const ufInput = document.getElementById('ufInput');

    if (!cepInput) return;

    // Máscara 00000-000
    cepInput.addEventListener('input', function () {
        let value = cepInput.value.replace(/\D/g, '').slice(0, 8);

        if (value.length > 5) {
            value = value.replace(/^(\d{5})(\d{0,3})/, '$1-$2');
        }

        cepInput.value = value;
    });

    // Busca automática ao completar o CEP
    cepInput.addEventListener('blur', function () {

        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length !== 8) return;

        cepStatus.textContent = 'Buscando endereço...';
        cepStatus.classList.remove('text-danger', 'text-success');

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {

                if (data.erro) {
                    cepStatus.textContent = 'CEP não encontrado.';
                    cepStatus.classList.add('text-danger');
                    return;
                }

                streetInput.value = data.logradouro || streetInput.value;
                neighborhoodInput.value = data.bairro || neighborhoodInput.value;
                cityInput.value = data.localidade || '';
                ufInput.value = data.uf || '';

                cepStatus.textContent = 'Endereço encontrado!';
                cepStatus.classList.add('text-success');
            })
            .catch(() => {
                cepStatus.textContent = 'Erro ao buscar CEP.';
                cepStatus.classList.add('text-danger');
            });
    });

});


/*
|--------------------------------------------------------------------------
| FILTRO DE CUPONS
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchCoupon');
    const statusFilter = document.getElementById('filterCouponStatus');

    if (!searchInput || !statusFilter) return;

    const rows = document.querySelectorAll('.coupon-row');


    function filterCoupons() {

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const status = statusFilter.value;


        rows.forEach(function (row) {

            const code = row.dataset.code;
            const rowStatus = row.dataset.status;

            const matchesSearch = code.includes(search);
            const matchesStatus = !status || rowStatus === status;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';

        });

    }


    searchInput.addEventListener('input', filterCoupons);
    statusFilter.addEventListener('change', filterCoupons);

});


/*
|--------------------------------------------------------------------------
| ATIVAR / DESATIVAR CUPOM (via fetch, sem sair da página)
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.toggle-status-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            if (!confirm(form.dataset.confirm)) {
                return;
            }

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message ?? 'Erro ao atualizar status.');
                }
            })
            .catch(function () {
                alert('Erro ao atualizar status.');
            });

        });

    });

});

</script>

@endsection