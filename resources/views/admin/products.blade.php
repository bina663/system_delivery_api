@extends('template.admin')

@section('title', 'Produtos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/products.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Produtos</h2>
            <p class="text-muted mb-0">
                Gerencie seus produtos, categorias e adicionais.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createProductModal"
        >
            <i class="bi bi-plus-lg"></i>
            Novo produto
        </button>

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


    {{-- FILTRO --}}
    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- BUSCA --}}
                <div class="col-md-6">

                    <label class="form-label">
                        Buscar produto
                    </label>

                    <input
                        type="text"
                        id="searchProduct"
                        class="form-control"
                        placeholder="Digite o nome do produto..."
                    >

                </div>


                {{-- CATEGORIA --}}
                <div class="col-md-4">

                    <label class="form-label">
                        Categoria
                    </label>

                    <select
                        id="filterCategory"
                        class="form-select"
                    >

                        <option value="">
                            Todas as categorias
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">
                                {{ $category->name }}{{ $category->_status ? ' (Ativo)' : ' (Inativo)' }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}
                <div class="col-md-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        id="filterStatus"
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


    {{-- PRODUTOS --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="80">
                                Foto
                            </th>

                            <th>
                                Produto
                            </th>

                            <th>
                                Categoria
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Adicionais
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="180">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody id="productsTable">

                        @forelse($products as $product)

                            <tr
                                class="product-row"
                                data-name="{{ strtolower($product->name) }}"
                                data-category="{{ $product->category_id }}"
                                data-status="{{ $product->_status ? '1' : '0' }}"
                            >

                                {{-- IMAGEM --}}
                                <td>

                                    @if($product->image)

                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            width="60"
                                            height="60"
                                            style="
                                                object-fit: cover;
                                                border-radius: 8px;
                                            "
                                        >

                                    @else

                                        <div
                                            class="d-flex align-items-center justify-content-center bg-light"
                                            style="
                                                width:60px;
                                                height:60px;
                                                border-radius:8px;
                                            "
                                        >
                                            <i class="bi bi-image text-muted"></i>
                                        </div>

                                    @endif

                                </td>


                                {{-- NOME --}}
                                <td>

                                    <strong>
                                        {{ $product->name }}
                                    </strong>

                                    @if($product->description)

                                        <div class="small text-muted">
                                            {{ Str::limit($product->description, 60) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- CATEGORIA --}}
                                <td>

                                    @if($product->categories)

                                        <span class="badge text-light {{ $product->categories->_status ? 'bg-success' : 'bg-danger' }}">
                                            {{ $product->categories->name }} {{ $product->categories->_status ? '(Ativo)' : ' (Inativo)' }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            Sem categoria
                                        </span>

                                    @endif

                                </td>


                                {{-- VALOR --}}
                                <td>

                                    <strong>
                                        R$ {{ number_format($product->value, 2, ',', '.') }}
                                    </strong>

                                </td>


                                {{-- ADICIONAIS --}}
                                <td>

                                @if($product->additionals->count())
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($product->additionals as $additional)
                                            <span class="badge bg-secondary">
                                                {{ $additional->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">
                                        Nenhum
                                    </span>
                                @endif

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($product->_status)

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
                                            data-bs-target="#editProductModal{{ $product->id }}"
                                        >
                                            Editar
                                        </button>


                                        {{-- ATIVAR / DESATIVAR --}}
                                        <form
                                            class="toggle-status-form"
                                            action="{{ route('admin.products.toggle-status', $product->id) }}"
                                            method="POST"
                                            data-confirm="Tem certeza que deseja {{ $product->_status ? 'desativar' : 'ativar' }} este produto?"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="_status" value="{{ $product->_status ? 0 : 1 }}">

                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $product->_status ? 'btn-danger' : 'btn-success' }}"
                                                title="{{ $product->_status ? 'Desativar' : 'Ativar' }}"
                                            >
                                                {{ $product->_status ? 'Desativar' : 'Ativar' }}
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
                                            class="bi bi-box-seam"
                                            style="font-size:40px;"
                                        ></i>

                                        <p class="mt-2 mb-0">
                                            Nenhum produto cadastrado.
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
{{-- MODAL CRIAR PRODUTO --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createProductModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.products.create') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i>
                        Criar produto
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


                        {{-- NOME --}}
                        <div class="col-md-8">

                            <label class="form-label">
                                Nome do produto
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Ex: X-Burger"
                                required
                            >

                        </div>


                        {{-- VALOR --}}
                        <div class="col-md-4">

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


                        {{-- CATEGORIA --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Categoria
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Selecione uma categoria
                                </option>

                                @foreach($categories as $category)

                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}{{ $category->_status ? ' (Ativo)' : ' (Inativo)' }}
                                    </option>

                                @endforeach

                            </select>

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


                        {{-- DESCRIÇÃO --}}
                        <div class="col-12">

                            <label class="form-label">
                                Descrição
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Descrição do produto..."
                            ></textarea>

                        </div>


                        {{-- IMAGEM --}}
                        <div class="col-12">

                            <label class="form-label">
                                Imagem
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <small class="text-muted">
                                JPG, JPEG, PNG ou WEBP. Máximo 2MB.
                            </small>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ADICIONAIS --}}
                        {{-- ================================================= --}}

                        <div class="col-12">

                            <hr>

                            <label class="form-label fw-bold">
                                <i class="bi bi-plus-square"></i>
                                Adicionais
                            </label>

                            <p class="text-muted small">
                                Selecione os adicionais que estarão disponíveis
                                para este produto.
                            </p>


                            @if($additionals && $additionals->count())

                                <div class="row g-2">

                                    @foreach($additionals as $additional)

                                        <div class="col-md-6">

                                            <div class="form-check border rounded p-3">

                                                <input
                                                    class="form-check-input ms-0 me-2"
                                                    type="checkbox"
                                                    name="additionals[]"
                                                    value="{{ $additional->id }}"
                                                    id="create_additional_{{ $additional->id }}"
                                                >

                                                <label
                                                    class="form-check-label"
                                                    for="create_additional_{{ $additional->id }}"
                                                >

                                                    <strong>
                                                        {{ $additional->name }}
                                                    </strong>

                                                    @if(isset($additional->value))

                                                        <span class="text-muted">
                                                            +
                                                            R$
                                                            {{ number_format($additional->value, 2, ',', '.') }}
                                                        </span>

                                                    @endif

                                                </label>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="alert alert-warning">
                                    Nenhum adicional cadastrado.
                                </div>

                            @endif

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
                        Criar produto
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAIS EDITAR --}}
{{-- ========================================================= --}}

@foreach($products as $product)

<div
    class="modal fade"
    id="editProductModal{{ $product->id }}"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

        <form
                id="editProductForm{{ $product->id }}"
                action="{{ route('admin.products.update', ['id' => $product->id]) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil"></i>

                        Editar produto

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


                        {{-- NOME --}}
                        <div class="col-md-8">

                            <label class="form-label">
                                Nome do produto
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ $product->name }}"
                                required
                            >

                        </div>


                        {{-- VALOR --}}
                        <div class="col-md-4">

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
                                    value="{{ $product->value }}"
                                    required
                                >

                            </div>

                        </div>


                        {{-- CATEGORIA --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Categoria
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Selecione uma categoria
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>

                                @endforeach

                            </select>

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
                                    {{ $product->_status ? 'selected' : '' }}
                                >
                                    Ativo
                                </option>

                                <option
                                    value="0"
                                    {{ !$product->_status ? 'selected' : '' }}
                                >
                                    Inativo
                                </option>

                            </select>

                        </div>


                        {{-- DESCRIÇÃO --}}
                        <div class="col-12">

                            <label class="form-label">
                                Descrição
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                            >{{ $product->description }}</textarea>

                        </div>


                        {{-- IMAGEM ATUAL --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Imagem atual
                            </label>

                            <div>

                                @if($product->image)

                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        style="
                                            width:120px;
                                            height:120px;
                                            object-fit:cover;
                                            border-radius:10px;
                                        "
                                    >

                                @else

                                    <div
                                        class="d-flex align-items-center justify-content-center bg-light"
                                        style="
                                            width:120px;
                                            height:120px;
                                            border-radius:10px;
                                        "
                                    >
                                        <i class="bi bi-image text-muted fs-2"></i>
                                    </div>

                                @endif

                            </div>

                        </div>


                        {{-- NOVA IMAGEM --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Nova imagem
                            </label>

                            <input
                                type="file"
                                name="image"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <small class="text-muted">
                                Deixe vazio para manter a imagem atual.
                            </small>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ADICIONAIS --}}
                        {{-- ================================================= --}}

                        <div class="col-12">

                            <hr>

                            <label class="form-label fw-bold">

                                <i class="bi bi-plus-square"></i>

                                Adicionais do produto

                            </label>

                            <p class="text-muted small">
                                Marque todos os adicionais que poderão ser
                                escolhidos neste produto.
                            </p>


                            @if($additionals && $additionals->count())

                                <div class="row g-2">

                                    @foreach($additionals as $additional)

                                        @php
                                            $productHasAdditional = $product->additionals
                                                ->contains('id', $additional->id);
                                        @endphp


                                        <div class="col-md-6">

                                            <div class="form-check border rounded p-3">

                                                <input
                                                    class="form-check-input ms-0 me-2"
                                                    type="checkbox"
                                                    name="additionals[]"
                                                    value="{{ $additional->id }}"
                                                    id="edit_{{ $product->id }}_addon_{{ $additional->id }}"
                                                    {{ $productHasAdditional ? 'checked' : '' }}
                                                >

                                                <label
                                                    class="form-check-label"
                                                    for="edit_{{ $product->id }}_addon_{{ $additional->id }}"
                                                >

                                                    <strong>
                                                        {{ $additional->name }}
                                                    </strong>

                                                    @if(isset($additional->value))

                                                        <span class="text-muted">

                                                            +

                                                            R$
                                                            {{ number_format($additional->value, 2, ',', '.') }}

                                                        </span>

                                                    @endif

                                                </label>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="alert alert-warning">

                                    Nenhum adicional cadastrado.

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </form>


            {{-- FOOTER --}}
            <div class="modal-footer d-flex justify-content-between">

                {{-- EXCLUIR PERMANENTEMENTE --}}
                <form
                    action="{{ route('admin.products.destroy', $product->id) }}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE este produto? Essa ação não pode ser desfeita.')"
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
                        form="editProductForm{{ $product->id }}"
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

    const searchInput = document.getElementById('searchProduct');
    const categoryFilter = document.getElementById('filterCategory');
    const statusFilter = document.getElementById('filterStatus');

    const rows = document.querySelectorAll('.product-row');


    function filterProducts() {

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const category = categoryFilter.value;

        const status = statusFilter.value;


        rows.forEach(function (row) {

            const name = row.dataset.name;
            const rowCategory = row.dataset.category;
            const rowStatus = row.dataset.status;


            const matchesSearch =
                name.includes(search);


            const matchesCategory =
                !category ||
                rowCategory === category;


            const matchesStatus =
                !status ||
                rowStatus === status;


            if (
                matchesSearch &&
                matchesCategory &&
                matchesStatus
            ) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }


    searchInput.addEventListener(
        'input',
        filterProducts
    );


    categoryFilter.addEventListener(
        'change',
        filterProducts
    );


    statusFilter.addEventListener(
        'change',
        filterProducts
    );

});


/*
|--------------------------------------------------------------------------
| ATIVAR / DESATIVAR (via fetch, sem sair da página)
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