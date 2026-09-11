<div id="supervisorsContent">

    <div class="table-responsive">

        <table class="table table-striped table-sm">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>

                </tr>

            </thead>


            <tbody id="staffTable">

                @forelse($staff as $index => $user)

                    <tr>

                        {{-- NUMBER --}}
                        <td>

                            {{ $staff->firstItem() + $index }}

                        </td>


                        {{-- NAME --}}
                        <td>

                            <div class="staff-info">

                                <div class="staff-avatar">

                                    <i class="bi bi-person"></i>

                                </div>

                                <div class="staff-name">

                                    {{ $user->firstname }}
                                    {{ $user->middlename }}
                                    {{ $user->lastname }}

                                </div>

                            </div>

                        </td>


                        {{-- PHONE --}}
                        <td>

                            {{ $user->phone }}

                        </td>


                        {{-- EMAIL --}}
                        <td>

                            {{ $user->email }}

                        </td>


                        {{-- ROLE --}}
                        <td>

                            <span class="role-badge">

                                Supervisor

                            </span>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            <span class="status-badge
                                {{ $user->status === 'active'
                                    ? 'status-active'
                                    : 'status-inactive' }}">

                                {{ ucfirst($user->status) }}

                            </span>

                        </td>


                        {{-- ACTION --}}
                        <td class="text-center">


                            {{-- EDIT BUTTON --}}
                            <button
                                type="button"
                                class="action-btn action-edit"
                                title="Edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editStaffModal{{ $user->id }}">

                                <i class="bi bi-pencil"></i>

                            </button>


                            {{-- DELETE --}}
                            <form
                                action="{{ route('staff.destroy', $user->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Delete this staff?')">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="action-btn action-delete"
                                    title="Delete">

                                    <i class="bi bi-trash"></i>

                                </button>

                            </form>


                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-5">

                            <i class="bi bi-search fs-3 d-block mb-2"></i>

                            @if(request('search'))

                                No supervisor found for
                                <strong>"{{ request('search') }}"</strong>

                            @else

                                No supervisor found

                            @endif

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">

        {{ $staff->links() }}

    </div>


    {{-- EDIT MODALS --}}
    @foreach($staff as $user)

        <div
            class="modal fade"
            id="editStaffModal{{ $user->id }}"
            tabindex="-1"
            aria-labelledby="editStaffLabel{{ $user->id }}"
            aria-hidden="true">

            <div class="modal-dialog modal-lg modal-dialog-centered">

                <div class="modal-content">


                    {{-- HEADER --}}
                    <div class="modal-header">

                        <h5
                            class="modal-title"
                            id="editStaffLabel{{ $user->id }}">

                            <i class="bi bi-person-gear me-2"></i>

                            Edit Supervisor's info

                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">

                        </button>

                    </div>


                    {{-- FORM --}}
                    <form
                        action="{{ route('staff.update', $user->id) }}"
                        method="POST">

                        @csrf

                        @method('PUT')


                        <div class="modal-body">

                            <div class="row g-3">


                                {{-- FIRST NAME --}}
                                <div class="col-md-4">

                                    <label class="form-label">

                                        First Name

                                    </label>

                                    <input
                                        type="text"
                                        name="firstname"
                                        class="form-control"
                                        value="{{ $user->firstname }}"
                                        required>

                                </div>


                                {{-- MIDDLE NAME --}}
                                <div class="col-md-4">

                                    <label class="form-label">

                                        Middle Name

                                    </label>

                                    <input
                                        type="text"
                                        name="middlename"
                                        class="form-control"
                                        value="{{ $user->middlename }}">

                                </div>


                                {{-- LAST NAME --}}
                                <div class="col-md-4">

                                    <label class="form-label">

                                        Last Name

                                    </label>

                                    <input
                                        type="text"
                                        name="lastname"
                                        class="form-control"
                                        value="{{ $user->lastname }}"
                                        required>

                                </div>


                                {{-- PHONE --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Phone

                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control"
                                        value="{{ $user->phone }}"
                                        required>

                                </div>


                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Email

                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ $user->email }}"
                                        required>

                                </div>


                                {{-- ROLE --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Role

                                    </label>

                                    <select
                                        name="role"
                                        class="form-select"
                                        required>

                                        <option
                                            value="admin"
                                            {{ $user->role === 'admin' ? 'selected' : '' }}>

                                            Admin

                                        </option>

                                        <option
                                            value="supervisors"
                                            {{ $user->role === 'supervisors' ? 'selected' : '' }}>

                                            Supervisor

                                        </option>


                                    </select>

                                </div>


                                {{-- STATUS --}}
                                <div class="col-md-6">

                                    <label class="form-label">

                                        Status

                                    </label>

                                    <select
                                        name="status"
                                        class="form-select"
                                        required>

                                        <option
                                            value="active"
                                            {{ $user->status === 'active' ? 'selected' : '' }}>

                                            Active

                                        </option>

                                        <option
                                            value="inactive"
                                            {{ $user->status === 'inactive' ? 'selected' : '' }}>

                                            Inactive

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
                                data-bs-dismiss="modal">

                                <i class="bi bi-x-circle me-1"></i>

                                Cancel

                            </button>


                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-check-circle me-1"></i>

                                Update Staff

                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    @endforeach

</div>