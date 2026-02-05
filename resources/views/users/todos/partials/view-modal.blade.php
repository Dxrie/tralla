{{-- View Modal --}}
<div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header">
                <h5 class="modal-title">View To-Do Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-tag-fill me-2"></i>Title
                                </h6>
                                <p id="viewTitle" class="card-text fw-semibold mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-info mb-3">
                                    <i class="bi bi-info-circle-fill me-2"></i>Status
                                </h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <button type="button" id="prevStatusBtn" class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <span id="currentStatus" class="text-center flex-grow-1 status-transition" style="min-width: 120px;">
                                        <span id="statusBadge" class="badge rounded-pill"></span>
                                    </span>
                                    <button type="button" id="nextStatusBtn" class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                    <input type="hidden" id="statusValue">
                                    <input type="hidden" id="todoIdForStatus">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-success mb-3">
                                    <i class="bi bi-file-text-fill me-2"></i>Description
                                </h6>
                                <p id="viewDescription" class="card-text text-wrap" style="word-wrap: break-word; white-space: pre-wrap;"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-warning mb-3">
                                    <i class="bi bi-calendar-event-fill me-2"></i>Starting Date
                                </h6>
                                <p id="viewStartDate" class="card-text mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-danger mb-3">
                                    <i class="bi bi-calendar-check-fill me-2"></i>Finish Date
                                </h6>
                                <p id="viewFinishDate" class="card-text mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="background: rgba(255,255,255,0.8);">
                            <div class="card-body">
                                <h6 class="card-title text-secondary mb-3">
                                    <i class="bi bi-list-check me-2"></i>Subtasks
                                </h6>
                                <div id="viewSubtasks">
                                    <!-- Subtasks will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
