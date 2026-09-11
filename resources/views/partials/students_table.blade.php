<tbody id="staffTable">

    @forelse($staff as $index => $user)

        <tr>

            <td>
                {{ $staff->firstItem() + $index }}
            </td>

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

            <td>
                {{ $user->phone }}
            </td>

            <td>
                {{ $user->email }}
            </td>

            <td>
                {{ $user->reg_number }}
            </td>

            <td>
                <span class="role-badge">
                    {{ ucfirst($user->role) }}
                </span>
            </td>

            <td>

                <span class="status-badge
                    {{ $user->status === 'active'
                        ? 'status-active'
                        : 'status-inactive' }}">

                    {{ ucfirst($user->status) }}

                </span>

            </td>

            <td class="text-center">

                {{-- EDIT --}}
                <button type="button"
                        class="action-btn action-edit"
                        title="Edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editStudentModal{{ $user->id }}">

                    <i class="bi bi-pencil"></i>

                </button>


                {{-- DELETE --}}
                <form action="{{ route('staff.destroy', $user->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Delete this student?')">

                    @csrf

                    @method('DELETE')

                    <button type="submit"
                            class="action-btn action-delete"
                            title="Delete">

                        <i class="bi bi-trash"></i>

                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="8"
                class="text-center py-4">

                <i class="bi bi-search fs-3 d-block mb-2"></i>

                @if(request('search'))

                    No student found for
                    <strong>"{{ request('search') }}"</strong>

                @else

                    No Student found

                @endif

            </td>

        </tr>

    @endforelse

</tbody>