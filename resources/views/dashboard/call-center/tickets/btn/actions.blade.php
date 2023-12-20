@if (get_user_data()->is_active_manager)
<button type="button" class="modal-effect btn btn-sm btn-primary dropdown-item" style="text-align: center !important"
    data-toggle="modal" data-target="#approve" data-effect="effect-scale">
    <span class="icon text-dark text-bold">
        <i class="fa fa-edit"></i>
        Approve
    </span>
</button>

<button type="button" class="modal-effect btn btn-sm btn-danger dropdown-item" style="text-align: center !important"
    data-toggle="modal" data-target="#reject" data-effect="effect-scale">
    <span class="icon text-danger text-bold">
        <i class="fa fa-trash"></i>
        Reject
    </span>
</button>
@else
<a href="{{-- route('CallCenterCaptains.trips',  $captain->profile->uuid) --}}"
    class="modal-effect btn btn-sm btn-dark dropdown-item" style="text-align: center !important">
    <span class="icon text-info text-dark">
        <i class="fa fa-edit"></i>
    </span>
    Show
</a>
@endif
