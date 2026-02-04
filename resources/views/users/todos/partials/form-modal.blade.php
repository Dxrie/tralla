<div class="modal fade" id="todoModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header">
                <h5 class="modal-title" id="todoModalTitle">New To-Do</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="todoForm">
                @csrf

                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="todo_id" id="todoId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text"
                            name="title"
                            class="form-control form-control-sm"
                            value="{{ old('title') }}"
                           >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subtasks</label>
                        <div id="subtasksWrapper">
                        </div>

                        <button type="button" id="addSubtaskBtn" class="btn btn-outline-primary btn-sm" style="border-style: dashed; width: 100%">
                            <i class="bi bi-plus-lg"></i> Add Subtask
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text"
                            name="description"
                            class="form-control form-control-sm"
                            value="{{ old('description') }}"
                           >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="to-do" {{ old('status') == 'to-do' ? 'selected' : '' }}>To-Do</option>
                            <option value="on progress" {{ old('status') == 'on progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="hold" {{ old('status') == 'hold' ? 'selected' : '' }}>Hold</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Starting Date</label>
                        <input type="date"
                            name="start_date"
                            class="form-control form-control-sm"
                            value="{{ old('start_date', date('Y-m-d')) }}"
                           >
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Finish Date</label>
                        <input type="date"
                            name="finish_date"
                            class="form-control form-control-sm"
                            value="{{ old('finish_date', date('Y-m-d')) }}"
                           >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger buttons" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="spinner-border spinner-border-sm d-none" id="submitSpinner"></i>
                        <span id="submitBtnText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
