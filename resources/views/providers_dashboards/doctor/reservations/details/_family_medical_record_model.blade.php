<!-- Modal 5 -->
<div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
            <div class="modal-header no-border-bottom close-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body no-border-bottom modal2-spe font-16 print-doctor">
                <h5 class="font_bold mb-3">@lang('doctor.family_records')</h5>


                @forelse ($finishedReservationsFamily as $finishedReservation)
                    <h5 class="font_bold mb-3">@lang('doctor.medical_receipt')</h5>
                    <div class="print-container">
                        <img class="ro-img-spe" src="{{ $finishedReservation->medicalRecord?->ragite?->image }}"
                            alt="">
                        <img class="abb-img-spe" src="{{ $finishedReservation->doctor?->category?->image }}"
                            alt="">
                        {{--  <img class="abb-img-spe"
                                    src="{{asset('dashboard/imgs/318354221_697984298444496_7577338281760416973_n.jpg')}}" alt="">  --}}
                        <div class="abs-contain px-3">

                            <div class="first-flex1">
                                <div class="first-flex1-right text-secondary">
                                    <div class="line11"> @lang('site.paient_name') :
                                        <span>{{ $finishedReservation->name }}</span></div>
                                    <div class="line11">@lang('admin.date') <span>{{ \Carbon\Carbon::parse($finishedReservation->date)->isoFormat('MMMM D YYYY') }}</span>
                                    </div>
                                    <div class="line11">@lang('admin.age') <span>{{ $finishedReservation->age }}</span>
                                    </div>
                                </div>
                                <div class="first-flex1-middle">
                                    <img src="{{ asset('dashboard/imgs/Group 81396.png') }}" alt="" />
                                </div>
                                <div class="first-flex1-left text-center text-secondary">
                                    <div class="line11 black-im">@lang('doctor.dr')
                                        <span>{{ $finishedReservation->doctor?->name }}</span>
                                    </div>
                                    <div class="line11 line222">
                                        {{ $finishedReservation->doctor?->category?->name }}
                                    </div>
                                </div>
                            </div>
                            <div class="overflowx_auto mb-3">
                                <table class="table text-center ticket-table" style="width: 100%">
                                    <thead class="table-head ticket-head">
                                        <tr>
                                            <th class="font10">@lang('doctor.medicine')</th>
                                            <th class="font10">@lang('doctor.medicine_name_number')</th>
                                        </tr>
                                    </thead>
                                    <tbody data-class-name="table-body text-secondary">

                                        @if($finishedReservation->medicalRecord?->medicalRecordMedicans != null)
                                            @foreach ($finishedReservation->medicalRecord?->medicalRecordMedicans as $medicine)
                                                <tr>
                                                    <td class="font12">{{ $medicine->doctorMedicine?->name }}</td>

                                                    <td class="font12">@lang('doctor.medicine_times_hours', ['times' => $medicine->times, 'hours' => $medicine->hours])</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        <tr>
                                            <td class="font12"></td>

                                            <td class="font12"></td>
                                        </tr>
                                        <tr>
                                            <td class="font12"></td>

                                            <td class="font12"></td>
                                        </tr>
                                        <tr>
                                            <td class="font12"></td>

                                            <td class="font12"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="line11 line2211 mt-spe mb-1 ">
                                @lang('admin.address') : <span> {{ $finishedReservation->doctor?->address }}</span>
                            </div>
                            <div class="line11 line2211">@lang('admin.phone'):
                                <span>{{ $finishedReservation->doctor?->phone }}</span>
                            </div>
                        </div>
                        <!-- <div class="bgg-main mt-3 mb-3"></div> -->

                    </div>
                @empty
                    @include('shared.empity')
                @endforelse
            </div>
        </div>
    </div>
</div>
