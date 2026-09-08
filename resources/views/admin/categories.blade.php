@extends('template.admin')

@section('title', 'Categorias')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/categories.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">Categorias</h3>
            <p class="text-muted mb-0">
                Arraste as categorias para alterar a ordem.
            </p>
        </div>

        <div class="d-flex gap-2">

            <button
                type="button"
                class="btn btn-danger"
                id="deleteSelected">
                <i class="bi bi-trash"></i>
                Excluir selecionadas
            </button>

            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#createCategoryModal">
                <i class="bi bi-plus-lg"></i>
                Nova categoria
            </button>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    {{-- LISTA --}}
    <div class="card shadow-sm">

        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center">

                <strong>Categorias</strong>

                <span class="text-muted small">
                    Arraste ☰ para reorganizar
                </span>

            </div>

        </div>


        <div class="list-group list-group-flush"
             id="categoriesList">

            @forelse($categories as $category)

                <div
                    class="list-group-item d-flex align-items-center gap-3 category-item"
                    draggable="true"
                    data-id="{{ $category->id }}">

                    {{-- DRAG --}}
                    <span
                        class="drag-handle text-muted"
                        style="cursor: grab;">
                        <i class="bi bi-grip-vertical fs-5"></i>
                    </span>


                    {{-- CHECKBOX --}}
                    <div class="form-check mb-0">

                        <input
                            class="form-check-input category-checkbox"
                            type="checkbox"
                            value="{{ $category->id }}">

                    </div>


                    {{-- NOME --}}
                    <div class="flex-grow-1">

                        <div class="fw-semibold">
                            {{ $category->name }}
                        </div>

                        <small class="text-muted">
                            ID: {{ $category->id }}
                        </small>

                    </div>


                    {{-- AÇÕES --}}
                    <div class="d-flex gap-2">

                        {{-- EDITAR --}}
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-primary"
                            onclick="editCategory(
                                {{ $category->id }},
                                @js($category->name)
                            )"
                            data-bs-toggle="modal"
                            data-bs-target="#editCategoryModal">

                            <i class="bi bi-pencil"></i>
                            Editar

                        </button>


                        {{-- EXCLUIR --}}
                        <button
                            type="button"
                            class="btn btn-sm btn-outline-danger"
                            onclick="deleteCategory({{ $category->id }})">

                            <i class="bi bi-trash"></i>
                            Remover
                        </button>

                    </div>

                </div>

            @empty

                <div class="text-center py-5">

                    <i class="bi bi-folder-x fs-1 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">
                        Nenhuma categoria cadastrada.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- SALVAR ORDEM --}}
    <div class="mt-3">

        <button
            type="button"
            class="btn btn-success"
            id="saveOrder">

            <i class="bi bi-check-lg"></i>
            Salvar ordem

        </button>

    </div>

</div>


{{-- ================================================= --}}
{{-- MODAL CRIAR --}}
{{-- ================================================= --}}

<div
    class="modal fade"
    id="createCategoryModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
                method="POST"
                action="{{ route('admin.categories.create') }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nova categoria
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Ex: Hambúrgueres"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Criar categoria

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ================================================= --}}
{{-- MODAL EDITAR --}}
{{-- ================================================= --}}

<div
    class="modal fade"
    id="editCategoryModal"
    tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

        <form
            id="editCategoryForm"
            method="POST">

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <h5 class="modal-title">
                        Editar categoria
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="editCategoryName"
                            class="form-control"
                            required>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Salvar alterações

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>

const categoriesList = document.getElementById('categoriesList');

let draggedItem = null;


/*
|--------------------------------------------------------------------------
| DRAG START
|--------------------------------------------------------------------------
*/

categoriesList.addEventListener('dragstart', function (event) {
    draggedItem = event.target.closest('.category-item');

    if (!draggedItem) return;

    draggedItem.classList.add('opacity-50');
});


/*
|--------------------------------------------------------------------------
| DRAG END
|--------------------------------------------------------------------------
*/

