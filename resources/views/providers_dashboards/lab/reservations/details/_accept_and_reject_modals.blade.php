<!-- Modal 1 -->
<div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe2">
        <div class="modal-content">
            <div class="modal-body no-border-bottom modal2-spe">
                <h4 class="font_bold">@lang('site.refuse_order_reason')</h4>
                <form action="{{ route('lab.refuseReservation') }}" method="get" enctype="multipart/form-data"
                    class="form-accept">
                    @csrf
                    <input type="hidden" name="reservation_id" id="reservation_id">
                    <div class="input-icon mb-3">
                        <select name="cancel_reason_id" id="" class="default_input">
                            <option disabled selected value>{{ __('admin.choose') . ' ' . __('admin.cancelreason') }}
                            </option>
                            @foreach ($cancelReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="submit" class="submit submit_button">
                            @lang('site.confirm')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2 accept -->
<div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdrop2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe2">
        <div class="modal-content">
            <div class="modal-body no-border-bottom modal2-spe text-center">
                <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="" />
                <div class="font_bold don-t">
                    @lang('site.order_accepted_follow')
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="submit" data-dismiss="modal">
                        @lang('site.done')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3 refused -->
<div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdrop2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe2">
        <div class="modal-content">
            <div class="modal-body no-border-bottom modal2-spe text-center">
                <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="" />
                <div class="font_bold don-t">@lang('site.order_refused_successfully')</div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="submit" data-dismiss="modal">
                        @lang('site.done')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
