 <!-- Modal 1 -->
 <div class="modal fade" id="EditResultsModal" tabindex="-1" aria-labelledby="EditResultsModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-spe">
         <div class="modal-content">
             <div class="modal-header no-border-bottom">
                 <h5 class="modal-title font_bold" id="EditResultsModalLabel">
                     @lang('localize.edit+_result')
                 </h5>
             </div>
             <div class="modal-body no-border-bottom modal1-spe">
                 <div class="personal-data">
                     <div class="personal-row">
                         <div class="personal-row-part">
                             @lang('localize.patient_name') : <span>{{ $reservation->name }}</span>
                         </div>
                         <div class="personal-row-part">
                             @lang('localize.patient_age') : <span>{{ $reservation->age }}</span>
                         </div>
                         <div class="personal-row-part">
                             @lang('localize.blood_type') :
                             <span>{{ $reservation->reservation_for == 'family' ? $reservation->patientBloodType->name : $reservation->user->bloodType->name }}</span>
                         </div>
                     </div>
                     <div class="personal-row">
                         <div class="personal-row-part">
                             @lang('localize.gender') : <span>{{ __('doctor.' . $reservation->gender) }}</span>
                         </div>
                         <div class="personal-row-part">
                             @lang('localize.ser_num') : <span>{{ $reservation->id }}</span>
                         </div>
                         <div></div>
                     </div>
                 </div>

                 <form action="{{ route('lab.reservations.updateReservationResult') }}"
                     data-success="$('#staticBackdrop').modal('show')" method="POST"
                     class="form form-modal1 add-tome-if">
                     @csrf
                     <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                     @forelse ($reservation->labSubcategoryReservationHasMany->where('result' ,'!=' ,null) as $counter => $addedBeforeResult)
                         <div class="add-if{{ $counter == 0 ? 'f' : '' }}">
                             <div class="mb-3 main-inp-cont">
                                 <h6 class="fontBold mainColor font14">@lang('localize.test_name')</h6>
                                 <select name="lap_results[{{ $counter }}][Lab_subcategory_reservation_id]"
                                     id="" class="default2-select gr">
                                     <option value="" selected disabled>
                                         @lang('localize.choose_test_department')
                                     </option>
                                     @foreach ($reservation->labSubcategoryReservationHasMany as $labResult)
                                         <option {{ $addedBeforeResult->id == $labResult->id ? 'selected' : '' }}
                                             value="{{ $labResult->id }}">
                                             {{ $labResult->SubCategoryLab->labSubCategory->name }}</option>
                                     @endforeach
                                 </select>
                                 <div
                                     class="error_show error_lap_results.{{ $counter }}.Lab_subcategory_reservation_id">
                                 </div>
                             </div>
                             <div class="mb-3 main-inp-cont">
                                 <h6 class="fontBold mainColor font14">@lang('localize.result')</h6>
                                 <div class="form__label">
                                     <input name="lap_results[{{ $counter }}][result]"
                                         value="{{ $addedBeforeResult->result }}" class="default_input" type="text"
                                         placeholder="@lang('localize.pe_test_name')" />
                                     <label class="float__label" for="">@lang('localize.pe_test_name')</label>
                                 </div>
                                 <div class="error_show error_lap_results.{{ $counter }}.result"> </div>

                             </div>

                             @if ($counter == 0)
                                 <div class="work-plus-icon plus-add00 add-spe19 add-if-btn">
                                     <div class="plus-add">+</div>
                                 </div>
                             @endif

                         </div>
                     @empty
                         <div class="add-iff">
                             <div class="mb-3 main-inp-cont">
                                 <h6 class="fontBold mainColor font14">@lang('localize.test_name')</h6>
                                 <select name="lap_results[0][Lab_subcategory_reservation_id]" id=""
                                     class="default2-select gr">
                                     <option value="" selected disabled>
                                         @lang('localize.choose_test_department')
                                     </option>
                                     @foreach ($reservation->labSubcategoryReservationHasMany as $labResult)
                                         <option value="{{ $labResult->id }}">
                                             {{ $labResult->SubCategoryLab->labSubCategory->name }}</option>
                                     @endforeach
                                 </select>
                                 <div class="error_show error_lap_results.0.Lab_subcategory_reservation_id"> </div>
                             </div>
                             <div class="mb-3 main-inp-cont">
                                 <h6 class="fontBold mainColor font14">@lang('localize.result')</h6>
                                 <div class="form__label">
                                     <input name="lap_results[0][result]" class="default_input" type="text"
                                         placeholder="@lang('localize.pe_test_name')" />
                                     <label class="float__label" for="">@lang('localize.pe_test_name')</label>
                                 </div>
                                 <div class="error_show error_lap_results.0.result"> </div>

                             </div>
                             <div class="work-plus-icon plus-add00 add-spe19 add-if-btn">
                                 <div class="plus-add">+</div>
                             </div>
                         </div>
                     @endforelse


                     <div class="mb-3 main-inp-cont">
                         <h6 class="fontBold mainColor font14">@lang('localize.attach_images')</h6>
                         <div class="form__label">
                             <label for="filesNext4_input" class="apload-img-reg">
                                 <input type="file" hidden multiple id="filesNext4_input"
                                     class="heddenUploud files-input" name="images[]" data-input="filesNext4" />
                                 <div class="add-photo">
                                     <i class="fa-solid fa-upload"></i>
                                 </div>
                                 <div class="img-apload-title">@lang('localize.pe_images')</div>
                             </label>
                         </div>
                         <div class="uploaded__area" id="filesNext4_cont">
                             @foreach ($reservation->images as $image)
                                 <div class="file_"> <a data-fancybox="gallery" href="{{ $image->image }}"> <img
                                             src="{{ $image->image }}" alt=""> </a>
                                     <label for="delete_image{{$image}}" class="delete-in-edit" >
                                        <input type="checkbox" class="d-none deleted_images" name="deleted_images[]" value="{{$image->id}}" id="delete_image{{$image}}">
                                        <div class="btn remove_media">
                                            <i class="fa fa-times"></i>
                                        </div>
                                     </label>
                                 </div>
                             @endforeach
                         </div>
                         <div class="error_show error_images"> </div>

                     </div>
                     <div class="mt-3 main-inp-cont">
                         <h6 class="fontBold mainColor mb-1 font14">@lang('localize.report')</h6>
                         <label class="form__label">
                             <textarea class="default_input" name="lab_report" type="text" placeholder="@lang('localize.write_report')">{{$reservation->lab_report}}</textarea>
                             <span class="float__label">@lang('localize.write_report')</span>
                         </label>
                         <div class="error_show error_report"> </div>

                     </div>
                     <div class="d-flex align-items-center justify-content-center">
                         <button class="submit up mt-3 submit-button">
                             @lang('localize.save_and_print')
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>

 <!-- Modal 2 -->
 <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-spe2">
         <div class="modal-content">
             <div class="modal-body no-border-bottom modal2-spe text-center">
                 <img src="imgs/7717-successful.gif" alt="" />
                 <div class="font_bold don-t">@lang('localize.result_updated_successfuly')</div>
                 <div class="d-flex align-items-center justify-content-center">
                     <button type="button" class="submit" data-dismiss="modal">
                         @lang('doctor.done')
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