categoriesList.addEventListener('dragend', function () {
    if (!draggedItem) return;

    draggedItem.classList.remove('dragging');

    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('drag-over');
    });

    draggedItem = null;
});


/*
|--------------------------------------------------------------------------
| DRAG OVER
|--------------------------------------------------------------------------
*/

categoriesList.addEventListener('dragover', function (event) {
    event.preventDefault();

    const afterElement = getDragAfterElement(
        categoriesList,
        event.clientY
    );

    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('drag-over');
    });

    if (afterElement) {
        afterElement.classList.add('drag-over');

        categoriesList.insertBefore(
            draggedItem,
            afterElement
        );
    } else {
        categoriesList.appendChild(draggedItem);
    }
});


function getDragAfterElement(container, y) {

    const items = [
        ...container.querySelectorAll(
            '.category-item:not(.opacity-50)'
        )
    ];

    return items.reduce(
        (closest, child) => {

            const box =
                child.getBoundingClientRect();

            const offset =
                y -
                box.top -
                box.height / 2;

            if (
                offset < 0 &&
                offset > closest.offset
            ) {

                return {
                    offset,
                    element: child
                };

            }

            return closest;

        },
        {
            offset: Number.NEGATIVE_INFINITY
        }
    ).element;

}


/*
|--------------------------------------------------------------------------
| SALVAR ORDEM
|--------------------------------------------------------------------------
*/

document
    .getElementById('saveOrder')
    .addEventListener('click', async function () {

        const categories = [
            ...document.querySelectorAll('.category-item')
        ];

        const order = categories.map(
            (category, index) => ({
                id: category.dataset.id,
                position: index + 1
            })
        );


        const response = await fetch(
            "{{ route('admin.categories.order') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}',

                    'Accept':
                        'application/json'
                },

                body: JSON.stringify({
                    categories: order
                })
            }
        );


        const data = await response.json();


        if (data.success) {

            alert('Ordem salva com sucesso!');

        } else {

            alert('Erro ao salvar ordem.');

        }

    });


/*
|--------------------------------------------------------------------------
| EDITAR
|--------------------------------------------------------------------------
*/

function editCategory(id, name) {

    document.getElementById(
        'editCategoryName'
    ).value = name;


    document.getElementById(
        'editCategoryForm'
    ).action =
        `/admin/categories/${id}`;

}


/*
|--------------------------------------------------------------------------
| EXCLUIR
|--------------------------------------------------------------------------
*/

async function deleteCategory(id) {

    if (!confirm('Deseja realmente excluir esta categoria?')) {
        return;
    }

    try {

        const response = await fetch(
            `/admin/categories/${id}`,
            {
                method: 'DELETE',

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }
        );

        const data = await response.json();

        if (data.success) {

            location.reload();

        } else {

            alert('Erro ao excluir categoria.');

        }

    } catch (error) {

        console.error(error);

        alert('Erro ao excluir categoria.');

    }
}

/*
|--------------------------------------------------------------------------
| EXCLUIR SELECIONADAS
|--------------------------------------------------------------------------
*/

document
    .getElementById('deleteSelected')
    .addEventListener('click', async function () {

        const selected = [
            ...document.querySelectorAll(
                '.category-checkbox:checked'
            )
        ].map(
            checkbox => checkbox.value
        );


        if (!selected.length) {

            alert(
                'Selecione pelo menos uma categoria.'
            );

            return;

        }


        if (
            !confirm(
                'Deseja excluir as categorias selecionadas?'
            )
        ) {
            return;
        }


        const response = await fetch(
            "{{ route('admin.categories.delete-multiple') }}",
            {
                method: 'DELETE',

                headers: {
                    'Content-Type': 'application/json',

                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}',

                    'Accept':
                        'application/json'
                },

                body: JSON.stringify({
                    ids: selected
                })
            }
        );


        const data = await response.json();


        if (data.success) {

            location.reload();

        } else {

            alert('Erro ao excluir categorias.');

        }

    });

</script>

@endsection