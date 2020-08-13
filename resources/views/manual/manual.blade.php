@extends('main')

@section('manualSanitation')

<div class="container-fluid">
    <div class="straight-bar mt-2" style="border:2px solid gray;"></div>
    <div class="row">
        <div class="col-md-6 text-left">
            <button type="button" class="btn btn-danger m-3" id="unidentifiedBtn" data-toggle="modal" data-target="#unidentifiedDoctor">
                UnIdentified
              </button>
        </div>

        
        
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success m-3" data-toggle="modal" data-target="#assignToDoctor">
                Assign to Doctor
            </button>
        </div>
    </div>
    
            <div class="form-group">
                <label for="showHide">Show/Hide Column:</label>
                <select class="selectpicker" id="selectColShowHide" multiple data-selected-text-format="count"> 
                    <option value="0">ID</option>
                    <option value="1">Doctor</option>
                    <option value="2">Sanitized Name</option>
                    <option value="3">Status</option>
                    <option value="4">License</option>
                    <option value="5">Amount</option>
                    <option value="6">Address</option>
                    <option value="7">LBU Code</option>
                </select>
            </div>
       

    <div class="row ">
        <div class="col-md-12">
            <table class=" table table-striped table-hover table-bordered display nowrap" id="unsanitizedTable" style="width:100%;" >
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> Doctor </th>
                        <th> Sanitized Name</th>
                        <th> Status </th>
                        <th> License </th>
                        <th> Amount </th>
                        <th> Address </th>
                        <th> LBU Code </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="modal-container">
            <!-- Modal unidentified Doctor-->
                <div class="modal fade" id="unidentifiedDoctorModal" tabindex="-1" role="dialog" aria-labelledby="unidentifiedDoctorModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title " id="unidentifiedDoctorModalLabel">Unidentified</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" >&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-hover table-bordered table-responsive" id="unidentifiedTable">
                                    <thead>
                                        <tr>
                                            <th> ID </th>
                                            <th> Doctor </th>
                                            <th> Sanitized Name</th>
                                            <th> License </th>
                                            <th> Address </th>
                                            <th> LBU Code </th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger">UnIdentified</button>
                    </div>
                    </div>
                    </div>
                </div>{{-- end of unidentified modal --}}

             <!-- Modal Assign to Doctor-->
             <div class="modal fade" id="assignToDoctor" tabindex="-1" role="dialog" aria-labelledby="assignToDoctorLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-success">
                      <h5 class="modal-title" id="assignToDoctorLabel">Assign to Doctor</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                        <h6>Class: </h6>
                            <select class="form-control" id="md_class" name="md_class">
                                <option value="ALL">ALL</option>
                                <option value="FOR RECRUITMENT">FOR RECRUITMENT</option>
                                <option value="IPG">IPG</option>
                                <option value="IPG-D">IPG-D</option>
                                <option value="JEDI">JEDI</option>
                                <option value="PROS">PROS</option>
                                <option value="JEDI-IPGD">JEDI-IPGD</option>
                                <option value="JEDI-NEPHRO">JEDI-NEPHRO</option>
                                <option value="NEPHRO">NEPHRO</option>
                                <option value="NON-GROUP">NON-GROUP</option>
                                <option value="NON-PROS">NON-PROS</option>
                                <option value="PADAWAN">PADAWAN</option>
                                <option value="PROS">PROS</option>
                                <option value="REMOVED">REMOVED</option>
                            </select>

                             <div class="form-group">
                                <label>Doctor: </label>
                                <span class="float-right">
                                    <a href="#addNewDoctor"  data-toggle="modal" data-target="#addNewDoctor">
                                    Add New Doctor</a>
                                </span>
                                    <input id="doctor_list_other" name="doctor_list_other" placeholder="Lastname, firstname"  class="form-control">
                                    <input  type="hidden" id="md_code_other" name="md_code_other" class="form-control">

                                   {{--  <select name="unsanitized_name" class="js-example-basic-single form-control" id=""></select> --}}
                             </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-success">Assign</button>
                    </div>
                  </div>
                </div>
              </div>{{-- end of assign doctor modal --}}

            <!-- Modal Assign to Doctor-->
            <div class="modal fade" id="addNewDoctor" tabindex="-1" role="dialog" aria-labelledby="addNewDoctorLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                   
                    <div class="modal-content">

                        <div class="modal-header bg-primary">
                            <h5 class="modal-title " id="addNewDoctorLabel">Add Doctor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" >&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label for="md_name"><strong> MD Name: </strong></label>
                                <input type="text" class="form-control" placeholder="Lastname, Firstname">
                            </div>


                            <div class="form-group">
                                <label for="md_code"><strong> MD Code: </strong></label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>MD Status:</label>
                                  <select class="form-control" id="md_status" name="md_status">
                                    <option value="JEDI">JEDI</option>
                                    <option value="IPG">IPG</option>
                                    <option value="EVEREST">EVEREST</option>
                                    <option value="POSEIDON">POSEIDON</option>
                                    <option value="OTHER SPARTAN">OTHER SPARTAN</option>
                                    <option value="OLYMPUS">OLYMPUS</option>
                                    <option value="TITAN">TITAN</option>
                                    <option value="NOT IN THE MASTERLIST">NOT IN THE MASTERLIST</option>
                                    <option value="UNCLASSIFIED">UNCLASSIFIED</option>
                                  </select>
                              </div>

                            <div class="form-group">
                                <label for="md_universe"><strong> MD Universe: </strong></label>
                                <input type="text" class="form-control">
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success">Assign</button>
                        </div>
                    </div>
                </div>
            </div>{{-- end of add Doctor --}}
        </div>{{-- end of modal container--}}
    </div> {{-- end of row --}}
</div> {{-- end of container --}}



@push('manualSanitation-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/manual/manual.js') }}"></script>
@endpush

@endsection