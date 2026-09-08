@extends('template.admin')

@section('title', 'Adicionais')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/additional.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Adicionais</h2>
            <p class="text-muted mb-0">
                Gerencie os adicionais da sua loja.
            </p>
        </div>

        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#createAdditionalModal"
        >
            <i class="bi bi-plus-lg"></i>
            Novo adicional
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
                <div class="col-md-8">

                    <label class="form-label">
                        Buscar adicional
                    </label>

                    <input
                        type="text"
                        id="searchAdditional"
                        class="form-control"
                        placeholder="Digite o nome do adicional..."
                    >

                </div>


                {{-- STATUS --}}
                <div class="col-md-4">

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


    {{-- ADICIONAIS --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>
                                Nome
                            </th>

                            <th>
                                Valor
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="180">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody id="additionalsTable">

                        @forelse($additionals as $additional)

                            <tr
                                class="additional-row"
                                data-name="{{ strtolower($additional->name) }}"
                                data-status="{{ $additional->_status ? '1' : '0' }}"
                            >

                                {{-- NOME --}}
                                <td>

                                    <strong>
                                        {{ $additional->name }}
                                    </strong>

                                </td>


                                {{-- VALOR --}}
                                <td>

                                    <strong>
                                        R$ {{ number_format($additional->value, 2, ',', '.') }}
                                    </strong>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($additional->_status)

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
                                            data-bs-target="#editAdditionalModal{{ $additional->id }}"
                                        >
                                            Editar
                                        </button>


                                        {{-- ATIVAR / DESATIVAR --}}
                                        <form
                                            class="toggle-status-form"
                                            action="{{ route('admin.additionals.toggle-status', $additional->id) }}"
                                            method="POST"
                                            data-confirm="Tem certeza que deseja {{ $additional->_status ? 'desativar' : 'ativar' }} este adicional?"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="_status" value="{{ $additional->_status ? 0 : 1 }}">

                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $additional->_status ? 'btn-danger' : 'btn-success' }}"
                                                title="{{ $additional->_status ? 'Desativar' : 'Ativar' }}"
                                            >
                                               
                                                {{ $additional->status ? 'Desativar' : 'Ativar' }}
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        <i
                                            class="bi bi-plus-circle"
                                            style="font-size:40px;"
                                        ></i>

                                        <p class="mt-2 mb-0">
                                            Nenhum adicional cadastrado.
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
{{-- MODAL CRIAR ADICIONAL --}}
{{-- ========================================================= --}}

<div
    class="modal fade"
    id="createAdditionalModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="{{ route('admin.additionals.create') }}"
                method="POST"
            >

                @csrf


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i>
                        Criar adicional
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
                        <div class="col-12">

                            <label class="form-label">
                                Nome do adicional
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Ex: Bacon extra"
                                required
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
                        Criar adicional
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- MODAIS EDITAR --}}
{{-- ========================================================= --}}

@foreach($additionals as $additional)

<div
    class="modal fade"
    id="editAdditionalModal{{ $additional->id }}"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                id="editAdditionalForm{{ $additional->id }}"
                action="{{ route('admin.additionals.update', ['id' => $additional->id]) }}"
                method="POST"
            >
                @csrf
                @method('PUT')


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil"></i>

                        Editar adicional

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
                        <div class="col-12">

                            <label class="form-label">
                                Nome do adicional
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ $additional->name }}"
                                required
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
                                    value="{{ $additional->value }}"
                                    required
                                >

                            </div>

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
                                    {{ $additional->_status ? 'selected' : '' }}
                                >
                                    Ativo
                                </option>

                                <option
                                    value="0"
                                    {{ !$additional->_status ? 'selected' : '' }}
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
                    action="{{ route('admin.additionals.destroy', $additional->id) }}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE este adicional? Essa ação não pode ser desfeita.')"
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
                        form="editAdditionalForm{{ $additional->id }}"
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

    const searchInput = document.getElementById('searchAdditional');
    const statusFilter = document.getElementById('filterStatus');

    const rows = document.querySelectorAll('.additional-row');


    function filterAdditionals() {

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const status = statusFilter.value;


        rows.forEach(function (row) {

            const name = row.dataset.name;
            const rowStatus = row.dataset.status;


            const matchesSearch =
                name.includes(search);


            const matchesStatus =
                !status ||
                rowStatus === status;


            if (
                matchesSearch &&
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
        filterAdditionals
    );


    statusFilter.addEventListener(
        'change',
        filterAdditionals
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