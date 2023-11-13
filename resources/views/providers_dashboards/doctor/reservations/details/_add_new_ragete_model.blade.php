<!-- Modal 6 -->
<div class="modal fade" id="exampleModal6Rajite" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
            <div class="modal-header no-border-bottom close-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body no-border-bottom modal2-spe font-16 print-doctor">
                <h5 class="font_bold mb-3">@lang('doctor.new_medical_receipt')</h5>
                <form class="form" action="{{ route('doctor.reservations.addPrescriptionForm') }}"
                    method="post">

                    @csrf

                    <div class="print-container">

                        <div class="img-cont-spe">
                            <img src="{{ asset('dashboard/imgs/Component 51 – 1.png') }}" alt=""
                                id="change-profile">
                            <label class="edit-spe" for="img-up"><i class="fa-regular fa-pen-to-square"></i>
                                <input name="image" onchange="loadFiles(event)" type="file" id="img-up"
                                    hidden="">
                            </label>
                            <div class="error_image"></div>
                        </div>

                    </div>
                    <div class="flex-ticket-btn mt-3">
                        <button class="up submit-button next-print font-bold ">@lang('admin.add')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
